<?php

namespace Tests\Unit\Utils;

use App\Utils\GitHubApiHelper;
use Illuminate\Http\Client\Response;
use PHPUnit\Framework\TestCase;
use Exception;
use Mockery;

class GitHubApiHelperTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close(); // Necessário para limpar os mocks após cada teste
        parent::tearDown();
    }

    public function testHandleErrorResponseComStatus404()
    {
        $response = Mockery::mock(Response::class);
        $response->shouldReceive('status')->once()->andReturn(404);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Usuário não encontrado no GitHub.");

        GitHubApiHelper::handleErrorResponse($response);
    }

    public function testHandleErrorResponseComStatus403RateLimit()
    {
        $response = Mockery::mock(Response::class);
        $response->shouldReceive('status')->once()->andReturn(403);
        $response->shouldReceive('json')->once()->andReturn([
            'message' => 'API rate limit exceeded'
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Limite de requisições da API do GitHub excedido.");

        GitHubApiHelper::handleErrorResponse($response);
    }

    public function testHandleErrorResponseComStatus403Generico()
    {
        $response = Mockery::mock(Response::class);
        $response->shouldReceive('status')->once()->andReturn(403);
        $response->shouldReceive('json')->once()->andReturn([
            'message' => 'Some other error'
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Acesso proibido à API do GitHub.");

        GitHubApiHelper::handleErrorResponse($response);
    }

    public function testHandleErrorResponseComStatus429()
    {
        $response = Mockery::mock(Response::class);
        $response->shouldReceive('status')->once()->andReturn(429);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Muitas requisições. Tente novamente mais tarde.");

        GitHubApiHelper::handleErrorResponse($response);
    }

    /**
     * @dataProvider statusErroServidor
     */
    public function testHandleErrorResponseComErroServidor($statusCode)
    {
        $response = Mockery::mock(Response::class);
        $response->shouldReceive('status')->once()->andReturn($statusCode);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Erro no servidor do GitHub. Tente novamente mais tarde.");

        GitHubApiHelper::handleErrorResponse($response);
    }

    public static function statusErroServidor(): array
    {
        return [[500], [502], [503], [504]];
    }

    public function testHandleErrorResponseComStatusDesconhecido()
    {
        $response = Mockery::mock(Response::class);
        $response->shouldReceive('status')->once()->andReturn(418);
        $response->shouldReceive('body')->once()->andReturn('I\'m a teapot');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Erro ao consultar a API do GitHub: I'm a teapot");

        GitHubApiHelper::handleErrorResponse($response);
    }
}
