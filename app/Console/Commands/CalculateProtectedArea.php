<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MountainProtectionService;

class CalculateProtectedArea extends Command
{
    protected $mountainProtectionService;

    public function __construct(MountainProtectionService $mountainProtectionService)
    {
        parent::__construct();
        $this->mountainProtectionService = $mountainProtectionService;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-protected-area {width? : La largeur du continent} {altitudes?* : Les altitudes du terrain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calcule la surface protégée par les montagnes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $width = $this->argument('width');
        $altitudes = $this->argument('altitudes');

        // Vérifier si les arguments sont fournis
        if (is_null($width) || empty($altitudes)) {
            $this->error("Erreur : Vous devez spécifier la largeur du continent et au moins une altitude.");
            $this->error("Usage : php artisan app:calculate-protected-area {width} {altitudes...}");
            return;
        }

        // Valider les arguments
        if (!$this->validateArguments($width, $altitudes)) {
            return;
        }

        // Calculer la surface protégée
        try {
            $protectedArea = $this->mountainProtectionService->calculateProtectedArea($altitudes);
            $this->info("Surface protégée : " . $protectedArea);
        } catch (\Exception $e) {
            $this->error("Une erreur s'est produite : " . $e->getMessage());
        }
    }

    /**
     * Validate the command arguments.
     *
     * @param  mixed  $width
     * @param  array  $altitudes
     * @return bool
     */
    private function validateArguments($width, array $altitudes)
    {
        if (!$this->isValidWidth($width)) {
            return false;
        }

        if (!$this->isValidAltitudes($width, $altitudes)) {
            return false;
        }

        return true;
    }

    /**
     * Validate the width argument.
     *
     * @param  mixed  $width
     * @return bool
     */
    private function isValidWidth($width)
    {
        if (!is_numeric($width)) {
            $this->error("La largeur du continent doit être un entier.");
            return false;
        }

        if ($width < 1 || $width > 100000) {
            $this->error("La largeur du continent {$width} doit être comprise entre 1 et 100 000.");
            return false;
        }

        return true;
    }

    /**
     * Validate the altitudes argument.
     *
     * @param  int  $width
     * @param  array  $altitudes
     * @return bool
     */
    private function isValidAltitudes($width, array $altitudes)
    {
        if (count($altitudes) != $width) {
            $this->error("Le nombre d'altitudes doit être égal à la largeur du continent ({$width}).");
            return false;
        }

        foreach ($altitudes as $altitude) {
            if (!is_numeric($altitude)) {
                $this->error("Toutes les altitudes doivent être des nombres.");
                return false;
            }

            if ($altitude < 0 || $altitude > 100000) {
                $this->error("La hauteur {$altitude} doit être comprise entre 0 et 100 000.");
                return false;
            }
        }

        return true;
    }
}
