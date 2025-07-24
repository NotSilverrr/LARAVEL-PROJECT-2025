<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectUserRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules() {
        return [ 'role' => 'required|in:owner,admin,member' ];
    }
}
