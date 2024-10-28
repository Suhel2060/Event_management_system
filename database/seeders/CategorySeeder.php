<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Technology'],
            ['name' => 'Health'],
            ['name' => 'Education'],
            ['name' => 'Entertainment'],
            ['name' => 'Sports'],
            ['name' => 'Finance'],
            ['name' => 'Travel'],
            ['name' => 'Lifestyle'],
            ['name' => 'Food'],
            ['name' => 'Fashion'],
        ]);
    }
}
