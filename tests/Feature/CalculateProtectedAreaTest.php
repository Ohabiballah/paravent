<?php

namespace Tests\Feature;

use App\Console\Commands\CalculateProtectedArea;
use App\Services\MountainProtectionService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class CalculateProtectedAreaTest extends TestCase
{
    protected $mountainProtectionServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock MountainProtectionService
        $this->mountainProtectionServiceMock = Mockery::mock(MountainProtectionService::class);
        $this->app->instance(MountainProtectionService::class, $this->mountainProtectionServiceMock);
    }

    /** @test */
    public function it_should_validate_arguments_correctly()
    {
        // Test invalid width
        $exitCode = Artisan::call('app:calculate-protected-area', [
            'width' => 'invalid', 
            'altitudes' => [100, 200, 300]
        ]);

        $this->assertStringContainsString('La largeur du continent doit être un entier.', Artisan::output());

        // Test valid width but invalid altitudes count
        $exitCode = Artisan::call('app:calculate-protected-area', [
            'width' => 3, 
            'altitudes' => [100, 200]
        ]);

        $this->assertStringContainsString("Le nombre d'altitudes doit être égal à la largeur du continent (3).", Artisan::output());
    }

    /** @test */
    public function it_should_calculate_protected_area_correctly()
    {
        // Simuler un calcul de la surface protégée
        $altitudes = [100, 200, 150];
        $width = count($altitudes);

        // Mock la méthode calculateProtectedArea
        $this->mountainProtectionServiceMock
            ->shouldReceive('calculateProtectedArea')
            ->with($altitudes)
            ->once()
            ->andReturn(450);

        // Exécuter la commande
        $exitCode = Artisan::call('app:calculate-protected-area', [
            'width' => $width, 
            'altitudes' => $altitudes
        ]);

        $this->assertStringContainsString('Surface protégée : 450', Artisan::output());
    }

    /** @test */
    public function it_should_handle_exception_properly()
    {
        $altitudes = [100, 200, 300];
        $width = count($altitudes);

        // Simuler une exception dans la méthode calculateProtectedArea
        $this->mountainProtectionServiceMock
            ->shouldReceive('calculateProtectedArea')
            ->with($altitudes)
            ->once()
            ->andThrow(new \Exception('Une erreur interne est survenue'));

        // Exécuter la commande
        $exitCode = Artisan::call('app:calculate-protected-area', [
            'width' => $width, 
            'altitudes' => $altitudes
        ]);

        $this->assertStringContainsString("Une erreur s'est produite : Une erreur interne est survenue", Artisan::output());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
