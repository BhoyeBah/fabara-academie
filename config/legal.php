<?php

return [
    // Changez cette version quand vous modifiez les CGU ou la politique de confidentialité :
    // les clients concernés devront les accepter à nouveau.
    'version' => env('LEGAL_VERSION', '2026-10'),
    'updated_at' => '16 octobre 2026',
    // Durée de conservation des commandes (obligations comptables), en années
    'orders_retention_years' => 10,
];
