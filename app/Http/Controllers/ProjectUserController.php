<?php

namespace App\Http\Controllers;

use App\Mail\ProjectInvitationMail;
use App\Models\Project;
use App\Models\ProjectInvitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProjectUserController extends Controller
{
    public function index(Project $project) {
        $users = $project->users()->withPivot('role')->paginate(10);
        return view('projects.users.index', compact('project', 'users'));
    }

    public function store(Request $request, Project $project) {
        
    }

    public function inviteUserToProject(Request $request, Project $project) {

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
        // Vérifier que l'utilisateur à supprimer n'est pas le créateur du projet
        if ($project->created_by == $user->id) {
            return back()->with('error', 'Impossible de supprimer le créateur du projet.');
        }
        // Détacher l'utilisateur du projet
        $project->users()->detach($user->id);
        return back()->with('success', 'Utilisateur supprimé du projet avec succès.');
    }

    public function history(Project $project, User $user)
    {
        $activities = \Spatie\Activitylog\Models\Activity::where('causer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('projects.users.history', compact('project', 'user', 'activities'));
    }
}
