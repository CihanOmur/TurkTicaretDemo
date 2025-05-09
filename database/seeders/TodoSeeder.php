<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $todos = [
            ['title' => 'Finish project report', 'description' => 'Complete the final report for the project.', 'due_date' => '2023-10-15', 'status' => 'pending', 'priority' => 'high'],
            ['title' => 'Grocery shopping', 'description' => 'Buy groceries for the week.', 'due_date' => '2023-10-10', 'status' => 'pending', 'priority' => 'medium'],
            ['title' => 'Doctor appointment', 'description' => 'Visit the doctor for a check-up.', 'due_date' => '2023-10-12', 'status' => 'completed', 'priority' => 'low'],

        ];
        foreach ($todos as $todo) {
            $newTodo = new \App\Models\Todos();
            $newTodo->title = $todo['title'];
            $newTodo->description = $todo['description'];
            $newTodo->due_date = $todo['due_date'];
            $newTodo->status = $todo['status'];
            $newTodo->priority = $todo['priority'];
            $newTodo->save();

            // Attach categories if needed
            if (isset($todo['category'])) {
                $newTodo->categories()->attach($todo['category']);
            }
        }
    }
}
