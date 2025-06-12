<?php

namespace App\Utils;

use Illuminate\Http\Client\Response;
use Exception;

class GitHubApiHelper
{
    /**
     * Trata respostas de erro da API do GitHub.
     *
     * @param Response $response
     * @return never
     * @throws \Exception
     */
    public static function handleErrorResponse(Response $response)
    {
        switch ($response->status()) {
            case 404:
                throw new Exception("Usuário não encontrado no GitHub.");
            case 403:
                $body = $response->json();
                if (isset($body['message']) && str_contains($body['message'], 'rate limit')) {
                    throw new Exception("Limite de requisições da API do GitHub excedido.");
                }
                throw new Exception("Acesso proibido à API do GitHub.");
            case 429:
                throw new Exception("Muitas requisições. Tente novamente mais tarde.");
            case 500:
            case 502:
            case 503:
            case 504:
                throw new Exception("Erro no servidor do GitHub. Tente novamente mais tarde.");
            default:
                throw new Exception("Erro ao consultar a API do GitHub: " . $response->body());
        }
    }
}
