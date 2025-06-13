<?php

namespace Tests\Feature\Http\Controllers\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use App\Services\GitHubUserService;
use App\Services\LogsService;
use App\Models\LogRequest;
use Illuminate\Support\Facades\App;

class GitHubControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUserRetornaDadosDoUsuario()
    {
        Http::fake([
            'https://api.github.com/users/octocat' => Http::response([
                'login' => 'octocat',
                'id' => 1
            ], 200)
        ]);

        $response = $this->getJson('/api/user/octocat');

        $response->assertStatus(200)
                 ->assertJsonFragment(['login' => 'octocat']);
    }

    public function testGetUserRetornaErroQuandoNaoEncontrado()
    {
        Http::fake([
            'https://api.github.com/users/naoexiste' => Http::response([
                'message' => 'Not Found'
            ], 404)
        ]);

        $response = $this->getJson('/api/user/naoexiste');

        $response->assertStatus(400)
                 ->assertJsonFragment(['error' => 'Erro inesperado ao consultar o GitHub: Usuário não encontrado no GitHub.']);
    }

    public function testGetFollowingRetornaSeguidoresComPaginacao()
    {
        Http::fake([
            'https://api.github.com/users/octocat/following?page=1&per_page=2' => Http::response([
                ['login' => 'user1'],
                ['login' => 'user2']
            ], 200),

            'https://api.github.com/users/octocat' => Http::response([
                'following' => 5
            ], 200)
        ]);

        $response = $this->getJson('/api/following/octocat?page=1&per_page=2');

        $response->assertStatus(200)
                 ->assertJsonFragment(['login' => 'user1'])
                 ->assertJsonFragment(['total' => 5])
                 ->assertJsonFragment(['page' => 1]);
    }

    public function testGetLogsRetornaListaComPaginacao()
    {
        LogRequest::create(['url' => '/api/user/foo', 'method'=>'GET']);
        LogRequest::create(['url' => '/api/user/bar', 'method'=>'GET']);

        $response = $this->getJson('/api/logs?page=1&per_page=10');

        $response->assertStatus(200)
                 ->assertJsonFragment(['page' => 1])
                 ->assertJsonStructure([
                     'itens',
                     'total',
                     'page',
                     'per_page',
                     'next_page',
                     'previous_page',
                     'total_pages',
                     'has_previous_page',
                     'has_next_page',
                 ]);
    }

    public function testGetLogByIdRetornaLog()
    {
        $log = LogRequest::create([
            'url' => '/api/test',
            'status_code' => 200,
            'method'=>'GET'
        ]);

        $response = $this->getJson("/api/logs/{$log->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['url' => '/api/test']);
    }

    public function testGetLogByIdRetorna404SeNaoExistir()
    {
        $response = $this->getJson('/api/logs/999');

        $response->assertStatus(404)
                 ->assertJson(['error' => 'Log not found.']);
    }
}
