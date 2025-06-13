<?php

namespace Tests\Unit\Utils;

use App\Utils\PaginationHelper;
use PHPUnit\Framework\TestCase;
use stdClass;
use Exception;

class PaginationHelperTest extends TestCase
{
    public function testPaginationComDadosValidos()
    {
        $data = new stdClass();
        $data->itens = ['item1', 'item2'];
        $data->totalItens = 10;
        $data->page = 2;
        $data->qtd = 2;

        $result = PaginationHelper::pagination($data);

        $this->assertEquals([
            'itens' => ['item1', 'item2'],
            'total' => 10,
            'page' => 2,
            'per_page' => 2,
            'next_page' => 3,
            'previous_page' => 1,
            'total_pages' => 5,
            'has_previous_page' => true,
            'has_next_page' => true,
        ], $result);
    }

    public function testPaginationNaPrimeiraPagina()
    {
        $data = new stdClass();
        $data->itens = ['item1'];
        $data->totalItens = 5;
        $data->page = 1;
        $data->qtd = 2;

        $result = PaginationHelper::pagination($data);

        $this->assertFalse($result['has_previous_page']);
        $this->assertTrue($result['has_next_page']);
    }

    public function testPaginationNaUltimaPagina()
    {
        $data = new stdClass();
        $data->itens = ['item1'];
        $data->totalItens = 4;
        $data->page = 2;
        $data->qtd = 2;

        $result = PaginationHelper::pagination($data);

        $this->assertTrue($result['has_previous_page']);
        $this->assertFalse($result['has_next_page']);
    }

    public function testPaginationComDadosIncompletos()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Dados de paginação incompletos.");

        $data = new stdClass();
        $data->itens = ['item1']; // Faltam: totalItens, page, qtd

        PaginationHelper::pagination($data);
    }
}
