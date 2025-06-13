<?php

namespace Tests\Feature\Services;

use App\Models\LogRequest;
use App\Services\LogsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogsServiceTest extends TestCase
{
    use RefreshDatabase;

    protected LogsService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new LogsService();
    }

    public function testRetornaLogsPaginadosSemFiltro()
    {
        for ($i=0; $i < 15; $i++) { 
            LogRequest::create([
                'url' => "https://api.exemplo.com/testRetornaLogsPaginadosSemFiltro$i", 
                'status_code' => 200,
                'method'=> 'GET'
            ]);
        }

        $data = (object)[
            'page' => 1,
            'qtd' => 10,
            'search' => ''
        ];

        $result = $this->service->getLogs($data);

        $this->assertCount(10, $result['itens']);
        $this->assertEquals(15, $result['total']);
        $this->assertEquals(2, $result['total_pages']);
        $this->assertTrue($result['has_next_page']);
    }

    public function testRetornaLogsComFiltroDeBusca()
    {
        LogRequest::create([
            'url' => 'https://api.exemplo.com/teste', 
            'status_code' => 200,
            'method'=> 'GET'
        ]);

        LogRequest::create([
            'url' => 'https://google.com', 
            'status_code' => 404,
            'method'=> 'GET'
        ]);

        $data = (object)[
            'page' => 1,
            'qtd' => 10,
            'search' => 'exemplo'
        ];

        $result = $this->service->getLogs($data);

        $this->assertCount(1, $result['itens']);
        $this->assertEquals('https://api.exemplo.com/teste', $result['itens'][0]->url);
    }

    public function testGetLogByIdRetornaRegistro()
    {
        $log = LogRequest::create([
            'url' => 'https://api.exemplo.com/testGetLogByIdRetornaRegistro', 
            'status_code' => 200,
            'method'=> 'GET'
        ]);

        $found = $this->service->getLogById($log->id);

        $this->assertNotNull($found);
        $this->assertEquals($log->id, $found->id);
    }

    public function testGetLogByIdRetornaNullParaIdInvalido()
    {
        $log = $this->service->getLogById(999);
        $this->assertNull($log);
    }
}
