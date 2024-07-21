<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedecinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => 'fstmedecin@gmail.com',
            'password' => Hash::make('test12345'),
            'nom' => 'FST',
            'prenom' => 'Medecin',
            'genre' => true,
            'dateNaissance' => '04/02/1990',
            'adresse' => 'Badalabougou',
            'telephone' => '76710981',
            'hopital' => 'FST Hopital',
            'specialite' => 'Dentiste'
        ];
    }
}
