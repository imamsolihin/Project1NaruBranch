<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = [
            'Desainer',
            'IT',
            'Marketing',
            'Bendahara',
            'Management',
            'Sekretaris'
        ];

        foreach ($divisions as $d) {
            Division::firstOrCreate([
                'name' => $d
            ]);
        }
    }
}