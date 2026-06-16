<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Chamado;
use App\Models\Responsavel;
use App\Models\HistoricoChamado;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChamadoTest extends TestCase
{
    use RefreshDatabase;

    public function test_chamado_pertence_a_um_responsavel()
    {
        $responsavel = Responsavel::factory()->create();
        $chamado = Chamado::factory()->create(['responsavel_id' => $responsavel->id]);

        $this->assertInstanceOf(Responsavel::class, $chamado->responsavel);
        $this->assertEquals($responsavel->id, $chamado->responsavel->id);
    }

    public function test_chamado_possui_varios_historicos()
    {
        $chamado = Chamado::factory()->create();

        $chamado->historicos()->create([
            'campo_alterado' => 'criacao',
            'valor_novo' => 'aberto'
        ]);

        $this->assertCount(1, $chamado->historicos);
        $this->assertInstanceOf(HistoricoChamado::class, $chamado->historicos->first());
    }
}
