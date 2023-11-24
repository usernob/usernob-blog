<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Tag::factory(15)->create();

        User::factory()
            ->create()
            ->each(function ($user) {
                $user->posts()->saveMany(
                    Post::factory()
                        ->count(20)
                        ->make(),
                );
            });

        foreach (Post::all() as $post) {
            $post->tags()->attach(Tag::all()->random(rand(1, 8)));
        }
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
