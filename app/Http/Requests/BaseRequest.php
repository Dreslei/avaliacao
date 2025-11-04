<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
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
            'nome'       => 'required|string|max:255',
            'descricao'  => 'nullable|string',
        ];
    }

        public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser um texto.',
            'max'      => 'O campo :attribute pode ter no máximo :max caracteres.',
            'min'      => 'O campo :attribute deve ter no mínimo :min caracteres.',
            'email'    => 'Informe um e-mail válido em :attribute.',
            'numeric'  => 'O campo :attribute deve ser numérico.',
            'unique'   => 'Já existe um registro com este :attribute.',
            'in'       => 'O valor de :attribute é inválido.',
        ];
    }


    public function attributes(): array
    {
        return [
            'nome'      => 'Nome',
            'descricao' => 'Descrição',
            'email'     => 'E-mail',
            'cpf'       => 'CPF',
        ];
    }
}
