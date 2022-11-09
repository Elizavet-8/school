<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chapter;

class ChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            'Алгебраические дроби',
            'Функция у=√у. Свойства квадратного корня',
        ];

        $i = 1;

        foreach ($titles as $title) {
            Chapter::create([
                'title' => $title,
                'order' => $i,
                'course_id' => 1
            ]);

            $i++;
        }
    }
}
