<?php

namespace App\Services;

use App\Models\LogRequest;
use App\Utils\PaginationHelper;
use Exception;

class LogsService
{
    public function getLogs(object $data): array
    {
        try {
            
            $query = LogRequest::query();

            if (!empty($data->search)) {
                $query->where(function ($q) use ($data) {
                    $q->where('url', 'like', '%' . $data->search . '%')
                      ->orWhere('status_code', 'like', '%' . $data->search . '%');
                });
            }

            $data->totalItens = $query->count();

            $data->itens = $query->skip(((int)$data->page - 1) * (int)$data->qtd)
                            ->take((int)$data->qtd)
                            ->orderBy('created_at', 'desc')
                            ->get();

            return PaginationHelper::pagination($data);

        } catch (Exception $e) {
            throw new Exception("Erro ao consultar os logs: " . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception("Erro inesperado ao consultar o GitHub: " . $e->getMessage());
        }
    }

}
