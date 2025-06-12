<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use App\Utils\GitHubApiHelper;
use App\Utils\PaginationHelper;
use Exception;

class GitHubUserService
{
    protected string $baseUrl = 'https://api.github.com';

    /**
     * Busca informações de um usuário do GitHub.
     */
    public function getUser(string $username): array
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'Laravel-App'
            ])->get("{$this->baseUrl}/users/{$username}");

            if ($response->successful()) {
                return $response->json();
            }

            return GitHubApiHelper::handleErrorResponse($response);

        } catch (RequestException $e) {
            throw new Exception("Erro de rede ou conexão com o GitHub.");
        } catch (Exception $e) {
            throw new Exception("Erro inesperado ao consultar o GitHub: " . $e->getMessage());
        }
    }

    /**
     * Busca a lista de usuários que o username está seguindo, com paginação.
     */
    public function getFollowing(object $data): array
    {
        try {

            $response = Http::withHeaders([
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'Laravel-App'
            ])->get("{$this->baseUrl}/users/{$data->userName}/following", [
                'page' => $data->page,
                'per_page' => $data->per_page,
            ]);

            if (!$response->successful()) {
                return GitHubApiHelper::handleErrorResponse($response);
            }

            $data->itens = $response->json();
            $userInfo = $this->getUser($data->userName);
            $data->totalItens = $userInfo['following'] ?? 0;

            return PaginationHelper::pagination($data);

        } catch (RequestException $e) {
            throw new Exception("Erro de rede ou conexão com o GitHub.");
        } catch (Exception $e) {
            throw new Exception("Erro inesperado ao consultar os usuários seguidos: " . $e->getMessage());
        }
    }
}
