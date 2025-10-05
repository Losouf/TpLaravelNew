<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class DishFactory extends Factory
{
    public function definition(): array
    {
        $faker = $this->faker;
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));

        return [
            'user_id' => User::factory(),
            'name' => $faker->foodName(),
            'image_path' => 'dishes/'.Str::uuid().'.jpg',
            'description' => $faker->text(400),
            'recipe' => $faker->paragraphs(3, true),
        ];
    }
}
