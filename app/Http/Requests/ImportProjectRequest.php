<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportProjectRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules() {
        return [
            'file' => 'required|file|mimes:xlsx,csv,xls',
        ];
    }
}
