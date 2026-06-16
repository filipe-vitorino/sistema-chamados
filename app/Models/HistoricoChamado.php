<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class HistoricoChamado extends Model
{
    protected $fillable = [
        'chamado_id',
        'descricao'
    ];

    public function chamado(): BelongsTo
    {
        return $this->belongsTo(Chamado::class);
    }
}
