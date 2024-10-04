<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ModelContract>
 */
class ModelContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIDs = User::pluck('id');
        return [
            'landlord_id'=> fake()->randomElement($userIDs),
            'name'=>random_int(1000,9999),
            'content'=>"BAIL POUR ESPACE DE STOCKAGE
            ENTRE LES SOUSSIGNES 
            
            LE BAILLEUR : M #user.name# d'une part.
            LE LOCATAIRE : M #tenant.first_name# #tenant.last_name#, demeurant #tenant.address# d'autre part.
            
            IL A ETE ARRETE ET CONVENU CE QUI SUIT?
            
            Le Bailleur louant les locaux et équipements ci après, désignés, au Locataire qui les accepte aux conditions suivantes.
            
            DESIGNATION : Box fermé
            
            Localisation : #box.address#
            
            Les locaux sont parfaitement connus du preneur, qui déclare les avoir examinés et ne pas demander de description plus déraillée.
            "

        ];
    }
}
