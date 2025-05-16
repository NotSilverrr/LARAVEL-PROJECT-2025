const columns = document.querySelectorAll('[id^="kanban-column-"]');
const tasks = document.querySelectorAll('[id^="kanban-task-"]');


columns.forEach(column => {
    let dragCounter = 0;
    console.log(column.querySelector('.kanban-task-list'))
    column.addEventListener('dragover', (event) => columnDragOver(event));
    column.addEventListener('drop', (event) => {
        event.preventDefault();
        dragCounter = 0;
        column.classList.remove('drag-over');
        const taskId = event.dataTransfer.getData('text/plain');
        const task = document.getElementById(taskId);
        console.log('drop', taskId);

        if (task) {
            const tasksList = column.querySelector('.kanban-task-list');
            console.log('tasksList', tasksList);
            tasksList.appendChild(task);
            task.classList.remove('dragging');
            const idTask = taskId.split('-')[2];
            console.log('idTask', idTask);
            const idColumn = column.id.split('-')[2];
            console.log('idColumn', idColumn);
            updateTaskPosition(idTask, idColumn);
        }
    });
    column.addEventListener('dragenter', (event) => {
        event.preventDefault();
        dragCounter++;
        column.classList.add('drag-over');
    });

    column.addEventListener('dragleave', (event) => {
        event.preventDefault();
        dragCounter--;
        if (dragCounter === 0) {
            column.classList.remove('drag-over');
        }
    });
});

tasks.forEach(task => {
    task.addEventListener('dragstart', (event) => {taskDragStart(event, task)});
    task.addEventListener('dragend', () => taskDragEnd(event, task));
});


function columnDragOver(event) {
    event.preventDefault();
    event.dataTransfer.dropEffect = 'move';
}

function columnDrop(event, column) {
    
}

function taskDragStart(event, task) {
    console.log('dragstart');
    event.dataTransfer.setData('text/plain', task.id);

    // 🔐 Stocke l'ID de la colonne d'origine dans un attribut
    const originColumn = task.closest('[id^="kanban-column-"]');
    if (originColumn) {
        task.dataset.originColumnId = originColumn.id;
    }

    task.classList.add('dragging');
}

function taskDragEnd(event, task) {
    console.log('dragend');
    task.classList.remove('dragging');
}

function updateTaskPosition(taskId, columnId) {
    console.log('updateTaskPosition', taskId, columnId);
    
    fetch(`/api/tasks/${taskId}/moveColumn/${columnId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ taskId, columnId })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur lors de la mise à jour');
        }
        return response.json();
    })
    .then(data => {
        console.log('Task position updated:', data);
    })
    .catch(error => {
        console.error('Error updating task position:', error);

        // 🚨 Replacer la tâche dans sa colonne d'origine
        const task = document.getElementById(`kanban-task-${taskId}`);
        const originColumnId = task?.dataset.originColumnId;
        if (originColumnId) {
            const originColumn = document.getElementById(originColumnId);
            const originList = originColumn?.querySelector('.kanban-task-list');
            if (originList) {
                originList.appendChild(task);
            }
        }

        // Optionnel : afficher une erreur à l'utilisateur
    });
}
