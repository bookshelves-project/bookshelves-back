<?php

namespace Database\Factories;

use App\Enums\PostStatusEnum;
use App\Faker\FakerHtmlProvider;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new FakerHtmlProvider($this->faker));
        $title = ucfirst($this->faker->words(3, true));

        return [
            'title' => $title,
            'status' => $this->faker->randomElement(PostStatusEnum::toValues()),
            'summary' => $this->faker->paragraph(),
            'body' => $this->faker->htmlParagraphs(),
            'published_at' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'pin' => $this->faker->boolean(25),
            'meta_title' => ucfirst($this->faker->words(3, true)),
            'meta_description' => $this->faker->paragraph(),
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function draft()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => PostStatusEnum::draft,
            ];
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function scheduled()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => PostStatusEnum::scheduled,
                'published_at' => Carbon::today()->addWeek(),
            ];
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => PostStatusEnum::published,
                'published_at' => Carbon::today()->subWeek(),
            ];
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withMeta()
    {
        return $this->state(function (array $attributes) {
            return [
                'meta_title' => ucfirst($this->faker->words(3, true)),
                'meta_description' => $this->faker->paragraph(),
            ];
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function pinned()
    {
        return $this->state(function (array $attributes) {
            return [
                'pin' => true,
            ];
        });
    }
}
