<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle tâche assignée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #10b981;
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f8fafc;
            padding: 20px;
            border: 1px solid #e2e8f0;
        }
        .footer {
            background-color: #1e293b;
            color: white;
            padding: 15px;
            border-radius: 0 0 8px 8px;
            text-align: center;
        }
        .task-details {
            background-color: white;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
        }
        .label {
            font-weight: bold;
            color: #1e293b;
        }
        .priority {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .priority-high { background-color: #fee2e2; color: #dc2626; }
        .priority-medium { background-color: #fef3c7; color: #d97706; }
        .priority-low { background-color: #dcfce7; color: #16a34a; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎯 Vous avez été assigné(e) à une tâche</h1>
    </div>
    
    <div class="content">
        <p>Bonjour <strong>{{ $user->firstname }} {{ $user->lastname }}</strong>,</p>
        
        <p>Vous avez été assigné(e) à une nouvelle tâche dans le projet <strong>{{ $project->name }}</strong>.</p>
        
        <div class="task-details">
            <h3>📋 Détails de la tâche</h3>
            
            <p><span class="label">Titre :</span> {{ $task->title }}</p>
            
            @if($task->description)
            <p><span class="label">Description :</span><br>{{ $task->description }}</p>
            @endif
            
            <p><span class="label">Priorité :</span> 
                <span class="priority priority-{{ $task->priority }}">{{ $task->priority }}</span>
            </p>
            
            <p><span class="label">Statut :</span> 
                @switch($task->status)
                    @case('todo')
                        📝 À faire
                        @break
                    @case('in_progress')
                        🔄 En cours
                        @break
                    @case('done')
                        ✅ Terminé
                        @break
                    @default
                        {{ $task->status }}
                @endswitch
            </p>
            
            @if($task->date_start)
            <p><span class="label">Date de début :</span> {{ $task->date_start->format('d/m/Y à H:i') }}</p>
            @endif
            
            @if($task->date_end)
            <p><span class="label">Date de fin :</span> {{ $task->date_end->format('d/m/Y à H:i') }}</p>
            @endif
            
            @if($task->category)
            <p><span class="label">Catégorie :</span> {{ $task->category->name }}</p>
            @endif
            
            @if($task->column)
            <p><span class="label">Colonne :</span> {{ $task->column->name }}</p>
            @endif
            
            @if($task->creator)
            <p><span class="label">Créé par :</span> {{ $task->creator->firstname }} {{ $task->creator->lastname }}</p>
            @endif
        </div>
        
        <p>N'hésitez pas à vous connecter à votre espace de travail pour commencer à travailler sur cette tâche.</p>
        
        <p>Bonne journée ! 🚀</p>
    </div>
    
    <div class="footer">
        <p>Cet email a été envoyé automatiquement. Merci de ne pas y répondre.</p>
    </div>
</body>
</html>
