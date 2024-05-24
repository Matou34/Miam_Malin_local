<?php   

namespace App\Service;

use App\Entity\Recettes;

class IngredientsAggreges {

// Cette fonction parcourt les étapes d'une recette et agrège les quantités des ingrédients utilisés, en 
// s 'assurant que chaque ingrédient est comptabilisé une seule fois avec sa quantité totale et son unité de mesure
// cette fonction parcourt toutes les étapes d'une recette et toutes les quantités d'ingrédients dans ces étapes, en ignorant les ingrédients sans produit ou unité et en agrégeant 
// la quantité totale pour chaque ingrédient dans un tableau, tout en conservant 
// l'unité de mesure de chaque ingrédient.
    function Ingrédients(Recettes $Recet) {

        $ingredientsAggreges = [];

        foreach ($Recet->getEtapes() as $etape) {
            foreach ($etape->getQuantites() as $quantite) {
                $produit = $quantite->getProduits();
                $unite = $quantite->getUnites();
                $nomIngredient = $produit ? $produit->getPRLIBELLE() : '';

                if (!$produit && !$nomIngredient) {
                    continue;
                }

                if (!array_key_exists($nomIngredient, $ingredientsAggreges)) {
                    $ingredientsAggreges[$nomIngredient] = [
                        'quantite' => 0,
                        'unite' => $unite ? $unite->getUnLibelle() : ''
                    ];
                }
                $ingredientsAggreges[$nomIngredient]['quantite'] += $quantite->getQuQuantites() ?? 0;
            }
        }
    }
}
