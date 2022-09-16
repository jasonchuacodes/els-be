<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // USERS
        DB::table(
            'users'
        )->insert(
            [
                [
                    'first_name' => 'Jason',
                    'last_name' => 'Chua',
                    'email' => 'jason@gmail.com',
                    'avatar' => 'https://joeschmoe.io/api/v1/jason',
                    'email_verified_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'password' => Hash::make('123'),
                ],
                [
                    'first_name' => 'Abby',
                    'last_name' => 'Chua',
                    'email' => 'abby@gmail.com',
                    'avatar' => 'https://joeschmoe.io/api/v1/abby',
                    'email_verified_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'password' => Hash::make('123'),
                ],
                [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'email' => 'john@gmail.com',
                    'avatar' => 'https://joeschmoe.io/api/v1/john',
                    'email_verified_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'password' => Hash::make('123'),
                ]
            ]
        );
        // QUIZZES
        DB::table('quizzes')->insert([
            [
                'title' => 'Math 101'
            ],
            [
                'title' => 'English 101'
            ]
        ]);
        // QUESTIONS
        DB::table('questions')->insert(
            [
                [
                    'quiz_id' => 1,
                    'question' => 'What is 1+1?'
                ],
                [
                    'quiz_id' => 1,
                    'question' => 'What is 1+2?'
                ],
                [
                    'quiz_id' => 1,
                    'question' => 'What is 1+3?'
                ]
            ]
        );
        // CHOICES
        DB::table('choices')->insert(
            [
                [
                    'question_id' => 1,
                    'choice' => "ONE",
                    'is_correct' => 0
                ],
                [
                    'question_id' => 1,
                    'choice' => "TWO",
                    'is_correct' => 1
                ],
                [
                    'question_id' => 1,
                    'choice' => "THREE",
                    'is_correct' => 0
                ],
                [
                    'question_id' => 2,
                    'choice' => "FOUR",
                    'is_correct' => 0
                ],
                [
                    'question_id' => 2,
                    'choice' => "TWO",
                    'is_correct' => 0
                ],
                [
                    'question_id' => 2,
                    'choice' => "THREE",
                    'is_correct' => 1
                ],
                [
                    'question_id' => 3,
                    'choice' => "FOUR",
                    'is_correct' => 1
                ],
                [
                    'question_id' => 3,
                    'choice' => "FIVE",
                    'is_correct' => 0
                ],
                [
                    'question_id' => 3,
                    'choice' => "TWO",
                    'is_correct' => 0
                ],

            ]
        );
        // QUIZLOGS
        // DB::table('quizlogs')->insert([
        //     'user_id' => 1,
        //     'quiz_id' => 1
        // ]);
        // ANSWERS
        // DB::table('answers')->insert([
        //     [
        //         'question_id' => 1,
        //         'quizlog_id' => 1,
        //         'choice_id' => 2,
        //     ],
        //     [
        //         'question_id' => 2,
        //         'quizlog_id' => 1,
        //         'choice_id' => 3
        //     ],
        //     [
        //         'question_id' => 3,
        //         'quizlog_id' => 1,
        //         'choice_id' => 1,
        //     ],
        // ]);
    }
}
