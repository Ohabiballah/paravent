<?php

namespace App\Services;

class MountainProtectionService
{
    /**
     * Calcule la surface protégée par les montagnes.
     *
     * @param array $altitudes
     * @return int
     */
    public function calculateProtectedArea(array $altitudes): int
    {
        $maxHeight = 0; // Hauteur maximale rencontrée
        $protectedArea = 0;

        foreach ($altitudes as $height) {
            if ($height >= $maxHeight) {
                $maxHeight = $height; // Si la montagne est plus haute, on met à jour la hauteur maximale
            } else {
                $protectedArea++; // Si la montagne est inférieure, elle est protégée
            }
        }

        return $protectedArea;
    }
}
