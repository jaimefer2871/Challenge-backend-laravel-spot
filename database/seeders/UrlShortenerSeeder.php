<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UrlShortenerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $urls = [
            [
                'original'      => 'https://spot2.mx/servicios-adicionales/solara',
                'shortened'     => 'cc65cc3d',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'original'      => 'https://www.eleconomista.com.mx/econohabitat/Spot2-hace-frente-a-la-sequia-de-inversion-en-proptech-con-ronda-Serie-A-20240507-0132.html',
                'shortened'     => 'daac066f',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'original'      => 'https://www.eleconomista.com.mx/politica/efemeride-25-noviembre-dia-internacional-eliminacion-violencia-mujer-20241124-735207.html',
                'shortened'     => '1372a210',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ];
        DB::table('urlshorteners')->insert($urls);
    }
}
