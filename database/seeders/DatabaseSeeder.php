<?php

namespace Database\Seeders;

use App\Models\Responsavel;
use App\Models\Chamado;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $responsaveis = Responsavel::factory(3)->create();

        foreach ($responsaveis as $responsavel) {
            Chamado::factory(2)->create([
                'responsavel_id' => $responsavel->id,
            ])->each(function ($chamado) {
                $chamado->historicos()->create([
                    'campo_alterado' => 'criacao',
                    'valor_antigo'   => null,
                    'valor_novo'     => 'aberto'
                ]);
            });
        }

        $chamadoTransferido = Chamado::first();

        $responsavelAntigo = $responsaveis[1];
        $responsavelAtual = $chamadoTransferido->responsavel;

        $chamadoTransferido->historicos()->create([
            'campo_alterado' => 'responsavel_id',
            'valor_antigo'   => $responsavelAntigo->id,
            'valor_novo'     => $responsavelAtual->id
        ]);

        $chamadoTransferido->historicos()->create([
            'campo_alterado' => 'status',
            'valor_antigo'   => 'aberto',
            'valor_novo'     => 'em_andamento'
        ]);
        $chamadoTransferido->update(['status' => 'em_andamento']);
    }
}
