<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => 'msakine20@gmail.com',
            'password' => Hash::make('test12345'),
            'nom' => 'Sakine',
            'prenom' => 'Fily Mohamed',
            'genre' => true,
            'dateNaissance' => '2001-08-20',
            'adresse' => 'Moribabougou',
            'telephone' => '94865291'
        ];
    }
}
