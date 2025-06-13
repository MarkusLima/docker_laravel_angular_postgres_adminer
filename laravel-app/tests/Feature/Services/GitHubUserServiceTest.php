<?php

namespace Tests\Feature\Services;

use App\Services\GitHubUserService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Exception;

class GitHubUserServiceTest extends TestCase
{
    protected GitHubUserService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new GitHubUserService();
    }

    public function testGetUserRetornaDadosDoUsuario()
    {
        Http::fake([
            'https://api.github.com/users/octocat' => Http::response([
                'login' => 'octocat',
                'id' => 1,
                'name' => 'The Octocat'
            ], 200),
        ]);

        $user = $this->service->getUser('octocat');

        $this->assertIsArray($user);
        $this->assertEquals('octocat', $user['login']);
    }

    public function testGetUserDisparaErroSeUsuarioNaoExiste()
    {
        Http::fake([
            'https://api.github.com/users/usuario-inexistente' => Http::response([], 404),
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Usuário não encontrado no GitHub.");

        $this->service->getUser('usuario-inexistente');
    }

    public function testGetFollowingRetornaUsuariosSeguidosComPaginacao()
    {
        $username = 'octocat';

        Http::fake([
            "https://api.github.com/users/{$username}/following?page=1&per_page=2" => Http::response([
                ['login' => 'user1'],
                ['login' => 'user2'],
            ], 200),

            "https://api.github.com/users/{$username}" => Http::response([
                'following' => 5
            ], 200),
        ]);

        $data = (object)[
            'userName' => $username,
            'page' => 1,
            'per_page' => 2,
            'qtd' => 2
        ];

        $response = $this->service->getFollowing($data);

        $this->assertIsArray($response);
        $this->assertEquals(5, $response['total']);
        $this->assertEquals(3, $response['total_pages']);
        $this->assertCount(2, $response['itens']);
    }

    public function testGetFollowingDisparaErroSeUsuarioNaoExiste()
    {
        $username = 'user-nada-a-ver';

        Http::fake([
            "https://api.github.com/users/{$username}/following?page=1&per_page=2" => Http::response([], 404),
        ]);

        $data = (object)[
            'userName' => $username,
            'page' => 1,
            'per_page' => 2
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Usuário não encontrado no GitHub.");

        $this->service->getFollowing($data);
    }
}
