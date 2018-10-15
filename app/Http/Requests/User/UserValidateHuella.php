<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserValidateHuella extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tipoDocumento' => 'required|max:10',
            'documento' => 'required|max:200',
        ];
    }

    public function attributes()
    {
        return [
            'tipoDocumento' => 'tipoDocumento (PARAMETRO PETICION)',
            'documento' => 'documento (PARAMETRO PETICION)',
        ];
    }
    

    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            //422->La solicitud está bien formada pero fue imposible seguirla debido a errores semánticos.
            return response()->json($errors, 422);
        }
    }
}
