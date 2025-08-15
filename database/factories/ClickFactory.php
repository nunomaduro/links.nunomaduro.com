<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Link;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Click>
 */
final class ClickFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'link_id' => Link::factory(),
            'session_id_hash' => $this->faker->sha256(),
        ];
    }
}
