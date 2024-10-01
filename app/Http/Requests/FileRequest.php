<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'filename' => 'required|string|max:255',
           'filepath' => 'required|mimes:png,jpg,jpeg,gif,docx,txt,xlsx,pdf,doc|max:2048',
           'group_id' => 'required|exists:groupes,id',
           'user_id' => 'required|exists:users,id'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Echec de validation.',
            'data'      => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'filepath.mimes' => 'Le fichier doit être au format jpeg, png ou jpg',
            'filepath.max' => 'La taille du fichier doit être inférieure à 20MB',
        ];
    }
}


