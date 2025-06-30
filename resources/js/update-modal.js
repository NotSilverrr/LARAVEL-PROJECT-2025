document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".task-list-row").forEach(function (row) {
        row.addEventListener("click", function (e) {
            if (e.target.closest("a")) return;
            var taskId = this.getAttribute("data-task-id");
            var modal = document.getElementById("modal-edit-task-" + taskId);
            if (modal) {
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            }
        });
    });
    document.querySelectorAll(".task-calendar-item").forEach(function (el) {
        el.addEventListener("click", function () {
            var taskId = this.getAttribute("data-task-id");
            var modal = document.getElementById("modal-edit-task-" + taskId);
            if (modal) {
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            }
        });
    });
    document.querySelectorAll(".task-kanban-item").forEach(function (el) {
        el.addEventListener("click", function () {
            var taskId = this.getAttribute("data-task-id");
            var modal = document.getElementById("modal-edit-task-" + taskId);
            if (modal) {
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            }
        });
    });
    document.querySelectorAll(".modal-close").forEach(function (btn) {
        btn.addEventListener("click", function () {
            var modal = btn.closest(".modal");
            if (modal) {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            }
        });
    });
    document.querySelectorAll(".modal").forEach(function (modal) {
        modal.addEventListener("mousedown", function (e) {
            if (e.target === modal) {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            }
        });
    });
});
