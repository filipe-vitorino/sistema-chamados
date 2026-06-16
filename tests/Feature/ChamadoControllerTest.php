<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Chamado;
use App\Models\Responsavel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChamadoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_lista_chamados_na_tela_inicial()
    {
        Chamado::factory()->count(3)->create();

        $response = $this->get(route('chamados.index'));

        $response->assertStatus(200);
        $response->assertViewHas('chamados');
    }

    public function test_cria_novo_chamado_e_gera_historico_de_criacao()
    {
        $responsavel = Responsavel::factory()->create();

        $dadosFormulario = [
            'titulo' => 'Meu computador não liga',
            'descricao' => 'A tela fica preta ao iniciar.',
            'prioridade' => 'alta',
            'responsavel_id' => $responsavel->id,
        ];

        // Simula o envio do formulário POST
        $response = $this->post(route('chamados.store'), $dadosFormulario);

        // Verifica se redirecionou com sucesso
        $response->assertRedirect(route('chamados.index'));

        // Verifica se o chamado foi parar no banco
        $this->assertDatabaseHas('chamados', [
            'titulo' => 'Meu computador não liga',
            'status' => 'aberto',
        ]);

        $chamadoCriado = Chamado::first();

        // Verifica se o histórico inicial foi gerado
        $this->assertDatabaseHas('historico_chamados', [
            'chamado_id' => $chamadoCriado->id,
            'campo_alterado' => 'criacao',
            'valor_novo' => 'aberto'
        ]);
    }

    public function test_atualiza_status_do_chamado_e_gera_historico()
    {
        $responsavel = Responsavel::factory()->create();
        $chamado = Chamado::factory()->create([
            'responsavel_id' => $responsavel->id,
            'status' => 'aberto'
        ]);

        $dadosAtualizados = [
            'status' => 'resolvido',
            'responsavel_id' => $responsavel->id,
        ];

        // Simula edição PUT
        $response = $this->put(route('chamados.update', $chamado), $dadosAtualizados);

        $response->assertRedirect(route('chamados.index'));

        // Confirma a atualização no banco
        $this->assertDatabaseHas('chamados', [
            'id' => $chamado->id,
            'status' => 'resolvido'
        ]);

        // Confirma se o Controller salvou a troca de status no histórico
        $this->assertDatabaseHas('historico_chamados', [
            'chamado_id' => $chamado->id,
            'campo_alterado' => 'status',
            'valor_antigo' => 'aberto',
            'valor_novo' => 'resolvido'
        ]);
    }
}
