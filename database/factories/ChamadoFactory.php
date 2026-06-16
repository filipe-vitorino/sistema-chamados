<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Responsavel;

class ChamadoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titulo' => fake()->sentence(4),
            'descricao' => fake()->realText(200),
            'prioridade' => fake()->randomElement(['baixa', 'media', 'alta']),
            'status' => fake()->randomElement(['aberto', 'em_andamento']),
            'responsavel_id' => Responsavel::factory(),
        ];
    }
}
