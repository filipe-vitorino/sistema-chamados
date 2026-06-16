<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Responsavel;
use App\Models\Chamado;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResponsavelTest extends TestCase
{
    use RefreshDatabase;

    // ─── obterMenosOcupado ────────────────────────────────────────────────────

    /** @test */
    public function retorna_null_quando_nenhum_responsavel_ativo_existe()
    {
        Responsavel::factory()->create(['ativo' => false]);

        $this->assertNull(Responsavel::obterMenosOcupado());
    }

    /** @test */
    public function retorna_responsavel_com_menos_chamados_abertos_ou_em_andamento()
    {
        $ocupado = Responsavel::factory()->create(['ativo' => true]);
        $livre   = Responsavel::factory()->create(['ativo' => true]);

        Chamado::factory()->count(3)->create([
            'responsavel_id' => $ocupado->id,
            'status'         => 'aberto',
        ]);

        Chamado::factory()->create([
            'responsavel_id' => $livre->id,
            'status'         => 'aberto',
        ]);

        $this->assertEquals($livre->id, Responsavel::obterMenosOcupado()->id);
    }

    /** @test */
    public function ignora_chamados_resolvidos_ao_calcular_ocupacao()
    {
        $comResolvidos   = Responsavel::factory()->create(['ativo' => true]);
        $semResolvidos   = Responsavel::factory()->create(['ativo' => true]);

        Chamado::factory()->count(3)->create([
            'responsavel_id' => $comResolvidos->id,
            'status'         => 'resolvido',
        ]);

        Chamado::factory()->create([
            'responsavel_id' => $semResolvidos->id,
            'status'         => 'aberto',
        ]);

        $this->assertEquals($comResolvidos->id, Responsavel::obterMenosOcupado()->id);
    }

    /** @test */
    public function ignora_responsaveis_inativos_ao_obter_menos_ocupado()
    {
        $inativo = Responsavel::factory()->create(['ativo' => false]);
        $ativo   = Responsavel::factory()->create(['ativo' => true]);

        Chamado::factory()->count(5)->create([
            'responsavel_id' => $ativo->id,
            'status'         => 'aberto',
        ]);

        $resultado = Responsavel::obterMenosOcupado();

        $this->assertEquals($ativo->id, $resultado->id);
    }


    /** @test */
    public function retorna_chamados_onde_responsavel_foi_substituido()
    {
        $antigo = Responsavel::factory()->create(['ativo' => true]);
        $novo   = Responsavel::factory()->create(['ativo' => true]);

        $chamado = Chamado::factory()->create([
            'responsavel_id' => $novo->id,
            'status'         => 'aberto',
        ]);

        $chamado->historicos()->create([
            'campo_alterado' => 'responsavel_id',
            'valor_antigo'   => $antigo->id,
            'valor_novo'     => $novo->id,
        ]);

        $anteriores = $antigo->chamadosAnteriores();

        $this->assertCount(1, $anteriores);
        $this->assertEquals($chamado->id, $anteriores->first()->id);
    }

    /** @test */
    public function nao_retorna_chamados_ainda_atribuidos_ao_responsavel()
    {
        $responsavel = Responsavel::factory()->create(['ativo' => true]);

        $chamado = Chamado::factory()->create([
            'responsavel_id' => $responsavel->id,
            'status'         => 'aberto',
        ]);

        $chamado->historicos()->create([
            'campo_alterado' => 'responsavel_id',
            'valor_antigo'   => $responsavel->id,
            'valor_novo'     => $responsavel->id,
        ]);

        $this->assertCount(0, $responsavel->chamadosAnteriores());
    }


    /** @test */
    public function gera_nome_aleatorio_como_string_nao_vazia()
    {
        $nome = Responsavel::gerarNomeAleatorio();

        $this->assertIsString($nome);
        $this->assertNotEmpty($nome);
    }

    // ─── relacionamentos ──────────────────────────────────────────────────────

    /** @test */
    public function responsavel_possui_relacao_com_chamados()
    {
        $responsavel = Responsavel::factory()->create();
        Chamado::factory()->count(2)->create(['responsavel_id' => $responsavel->id]);

        $this->assertCount(2, $responsavel->chamados);
    }
}
