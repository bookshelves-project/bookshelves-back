<?php

namespace Database\Factories;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = $this->faker->randomElements(GenderEnum::toArray())[0];
        $pronouns_options = ['she', 'he', 'they'];
        $pronouns = 'they';
        if ('WOMAN' === $gender) {
            $pronouns = 'she';
        } elseif ('MAN' === $gender) {
            $pronouns = 'he';
        } else {
            $pronouns = $this->faker->randomElements($pronouns_options, $this->faker->numberBetween(1, 2));
            $pronouns = implode(', ', $pronouns);
        }

        return [
            'name' => "{$this->faker->firstName()} {$this->faker->lastName()}",
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'about' => $this->faker->text(),
            'use_gravatar' => false,
            'display_favorites' => $this->faker->boolean(),
            'display_reviews' => $this->faker->boolean(),
            'display_gender' => $this->faker->boolean(),
            'role' => RoleEnum::user->name,
            'gender' => $gender,
            'pronouns' => $pronouns,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the model's is inactive.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'active' => false,
            ];
        });
    }

    /**
     * Indicate that the model's role is super admin.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function superAdmin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => RoleEnum::super_admin->name,
            ];
        });
    }

    /**
     * Indicate that the model's role is admin.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => RoleEnum::admin->name,
            ];
        });
    }
}
