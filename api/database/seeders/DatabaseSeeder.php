<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Business', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Technology', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Science', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Health', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sports', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Entertainment', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Politics', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Education', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Humor', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Food', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Style', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Culture', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'World', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('sources')->insert([
            [
                'url' => 'https://newsapi.org',
                'crawler' => 'NewsApi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'url' => 'https://content.guardianapis.com',
                'crawler' => 'TheGuardian',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'url' => 'https://api.nytimes.com',
                'crawler' => 'NyTimes',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'url' => 'http://api.mediastack.com',
                'crawler' => 'MediaStack',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'url' => 'https://api.newscatcherapi.com',
                'crawler' => 'NewsCatcher',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
