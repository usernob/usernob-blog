<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use App\Models\Tag;
use App\Models\TagRelation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->create()
            ->each(function ($user) {
                $user->posts()->saveMany(
                    Post::factory()
                        ->count(20)
                        ->make(),
                );
            });

        Tag::factory(5)->create();

        foreach (Post::all() as $post) {
            foreach (Tag::all() as $tag) {
                TagRelation::create([
                    'post_id' => $post->id,
                    'tag_id' => $tag->id,
                ]);
            }
        }
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
