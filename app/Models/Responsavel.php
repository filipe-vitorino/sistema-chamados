<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Responsavel extends Model
{

    protected $table = 'responsaveis';

    protected $fillable = [
        'nome',
        'ativo'
    ];

    public function chamados(): HasMany
    {
        return $this->hasMany(Chamado::class, 'responsavel_id');
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
        $nomes = [
            'João Silva',
            'Maria Santos',
            'Carlos Oliveira',
            'Ana Souza',
            'Pedro Lima',
            'Lucas Costa',
            'Juliana Rocha',
            'Fernanda Alves',
            'Bruno Martins',
            'Gabriel Ferreira',
            'Amanda Ribeiro',
            'Rodrigo Melo',
            'Camila Carvalho',
            'Rafael Teixeira',
            'Larissa Gomes',
            'Diego Almeida',
            'Beatriz Barbosa',
            'Guilherme Pinto',
            'Letícia Correia',
            'Gustavo Cardoso',
            'Mariana Cavalcanti',
            'Felipe Dias',
            'Sofia Castro',
            'Thiago Cunha',
            'Bárbara Fernandes',
            'Mateus Fontana',
            'Carolina Moura',
            'Leonardo Rocha',
            'Gabriela Nunes',
            'Vitor Mendes',
            'Isabela Vieira',
            'Daniel Marques',
            'Manuela Medeiros',
            'Eduardo Nascimento',
            'Alice Ramos',
            'André Moraes',
            'Luana Freitas',
            'Samuel Santana',
            'Olivia Azevedo',
            'Caio Pereira',
            'Laura Borges',
            'Henrique Rezende',
            'Valentina Farias',
            'Murilo Aragão',
            'Heloísa Guimarães',
            'Vinícius Assis',
            'Lorena Viana',
            'Arthur Lopes',
            'Cecília Machado',
            'Matheus Nogueira'
        ];

        return $nomes[array_rand($nomes)];
    }
}
