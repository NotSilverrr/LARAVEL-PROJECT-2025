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

        // Si l'utilisateur est connecté
        if (Auth::check()) {
            $user = Auth::user();
            // Vérifier que l'email de l'utilisateur correspond à l'email de l'invitation
            if ($user->email !== $invitation->email) {
                return redirect()->route('dashboard')->with('error', "Tu es connecté avec un autre compte que celui invité (" . $invitation->email . ").");
            }
            // Vérifier que l'utilisateur n'est pas déjà membre du projet
            if ($invitation->project->users()->where('user_id', $user->id)->exists()) {
                $invitation->delete(); // On peut supprimer l'invitation car il est déjà membre
                return redirect()->route('projects.show', $invitation->project)
                    ->with('info', 'Tu fais déjà partie de ce projet.');
            }
            // Ajouter l'utilisateur au projet
            $invitation->project->users()->attach($user->id, ['role' => 'member']);
            $invitation->delete();
            return redirect()->route('projects.show', $invitation->project)
                ->with('success', 'Tu as rejoint le projet avec succès !');
        }

        // Si l'utilisateur n'est pas connecté
        $existingUser = User::where('email', $invitation->email)->first();
        if ($existingUser) {
            // Stocker le token en session pour l'utiliser après connexion
            session(['invitation_token' => $token]);
            return redirect()->route('login')->with('info', 'Connecte-toi pour rejoindre le projet.');
        } else {
            // Afficher la page d'inscription avec l'email pré-rempli
            return view('auth.register-invite', ['invitation' => $invitation]);
        }
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

        dd('register');


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

    public function postLoginInvitation()
    {

        $token = session('invitation_token');

        if (!$token) {
            return redirect()->route('dashboard');
        }
        $invitation = ProjectInvitation::where('token', $token)->first();
        if ($invitation && Auth::check() && Auth::user()->email === $invitation->email) {
            if (!$invitation->project->users()->where('user_id', Auth::id())->exists()) {
                $invitation->project->users()->attach(Auth::id(), ['role' => 'member']);
            }
            $invitation->delete();
            session()->forget('invitation_token');
            return redirect()->route('projects.view.list', $invitation->project)
                ->with('success', 'Tu as rejoint le projet avec succès !');
        }
        session()->forget('invitation_token');
        return redirect()->route('dashboard');
    }
}
