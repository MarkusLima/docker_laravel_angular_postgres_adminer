<?php

namespace App\Utils;

use Illuminate\Http\Client\Response;
use Exception;

class PaginationHelper
{
    /**
     * Formata os dados de paginação para o formato esperado pela API.
     *
     * @param object $data
     * @return array
     */
    public static function pagination(object $data)
    {
        if (!isset($data->totalItens, $data->page, $data->qtd)) {
            throw new \Exception("Dados de paginação incompletos.");
        }

        $totalPages = (int) ceil($data->totalItens / $data->qtd);
        $nextPage = $data->page + 1;
        $previousPage = $data->page - 1;

        return [
            'itens' => $data->itens,
            'total' => $data->totalItens,
            'page' => $data->page,
            'per_page' => $data->qtd,
            'next_page' => $nextPage,
            'previous_page' => $previousPage,
            'total_pages' => $totalPages,
            'has_previous_page' => $previousPage >= 1,
            'has_next_page' => $nextPage <= $totalPages,
        ];
    }
}
