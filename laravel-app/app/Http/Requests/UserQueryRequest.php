<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserQueryRequest extends FormRequest
{
    /**
     * Autoriza a requisição.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Define os dados que serão validados.
     */
    public function validationData(): array
    {
        return array_merge($this->all(), [
            'userName' => $this->route('userName'),
            'per_page' => $this->query('per_page', 10),
            'page' => $this->query('page', 1),
            'qtd' => $this->query('qtd', 1),
        ]);
    }

    /**
     * Regras de validação.
     */
    public function rules(): array
    {
        return [
            'userName' => 'required|string|min:3|max:50',
            'per_page' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
        ];
    }

    /**
     * Mensagens customizadas.
     */
    public function messages(): array
    {
        return [
            'userName.required' => 'O nome de usuário é obrigatório.',
            'userName.min' => 'O nome de usuário deve ter pelo menos :min caracteres.',
            'userName.max' => 'O nome de usuário não pode ter mais que :max caracteres.',
            'per_page.integer' => 'O valor de "per_page" deve ser um número inteiro.',
            'page.integer' => 'O valor de "page" deve ser um número inteiro.',
        ];
    }

    /**
     * Retorna os dados com os valores padronizados.
     */
    public function validatedWithDefaults(): object
    {
        $data = $this->validated();

        $data['per_page'] = (int) $data['per_page'] ?? 10;
        $data['qtd'] = (int) $data['per_page'] ?? 10;
        $data['page'] = (int) $data['page'] ?? 1;

        return (object) $data;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Erro de validação.',
                'errors' => $validator->errors(),
            ], 422)
        );
    }

}
