<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use \App\Models\Category;
use \App\Models\Task;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'admin@example.com',
             'email_verified_at' => now(),
             'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
             'remember_token' => Str::random(10),
        ]);


        $categories = [
            ['name' => 'Work'],
            ['name' => 'Personal'],
            ['name' => 'Health'],
            ['name' => 'Education'],
            ['name' => 'Hobbies'],
        ];

        Category::insert($categories);

                $tasks = [
                    [
                        'name' => 'Send monthly report',
                        'description' => 'Prepare and send the monthly report to the management team',
                        'priority' => 'High',
                        'date_due' => '2023-06-15',
                        'category_id' => Category::where('name', 'Work')->first()->id,
                        'user_id' => 1
                    ],
                    [
                        'name' => 'Schedule meeting with client X',
                        'description' => 'Contact client X and schedule a meeting to discuss project details',
                        'priority' => 'Medium',
                        'date_due' => '2023-06-12',
                        'category_id' => Category::where('name', 'Work')->first()->id,
                        'user_id' => 1
                    ],
                    [
                        'name' => 'Update sales spreadsheet',
                        'description' => 'Record the latest sales and update the tracking spreadsheet',
                        'priority' => 'Low',
                        'date_due' => '2023-06-18',
                        'category_id' => Category::where('name', 'Work')->first()->id,
                        'user_id' => 1
                    ],
                    [
                        'name' => 'Buy groceries',
                        'description' => 'Make a grocery list and go shopping at the supermarket',
                        'priority' => 'High',
                        'date_due' => '2023-06-14',
                        'category_id' => Category::where('name', 'Personal')->first()->id,
                        'user_id' => 1
                    ],
                    [
                        'name' => 'Call family members',
                        'description' => 'Reach out to family members and have a catch-up conversation',
                        'priority' => 'Medium',
                        'date_due' => '2023-06-16',
                        'category_id' => Category::where('name', 'Personal')->first()->id,
                        'user_id' => 1
                    ],
                    [
                        'name' => "Schedule doctor's appointment",
                        'description' => 'Call the doctor\'s office and schedule a check-up appointment',
                        'priority' => 'High',
                        'date_due' => '2023-06-13',
                        'category_id' => Category::where('name', 'Health')->first()->id,
                        'user_id' => 1
                    ],
                    [
                        'name' => 'Go for a jog',
                        'description' => 'Take a 30-minute jog in the park to stay active and fit',
                        'priority' => 'Low',
                        'date_due' => '2023-06-19',
                        'category_id' => Category::where('name', 'Health')->first()->id,
                        'user_id' => 1
                    ],
                    [
                        'name' => 'Read a book',
                        'description' => 'Set aside 30 minutes each day to read a book and expand knowledge',
                        'priority' => 'Medium',
                        'date_due' => '2023-06-17',
                        'category_id' => Category::where('name', 'Education')->first()->id,
                        'user_id' => 1
                    ],
                    [
                        'name' => 'Paint a picture',
                        'description' => 'Spend some time painting a picture using acrylic paints',
                        'priority' => 'Low',
                        'date_due' => '2023-06-20',
                        'category_id' => Category::where('name', 'Hobbies')->first()->id,
                        'user_id' => 1
                    ],
                ];
        
                Task::insert($tasks);

    }
}
