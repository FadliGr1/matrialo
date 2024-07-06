<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Vendor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::where('role', 'vendor')->pluck('id')->toArray();

        return [
            'vendor_name' => $this->faker->company,
            'alamat' => $this->faker->address,
            'alamat_gudang' => $this->faker->address,
            'penanggung_jawab' => $this->faker->randomElement($users),
        ];
    }
}
