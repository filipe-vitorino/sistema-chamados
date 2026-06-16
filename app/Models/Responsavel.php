<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Responsavel extends Model
{
    use HasFactory;
    protected $table = 'responsaveis';

    protected $fillable = [
        'nome',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function chamados(): HasMany
    {
        return $this->hasMany(Chamado::class, 'responsavel_id');
    }

    public function chamadosAnteriores()
    {
        return Chamado::whereHas('historicos', function ($query) {
            $query->where('campo_alterado', 'responsavel_id')
                ->where('valor_antigo', $this->id);
        })->where('responsavel_id', '!=', $this->id)->get();
    }


    public static function obterMenosOcupado()
    {
        return self::where('ativo', true)
            ->withCount(['chamados' => function ($query) {
                $query->whereIn('status', ['aberto', 'em_andamento']);
            }])
            ->orderBy('chamados_count', 'asc')
            ->first();
    }



    public static function gerarNomeAleatorio(): string
    {
        return fake()->name();
    }
}
