<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetLogsRequest extends FormRequest
{
    /**
     * Autoriza a requisição.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Adiciona valores padrões aos dados validados.
     */
    public function validationData(): array
    {
        return array_merge($this->query(), [
            'search' => $this->query('search', ''),
            'qtd' => $this->query('qtd', 5),
            'page' => $this->query('page', 1),
        ]);
    }

    /**
     * Regras de validação.
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|string',
            'qtd' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
        ];
    }

    /**
     * Mensagens customizadas.
     */
    public function messages(): array
    {
        return [
            'qtd.integer' => 'O campo qtd deve ser um número inteiro.',
            'qtd.min' => 'O campo qtd deve ser no mínimo :min.',
            'page.integer' => 'O campo page deve ser um número inteiro.',
            'page.min' => 'O campo page deve ser no mínimo :min.',
        ];
    }

    /**
     * Retorna os dados com os valores padronizados.
     */
    public function validatedWithDefaults(): object
    {
        $data = $this->validated();

        $data['search'] = $data['search'] ?? '';
        $data['qtd'] = (int) $data['qtd'] ?? 5;
        $data['page'] = (int) $data['page'] ?? 1;

        return (object) $data;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}
