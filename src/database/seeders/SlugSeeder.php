<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Movie::whereIsNull('slug')->get()->each(function ($movie) {
            $movie->slug = Str::slug($movie->title) . '-' . uniqid();
            $movie->save();
        });
        Event::whereIsNull('slug')->get()->each(function ($event) {
            $event->slug = Str::slug($event->title) . '-' . uniqid();
            $event->save();
        });
    }
}
