<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Mail\ProjectInvitationMail;
use App\Models\Project;
use App\Models\ProjectInvitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProjectUserController extends Controller
{
    use AuthorizesRequests;
    public function index(Project $project) {
        $this->authorize('manageMembers', $project);
        $users = $project->users()->withPivot('role')->paginate(10);
        return view('projects.users.index', compact('project', 'users'));
    }

    public function store(Request $request, Project $project) {
        
    }

    public function inviteUserToProject(Request $request, Project $project) {
        $this->authorize('manageMembers', $project);

        // Valider la requête
        $request->validate([
            'email' => 'required|email',
        ]);
        // Vérifier si l'utilisateur est déjà membre du projet
        $user = User::where('email', $request->email)->first();
        if ($user && $project->users()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Cet utilisateur est déjà membre du projet.');
        }
        // Créer un token d'invitation unique
        $token = Str::random(40);

        // Enregistrer l'invitation avec un délai d'expiration
        $invitation = ProjectInvitation::create([
            'project_id' => $project->id,
            'email' => $request->email,
            'token' => $token,
            'expires_at' => now()->addDays(2), // expiration dans 2 jours
        ]);

        // Créer l'URL d'invitation avec token
        $url = route('projects.invitations.accept', ['token' => $token]);

        // Envoyer l'email d'invitation
        Mail::to($request->email)->send(new ProjectInvitationMail($project, $url));

        return back()->with('success', 'Invitation envoyée avec succès !');
    }
    
    public function destroy(Project $project, User $user)
    {
        $this->authorize('manageMembers', $project);
        // Vérifier que l'utilisateur à supprimer n'est pas le créateur du projet
        if ($project->created_by == $user->id) {
            return back()->with('error', 'Impossible de supprimer le créateur du projet.');
        }
        // Détacher l'utilisateur du projet
        $project->users()->detach($user->id);
        return back()->with('success', 'Utilisateur supprimé du projet avec succès.');
    }

    public function edit(Project $project, User $user)
    {
        $this->authorize('manageMembers', $project);
        if (!$project->users()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Utilisateur non membre du projet.');
        }
        $pivot = $project->users()->where('user_id', $user->id)->first()?->pivot;
        return view('projects.users.edit', compact('project', 'user', 'pivot'));
    }

    public function update(Request $request, Project $project, User $user)
    {
        $this->authorize('manageMembers', $project);
        // Ensure user is part of the project
        if (!$project->users()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Utilisateur non membre du projet.');
        }
        $request->validate([
            'role' => 'required|in:owner,admin,member',
        ]);
        $project->users()->updateExistingPivot($user->id, ['role' => $request->role]);
        return redirect()->route('projects.users.index', $project)->with('success', 'Rôle mis à jour avec succès.');

      public function history(Project $project, User $user)
    {
        $activities = \Spatie\Activitylog\Models\Activity::where('causer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('projects.users.history', compact('project', 'user', 'activities'));
    }
}
