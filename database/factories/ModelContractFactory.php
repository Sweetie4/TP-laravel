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
            'content'=>'[{"id":"jZcaNP7sD2","type":"header","data":{"text":"BAIL POUR ESPACE DE STOCKAGE","level":2}},{"id":"scDFA0Dx0k","type":"paragraph","data":{"text":"ENTRE LES SOUSSIGNÉS"}},{"id":"kdF-G0ml-K","type":"table","data":{"withHeadings":false,"stretched":false,"content":[["LE BAILLEUR","LE LOCATAIRE"],["#user.name#","#tenant.name#"]]}},{"id":"r0X8GkI1jy","type":"paragraph","data":{"text":"IL A ETE ARRETE ET CONCENU CE QUI SUIT :"}},{"id":"1m9tOmh3_0","type":"paragraph","data":{"text":"      Le Bailleur louant les locaux et équipements ci après, désignés, au Locataire qui les accepte aux conditions suivantes."}},{"id":"xJ-M8x4YA3","type":"paragraph","data":{"text":"            DESIGNATION : Box fermé"}},{"id":"BrOov-8_R3","type":"paragraph","data":{"text":"            Localisation : #box.address#"}},{"id":"rt3XsD5YV4","type":"paragraph","data":{"text":"            Les locaux sont parfaitement connus du preneur, qui déclare les avoir examinés et ne pas demander de description plus déraillée."}},{"id":"qOgu4uJ7EI","type":"paragraph","data":{"text":"            DUREE : "}},{"id":"8BwAF0i76j","type":"paragraph","data":{"text":"            Date de prise effective du bail : #date.start#"}},{"id":"kzys4ePAWE","type":"paragraph","data":{"text":"            Date de fin effective du bail : #date.end#"}},{"id":"F631qlB8Bx","type":"paragraph","data":{"text":"            MONTANT : "}},{"id":"GikR81J0RJ","type":"paragraph","data":{"text":"            #tenant.name# doit s\'acquitter de #price.month# € par mois,  soit #price.total# € au total."}}]'

        ];
    }
}
