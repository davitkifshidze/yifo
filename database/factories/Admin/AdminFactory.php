<?php

namespace Database\Factories\Admin;


use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelsAdminAdmin>
 */
class AdminFactory extends Factory
{

    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->userName,
            'email' => $this->faker->safeEmail,
            'password' => bcrypt('admin'),
            'remember_token' => Str::random(10),
        ];
    }
}
