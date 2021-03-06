<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();
        $users = User::all();
        $user = $users->random();

        $random_datetime = [
            new DateTime(),
            $faker->dateTimeBetween('-1 week', '-3 day', 'Europe/Paris'),
            $faker->dateTimeBetween('-3 week', '-1 week', 'Europe/Paris'),
            $faker->dateTimeBetween('-6 month', '-1 month', 'Europe/Paris'),
            $faker->dateTimeBetween('-2 year', '-1 year', 'Europe/Paris'),
            $faker->dateTimeBetween('-8 year', '-5 year', 'Europe/Paris'),
            $faker->dateTime,
        ];
        $datetime = $faker->randomElements($random_datetime);

        $text = [
            $faker->paragraph($faker->numberBetween(2, 10), true),
            $faker->paragraph($faker->numberBetween(2, 10), true),
        ];
        $text = implode("\n\n", $text);
        $text = explode(' ', $text);
        foreach ($text as $key => $word) {
            if (! strpos($word, '.')) {
                if (0 === $key % 8) {
                    $text[$key] = "*{$word}*";
                }
                if (0 === $key % 9) {
                    $text[$key] = "**{$word}**";
                }
            }
        }
        $date = $datetime[0]->format('Y-m-d H:i:s');

        return [
            'text' => Str::markdown(implode(' ', $text)),
            'rating' => $faker->numberBetween(null, 5),
            'created_at' => new DateTime($date),
        ];
    }
}
