<?php

namespace App\Http\Controllers;

use App\Models\ProjectInvitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProjectInvitationController extends Controller
{
    public function accept($token)
    {
        $invitation = ProjectInvitation::where('token', $token)->firstOrFail();

        // Vérifier si l'invitation a expiré
        if ($invitation->isExpired()) {
            abort(403, 'Cette invitation a expiré.');
        }

        // Si l'utilisateur est connecté, on l'ajoute au projet directement
        if (Auth::check()) {
            $invitation->project->users()->attach(Auth::id(), ['role' => 'member']);
            $invitation->delete();

            return redirect()->route('projects.show', $invitation->project)
                ->with('success', 'Tu as rejoint le projet avec succès !');
        }

        // Sinon, on redirige vers la page d'inscription avec le token et l'email de l'invitation
        return view('auth.register-invite', ['invitation' => $invitation]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Vérifier l'invitation
        $invitation = ProjectInvitation::where('token', $request->token)->firstOrFail();

        if ($invitation->isExpired()) {
            abort(403, 'Cette invitation a expiré.');
        }

        // Vérifier si l'utilisateur existe déjà
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Créer un nouvel utilisateur
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }

        // Connecter l'utilisateur
        Auth::login($user);

        // Ajouter l'utilisateur au projet
        $invitation->project->users()->attach($user->id, ['role' => 'member']);

        // Supprimer l'invitation
        $invitation->delete();

        return redirect()->route('projects.view.list', $invitation->project)
            ->with('success', 'Compte créé et projet rejoint avec succès !');
    }
}
