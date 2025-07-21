# Système de Notifications Email pour les Tâches

Ce document explique le système d'événements et de notifications email mis en place pour les tâches.

## Vue d'ensemble

Le système envoie automatiquement des emails dans les cas suivants :
1. **Création d'une tâche** avec des utilisateurs assignés
2. **Assignation d'un nouvel utilisateur** à une tâche existante

## Architecture

### Événements (Events)

#### 1. TaskCreated
- **Fichier** : `app/Events/TaskCreated.php`
- **Déclenchement** : Lorsqu'une tâche est créée avec des utilisateurs assignés
- **Données** : L'objet Task

#### 2. UserAddedToTask
- **Fichier** : `app/Events/UserAddedToTask.php`
- **Déclenchement** : Lorsqu'un utilisateur est assigné à une tâche existante
- **Données** : L'objet Task et l'objet User

### Listeners (Écouteurs)

#### 1. SendTaskCreatedNotification
- **Fichier** : `app/Listeners/SendTaskCreatedNotification.php`
- **Action** : Envoie un email à tous les utilisateurs assignés à la nouvelle tâche
- **Email utilisé** : `NewTaskCreatedMail`

#### 2. SendUserAddedToTaskNotification
- **Fichier** : `app/Listeners/SendUserAddedToTaskNotification.php`
- **Action** : Envoie un email au nouvel utilisateur assigné
- **Email utilisé** : `TaskAssignedMail`

### Classes Mail

#### 1. NewTaskCreatedMail
- **Fichier** : `app/Mail/NewTaskCreatedMail.php`
- **Sujet** : "Nouvelle tâche créée: [titre de la tâche]"
- **Template** : `resources/views/emails/new-task-created.blade.php`

#### 2. TaskAssignedMail
- **Fichier** : `app/Mail/TaskAssignedMail.php`
- **Sujet** : "Nouvelle tâche assignée: [titre de la tâche]"
- **Template** : `resources/views/emails/task-assigned.blade.php`

## Utilisation

### Dans le Contrôleur

```php
// Créer une tâche avec assignation automatique
$task = Task::create([...]);
$task->assignUsers([1, 2, 3]); // IDs des utilisateurs

// Assigner un utilisateur à une tâche existante
$task->assignUser($user);
```

### Nouvelles Méthodes du Modèle Task

#### `assignUser(User $user)`
- Assigne un utilisateur à la tâche
- Vérifie qu'il n'est pas déjà assigné
- Déclenche automatiquement l'événement `UserAddedToTask`

#### `assignUsers(array $userIds)`
- Assigne plusieurs utilisateurs en une fois
- Utilise `assignUser()` en interne pour chaque utilisateur

### Routes API Disponibles

#### Assigner un utilisateur
```
POST /tasks/{task}/assign-user
Body: { "user_id": 123 }
```

#### Retirer un utilisateur
```
DELETE /tasks/{task}/unassign-user
Body: { "user_id": 123 }
```

#### Test des notifications (développement uniquement)
```
GET /test-email-notification
```

## Templates Email

Les emails sont stylés avec du CSS inline et incluent :
- **Header coloré** avec icône
- **Détails de la tâche** : titre, description, priorité, statut, dates, catégorie, colonne
- **Informations sur le projet**
- **Design responsive**

### Personnalisation des Priorités
- **High** : Badge rouge
- **Medium** : Badge orange  
- **Low** : Badge vert

### Statuts Traduits
- `todo` → 📝 À faire
- `in_progress` → 🔄 En cours
- `done` → ✅ Terminé

## Configuration

### Enregistrement des Événements
Les événements sont enregistrés dans `app/Providers/AppServiceProvider.php` :

```php
Event::listen(TaskCreated::class, SendTaskCreatedNotification::class);
Event::listen(UserAddedToTask::class, SendUserAddedToTaskNotification::class);
```

### Configuration Email
Assurez-vous que la configuration email est correcte dans `.env` :

```env
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Files de Messages (Queue)

Les classes Mail implémentent `ShouldQueue`, ce qui signifie que :
- Les emails sont traités en arrière-plan
- Améliore les performances de l'application
- Nécessite de configurer et lancer les workers de queue

Pour traiter les emails immédiatement en développement :
```bash
php artisan queue:work
```

## Test et Débogage

### Route de Test
Visitez `/test-email-notification` pour créer une tâche de test et déclencher l'envoi d'un email.

### Visualisation des Emails
Avec Laravel Sail, Mailpit est disponible sur `http://localhost:8025` pour voir tous les emails envoyés.

### Logs
Les erreurs d'envoi d'email sont loggées dans `storage/logs/laravel.log`.

## Bonnes Pratiques

1. **Vérification avant envoi** : Le système vérifie que l'utilisateur n'est pas déjà assigné
2. **Gestion des erreurs** : Les listeners implémentent `ShouldQueue` avec gestion d'erreur automatique
3. **Templates responsives** : Les emails s'adaptent aux différents clients email
4. **Données complètes** : Tous les détails de la tâche sont inclus dans l'email

## Extension Possible

Le système peut être facilement étendu pour :
- Notifications lors de changements de statut
- Rappels avant échéance
- Notifications pour les commentaires
- Intégration avec des services externes (Slack, Discord, etc.)
