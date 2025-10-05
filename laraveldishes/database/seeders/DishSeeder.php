<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dish;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DishSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('password')]
        );
        $admin->assignRole('Admin');

        User::factory()->count(3)->create();

        // tiny 1x1 JPEG (base64) as network fallback
        $fallbackJpeg = base64_decode(
            '/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxISEhUTEhMWFhUXGBgYGBgYGBgYGBgYGBgYGBgYHCggGBolGxgYITEhJSkrLi4uGB8zODMtNygtLisBCgoKDg0OGhAQGi0lHyUtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLf/AABEIAKAAoAMBIgACEQEDEQH/xAAVAAEBAAAAAAAAAAAAAAAAAAAABf/EABYBAQEBAAAAAAAAAAAAAAAAAAABAv/aAAwDAQACEAMQAAABqAqkAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA//EABkQAQADAQEAAAAAAAAAAAAAAAIBAxEAIf/aAAgBAQABBQL1b7f0qP5wOta1p//EABcRAQADAAAAAAAAAAAAAAAAAAEAESH/2gAIAQMBAT8BvE//xAAXEQEAAwAAAAAAAAAAAAAAAAABABAR/9oACAECAQE/AaIs/8QAHBAAAgICAwAAAAAAAAAAAAAAAREAAgMhMUFR/9oACAEBAAY/Alp6m6r0g8v3b0v1C7qQ3x6EJ3sS3//xAAcEAEAAgIDAQAAAAAAAAAAAAABABEhMUFRYbH/2gAIAQEAAT8h9a3eNwTtqYIh2QdQ1bY9D1i4p0i3oX2k6m1l9l3U5rI6rVQ8zvQY4d2w+QpU0w+5Q=='
        );

        Dish::factory()->count(12)->create()->each(function ($dish) use ($fallbackJpeg) {
            $url = 'https://loremflickr.com/640/480/dish';
            $bin = null;

            try {
                $bin = @file_get_contents($url);
            } catch (\Throwable $e) {
                $bin = false;
            }

            if ($bin === false || $bin === null) {
                $bin = $fallbackJpeg;
            }

            Storage::disk('public')->put($dish->image_path, $bin);
        });
    }
}
