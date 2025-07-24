<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterProjectInvitationRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules() {
        return [
            'token' => 'required',
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
        ];
    }
}
