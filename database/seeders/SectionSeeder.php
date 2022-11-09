<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            'Теория',
            'Дополнительные материалы',
            'Практика',
            'Домашнее задание',
            'Контроль'
        ];

        foreach ($titles as $title) {
            Section::create([
                'title' => $title
            ]);
        }
    }
}
