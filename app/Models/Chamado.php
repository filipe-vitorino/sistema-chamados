<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Responsavel;

class Chamado extends Model
{
    protected $table = 'chamados';

    protected $fillable = [
        'titulo',
        'descricao',
        'prioridade',
        'status',
        'responsavel_id',
        'resolvido_em'
    ];

    protected $casts = [
        'resolvido_em' => 'datetime',
    ];

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(Responsavel::class, 'responsavel_id');
    }

    public function historicos(): HasMany
    {
        return $this->hasMany(HistoricoChamado::class);
    }
}
