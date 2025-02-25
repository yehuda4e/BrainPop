<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Option;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('test'),
        ]);

        // Create specific science questions and their options
        $questions = [
            [
                'question' => 'What is the closest planet to the Sun?',
                'options' => [
                    ['text' => 'Mercury', 'is_correct' => true],
                    ['text' => 'Venus', 'is_correct' => false],
                    ['text' => 'Mars', 'is_correct' => false],
                    ['text' => 'Earth', 'is_correct' => false],
                ]
            ],
            [
                'question' => 'Which element has the chemical symbol Fe?',
                'options' => [
                    ['text' => 'Fluorine', 'is_correct' => false],
                    ['text' => 'Iron', 'is_correct' => true],
                    ['text' => 'Francium', 'is_correct' => false],
                    ['text' => 'Fermium', 'is_correct' => false],
                ]
            ],
            [
                'question' => 'What is the largest organ in the human body?',
                'options' => [
                    ['text' => 'Heart', 'is_correct' => false],
                    ['text' => 'Brain', 'is_correct' => false],
                    ['text' => 'Liver', 'is_correct' => false],
                    ['text' => 'Skin', 'is_correct' => true],
                ]
            ],
            [
                'question' => 'What force keeps planets in orbit around the Sun?',
                'options' => [
                    ['text' => 'Nuclear force', 'is_correct' => false],
                    ['text' => 'Electromagnetic force', 'is_correct' => false],
                    ['text' => 'Gravity', 'is_correct' => true],
                    ['text' => 'Friction', 'is_correct' => false],
                ]
            ],
            [
                'question' => 'Which gas do plants absorb from the atmosphere during photosynthesis?',
                'options' => [
                    ['text' => 'Oxygen', 'is_correct' => false],
                    ['text' => 'Nitrogen', 'is_correct' => false],
                    ['text' => 'Carbon dioxide', 'is_correct' => true],
                    ['text' => 'Hydrogen', 'is_correct' => false],
                ]
            ]
        ];

        foreach ($questions as $questionData) {
            $question = Question::create([
                'question_text' => $questionData['question']
            ]);

            foreach ($questionData['options'] as $optionData) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $optionData['text'],
                    'is_correct' => $optionData['is_correct']
                ]);
            }
        }
    }
}
