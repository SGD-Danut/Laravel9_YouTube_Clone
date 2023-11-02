<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Film & Animation',
            'Autos & Vehicles',
            'Music',
            'Pets & Animals',
            'Sports',
            'Travel & Events',
            'Gaming',
            'People & Blogs',
            'Comedy',
            'Entertainment',
            'News & Politics',
            'Howto & Style',
            'Education',
            'Science & Technology',
            'Nonprofits & Activism',
        ];
        foreach ($categories as $category) {
            DB::table('categories')->insert(['title' => $category,]);
        }
    }
}
