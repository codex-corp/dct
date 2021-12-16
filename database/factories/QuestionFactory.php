<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = ['not_answered', 'in_progress', 'answered', 'spam'];
        shuffle( $status);
        return [
            'title' => $this->faker->title(),
            'message' => $this->faker->text(),
            'question_id' => Str::random(10),
            'status' => current($status),
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ];
    }
}
