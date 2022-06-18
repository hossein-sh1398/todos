<?php

namespace Database\Factories;

use App\Enums\StatusTodo;
use App\Enums\TodoTag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = array_column(StatusTodo::toArray(), 'id');
        $tags = array_column(TodoTag::toArray(), 'id');

        shuffle($status);
        shuffle($tags);

        return [
            'title' => 'todo ' . $this->faker->sentence(),
            'due_date' => date('Y-m-d H:i:s'),
            'status' => $status[0],
            'tag' => $tags[0],
        ];
    }
}