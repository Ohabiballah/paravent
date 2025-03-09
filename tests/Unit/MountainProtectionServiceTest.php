<?php

namespace Tests\Unit;

use App\Services\MountainProtectionService;
use PHPUnit\Framework\TestCase;

class MountainProtectionServiceTest extends TestCase
{
    protected $mountainProtectionService;

    protected function setUp(): void
    {
        parent::setUp();
        // Créer une instance du service MountainProtectionService
        $this->mountainProtectionService = new MountainProtectionService();
    }

    /** @test */
    public function it_should_calculate_the_protected_area_correctly()
    {
        // Exemple de tableau d'altitudes
        $altitudes = [100, 200, 150, 180, 170];

        // Appeler la méthode de calcul
        $protectedArea = $this->mountainProtectionService->calculateProtectedArea($altitudes);

        // Vérifier le résultat attendu
        $this->assertEquals(3, $protectedArea);
    }

    /** @test */
    public function it_should_return_zero_for_all_ascending_mountains()
    {
        // Si toutes les montagnes sont ascendantes, aucune zone n'est protégée
        $altitudes = [100, 200, 300, 400, 500];

        $protectedArea = $this->mountainProtectionService->calculateProtectedArea($altitudes);

        $this->assertEquals(0, $protectedArea);
    }

    /** @test */
    public function it_should_return_zero_for_flat_mountains()
    {
        // Si toutes les montagnes ont la même hauteur, aucune zone n'est protégée
        $altitudes = [200, 200, 200, 200];

        $protectedArea = $this->mountainProtectionService->calculateProtectedArea($altitudes);

        $this->assertEquals(0, $protectedArea);
    }

    /** @test */
    public function it_should_return_correct_protected_area_with_mixed_heights()
    {
        // Test avec une combinaison de montagnes de différentes hauteurs
        $altitudes = [100, 200, 150, 180, 170, 210, 190];

        $protectedArea = $this->mountainProtectionService->calculateProtectedArea($altitudes);

        $this->assertEquals(4, $protectedArea); // Montagnes protégées : 150, 180, 170, 190
    }

    /** @test */
    public function it_should_return_zero_for_empty_array()
    {
        // Si le tableau est vide, la surface protégée devrait être 0
        $altitudes = [];

        $protectedArea = $this->mountainProtectionService->calculateProtectedArea($altitudes);

        $this->assertEquals(0, $protectedArea);
    }
}
