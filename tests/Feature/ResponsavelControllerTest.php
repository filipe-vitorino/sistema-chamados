<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Chamado;
use App\Models\Responsavel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResponsavelControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_lista_responsaveis_na_tela_de_gestao()
    {
        Responsavel::factory()->count(2)->create();

        $response = $this->get(route('responsaveis.index'));

        $response->assertStatus(200);
        $response->assertViewHas('responsaveis');
    }

    public function test_exibe_a_fila_de_chamados_de_um_responsavel()
    {

        $responsavel = Responsavel::factory()->create();

        Chamado::factory()->count(2)->create(['responsavel_id' => $responsavel->id]);

        $response = $this->get(route('responsaveis.chamados', $responsavel));

        $response->assertStatus(200);
    }
    public function test_filtra_projetos_anteriores_do_responsavel()
    {
        $responsavelAntigo = Responsavel::factory()->create();
        $responsavelNovo = Responsavel::factory()->create();

        $chamado = Chamado::factory()->create(['responsavel_id' => $responsavelNovo->id]);

        $chamado->historicos()->create([
            'campo_alterado' => 'responsavel_id',
            'valor_antigo' => $responsavelAntigo->id,
            'valor_novo' => $responsavelNovo->id,
        ]);

        $response = $this->get(route('responsaveis.chamados', ['responsavel' => $responsavelAntigo->id, 'status' => 'anteriores']));

        $response->assertStatus(200);

        $chamadosEncontrados = $response->viewData('chamados');
        $this->assertCount(1, $chamadosEncontrados);
        $this->assertEquals($chamado->id, $chamadosEncontrados->first()->id);
    }

    public function test_nao_permite_desativar_responsavel_com_chamados_pendentes()
    {
        $responsavel = Responsavel::factory()->create(['ativo' => true]);

        Chamado::factory()->create([
            'responsavel_id' => $responsavel->id,
            'status' => 'aberto'
        ]);

        $response = $this->patch(route('responsaveis.toggle', $responsavel));

        $response->assertRedirect(route('responsaveis.index'));
        $response->assertSessionHas('erro', 'Não é possível desativar um responsável com chamados pendentes.');

        $this->assertTrue($responsavel->fresh()->ativo);
    }

    public function test_permite_desativar_responsavel_sem_chamados_pendentes()
    {
        $responsavel = Responsavel::factory()->create(['ativo' => true]);

        $response = $this->patch(route('responsaveis.toggle', $responsavel));

        $response->assertRedirect(route('responsaveis.index'));

        $this->assertFalse($responsavel->fresh()->ativo);
    }
}
