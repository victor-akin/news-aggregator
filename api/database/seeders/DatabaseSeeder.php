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
        DB::table('news_categories')->insert([
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

        DB::table('news_sources')->insert([
            ['name' => 'BBC', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'The Verge', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'NY Times', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bloomberg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ESPN', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('news_authors')->insert([
            ['name' => 'Casey Newton', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nilay Patel', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dieter Bohn', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ashley Carman', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Liz Lopatto', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Matt Levine', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Barry Ritholtz', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emily Chang', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Joe Weisenthal', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sarah Green Carmichael', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nick Bilton', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kara Swisher', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'David Leonhardt', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Maureen Dowd', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Paul Krugman', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mina Kimes', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bill Barnwell', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Zach Lowe', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Adrian Wojnarowski', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Katie Nolan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Andrew Marr', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Robert Peston', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emily Maitlis', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Laura Kuenssberg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Samira Ahmed', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('sources')->insert([
            [
                'url' => 'https://newsapi.org',
                'handler' => 'NewsApi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'url' => 'https://content.guardianapis.com',
                'handler' => 'TheGuardian',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'url' => 'https://api.nytimes.com',
                'handler' => 'NyTimes',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'url' => 'http://api.mediastack.com',
                'handler' => 'MediaStack',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'url' => 'https://api.newscatcherapi.com',
                'handler' => 'NewsCatcher',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
