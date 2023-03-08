<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todolist>
 */
class TodolistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $titles = ['Learn Laravel', 'Learn React', 'Workout', 'Go to grocery', 'Overtime', 'Clean my room', 'Clean compound', 'Reading', 'Learn English'];
        return [
            'user_id' => 4,
            'title' => $titles[rand(0, 8)],
            'date' => now()->subDays(rand(1, 7))->format('Y-m-d'),
            'todolist_type_id' => rand(1, 4),
            'status' => rand(0, 1),
        ];
    }
}
