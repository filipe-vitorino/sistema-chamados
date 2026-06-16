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
        dump('--- TESTE INICIADO ---');

        $responsavel = Responsavel::factory()->create();
        dump('1. Responsável Criado no Banco');

        Chamado::factory()->count(2)->create(['responsavel_id' => $responsavel->id]);
        dump('2. Chamados Criados no Banco');

        dump('3. Vai tentar acessar a URL: ' . route('responsaveis.chamados', $responsavel));
        $response = $this->get(route('responsaveis.chamados', $responsavel));

        dump('4. Rota carregada com sucesso! (Se você leu isso, o problema não é no teste)');
        $response->assertStatus(200);
    }
    public function test_filtra_projetos_anteriores_do_responsavel()
    {
        $responsavelAntigo = Responsavel::factory()->create();
        $responsavelNovo = Responsavel::factory()->create();

        $chamado = Chamado::factory()->create(['responsavel_id' => $responsavelNovo->id]);

        // Finge que o projeto foi transferido
        $chamado->historicos()->create([
            'campo_alterado' => 'responsavel_id',
            'valor_antigo' => $responsavelAntigo->id,
            'valor_novo' => $responsavelNovo->id,
        ]);

        // Acessa a rota passando o parâmetro GET na URL: ?status=anteriores
        $response = $this->get(route('responsaveis.chamados', ['responsavel' => $responsavelAntigo->id, 'status' => 'anteriores']));

        $response->assertStatus(200);

        // Garante que a View recebeu chamados na coleção
        $chamadosEncontrados = $response->viewData('chamados');
        $this->assertCount(1, $chamadosEncontrados);
        $this->assertEquals($chamado->id, $chamadosEncontrados->first()->id);
    }
}
