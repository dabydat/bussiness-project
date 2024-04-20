<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'Argentina', 'iso_alpha_2' => 'AR', 'iso_alpha_3' => 'ARG', 'iso_numeric' => '032'],
            ['name' => 'Bolivia', 'iso_alpha_2' => 'BO', 'iso_alpha_3' => 'BOL', 'iso_numeric' => '068'],
            ['name' => 'Brazil', 'iso_alpha_2' => 'BR', 'iso_alpha_3' => 'BRA', 'iso_numeric' => '076'],
            ['name' => 'Chile', 'iso_alpha_2' => 'CL', 'iso_alpha_3' => 'CHL', 'iso_numeric' => '152'],
            ['name' => 'Colombia', 'iso_alpha_2' => 'CO', 'iso_alpha_3' => 'COL', 'iso_numeric' => '170'],
            ['name' => 'Costa Rica', 'iso_alpha_2' => 'CR', 'iso_alpha_3' => 'CRI', 'iso_numeric' => '188'],
            ['name' => 'Cuba', 'iso_alpha_2' => 'CU', 'iso_alpha_3' => 'CUB', 'iso_numeric' => '192'],
            ['name' => 'Dominican Republic', 'iso_alpha_2' => 'DO', 'iso_alpha_3' => 'DOM', 'iso_numeric' => '214'],
            ['name' => 'Ecuador', 'iso_alpha_2' => 'EC', 'iso_alpha_3' => 'ECU', 'iso_numeric' => '218'],
            ['name' => 'El Salvador', 'iso_alpha_2' => 'SV', 'iso_alpha_3' => 'SLV', 'iso_numeric' => '222'],
            ['name' => 'Guatemala', 'iso_alpha_2' => 'GT', 'iso_alpha_3' => 'GTM', 'iso_numeric' => '320'],
            ['name' => 'Honduras', 'iso_alpha_2' => 'HN', 'iso_alpha_3' => 'HND', 'iso_numeric' => '340'],
            ['name' => 'Mexico', 'iso_alpha_2' => 'MX', 'iso_alpha_3' => 'MEX', 'iso_numeric' => '484'],
            ['name' => 'Nicaragua', 'iso_alpha_2' => 'NI', 'iso_alpha_3' => 'NIC', 'iso_numeric' => '558'],
            ['name' => 'Panama', 'iso_alpha_2' => 'PA', 'iso_alpha_3' => 'PAN', 'iso_numeric' => '591'],
            ['name' => 'Paraguay', 'iso_alpha_2' => 'PY', 'iso_alpha_3' => 'PRY', 'iso_numeric' => '600'],
            ['name' => 'Peru', 'iso_alpha_2' => 'PE', 'iso_alpha_3' => 'PER', 'iso_numeric' => '604'],
            ['name' => 'Saint Kitts and Nevis', 'iso_alpha_2' => 'KN', 'iso_alpha_3' => 'KNA', 'iso_numeric' => '659'],
            ['name' => 'Saint Lucia', 'iso_alpha_2' => 'LC', 'iso_alpha_3' => 'LCA', 'iso_numeric' => '662'],
            ['name' => 'Saint Vincent and the Grenadines', 'iso_alpha_2' => 'VC', 'iso_alpha_3' => 'VCT', 'iso_numeric' => '670'],
            ['name' => 'Suriname', 'iso_alpha_2' => 'SR', 'iso_alpha_3' => 'SUR', 'iso_numeric' => '740'],
            ['name' => 'Trinidad and Tobago', 'iso_alpha_2' => 'TT', 'iso_alpha_3' => 'TTO', 'iso_numeric' => '780'],
            ['name' => 'Uruguay', 'iso_alpha_2' => 'UY', 'iso_alpha_3' => 'URY', 'iso_numeric' => '858'],
            ['name' => 'Venezuela, Bolivarian Republic of', 'iso_alpha_2' => 'VE', 'iso_alpha_3' => 'VEN', 'iso_numeric' => '862'],
            ['name' => 'Guyana', 'iso_alpha_2' => 'GY', 'iso_alpha_3' => 'GUY', 'iso_numeric' => '328'],
            ['name' => 'Haiti', 'iso_alpha_2' => 'HT', 'iso_alpha_3' => 'HTI', 'iso_numeric' => '332'],
            ['name' => 'Jamaica', 'iso_alpha_2' => 'JM', 'iso_alpha_3' => 'JAM', 'iso_numeric' => '388'],
            ['name' => 'El Salvador', 'iso_alpha_2' => 'SV', 'iso_alpha_3' => 'SLV', 'iso_numeric' => '222'],
            ['name' => 'Antigua and Barbuda', 'iso_alpha_2' => 'AG', 'iso_alpha_3' => 'ATG', 'iso_numeric' => '028'],
            ['name' => 'Barbados', 'iso_alpha_2' => 'BB', 'iso_alpha_3' => 'BRB', 'iso_numeric' => '052'],
            ['name' => 'Belize', 'iso_alpha_2' => 'BZ', 'iso_alpha_3' => 'BLZ', 'iso_numeric' => '084'],
            ['name' => 'Cayman Islands', 'iso_alpha_2' => 'KY', 'iso_alpha_3' => 'CYM', 'iso_numeric' => '136'],
            ['name' => 'Bermuda', 'iso_alpha_2' => 'BM', 'iso_alpha_3' => 'BMU', 'iso_numeric' => '060'],
            ['name' => 'Costa Rica', 'iso_alpha_2' => 'CR', 'iso_alpha_3' => 'CRI', 'iso_numeric' => '188'],
            ['name' => 'Dominica', 'iso_alpha_2' => 'DM', 'iso_alpha_3' => 'DMA', 'iso_numeric' => '212'],
            ['name' => 'Dominican Republic', 'iso_alpha_2' => 'DO', 'iso_alpha_3' => 'DOM', 'iso_numeric' => '214'],
            ['name' => 'Grenada', 'iso_alpha_2' => 'GD', 'iso_alpha_3' => 'GRD', 'iso_numeric' => '308'],
            ['name' => 'Guadeloupe', 'iso_alpha_2' => 'GP', 'iso_alpha_3' => 'GLP', 'iso_numeric' => '312'],
            ['name' => 'Montserrat', 'iso_alpha_2' => 'MS', 'iso_alpha_3' => 'MSR', 'iso_numeric' => '500'],
            ['name' => 'Germany', 'iso_alpha_2' => 'DE', 'iso_alpha_3' => 'DEU', 'iso_numeric' => '276'],
            ['name' => 'France', 'iso_alpha_2' => 'FR', 'iso_alpha_3' => 'FRA', 'iso_numeric' => '250'],
            ['name' => 'Italy', 'iso_alpha_2' => 'IT', 'iso_alpha_3' => 'ITA', 'iso_numeric' => '380'],
            ['name' => 'Spain', 'iso_alpha_2' => 'ES', 'iso_alpha_3' => 'ESP', 'iso_numeric' => '724'],
            ['name' => 'United Kingdom', 'iso_alpha_2' => 'GB', 'iso_alpha_3' => 'GBR', 'iso_numeric' => '826'],
            ['name' => 'Netherlands', 'iso_alpha_2' => 'NL', 'iso_alpha_3' => 'NLD', 'iso_numeric' => '528'],
            ['name' => 'Belgium', 'iso_alpha_2' => 'BE', 'iso_alpha_3' => 'BEL', 'iso_numeric' => '056'],
            ['name' => 'Austria', 'iso_alpha_2' => 'AT', 'iso_alpha_3' => 'AUT', 'iso_numeric' => '040'],
            ['name' => 'Switzerland', 'iso_alpha_2' => 'CH', 'iso_alpha_3' => 'CHE', 'iso_numeric' => '756'],
            ['name' => 'Sweden', 'iso_alpha_2' => 'SE', 'iso_alpha_3' => 'SWE', 'iso_numeric' => '752'],
            ['name' => 'Norway', 'iso_alpha_2' => 'NO', 'iso_alpha_3' => 'NOR', 'iso_numeric' => '578'],
            ['name' => 'Denmark', 'iso_alpha_2' => 'DK', 'iso_alpha_3' => 'DNK', 'iso_numeric' => '208'],
            ['name' => 'Finland', 'iso_alpha_2' => 'FI', 'iso_alpha_3' => 'FIN', 'iso_numeric' => '246'],
            ['name' => 'Russia', 'iso_alpha_2' => 'RU', 'iso_alpha_3' => 'RUS', 'iso_numeric' => '643'],
            ['name' => 'Poland', 'iso_alpha_2' => 'PL', 'iso_alpha_3' => 'POL', 'iso_numeric' => '616'],
            ['name' => 'Czech Republic', 'iso_alpha_2' => 'CZ', 'iso_alpha_3' => 'CZE', 'iso_numeric' => '203'],
            ['name' => 'Hungary', 'iso_alpha_2' => 'HU', 'iso_alpha_3' => 'HUN', 'iso_numeric' => '348'],
            ['name' => 'Romania', 'iso_alpha_2' => 'RO', 'iso_alpha_3' => 'ROU', 'iso_numeric' => '642'],
            ['name' => 'Bulgaria', 'iso_alpha_2' => 'BG', 'iso_alpha_3' => 'BGR', 'iso_numeric' => '100'],
            ['name' => 'Greece', 'iso_alpha_2' => 'GR', 'iso_alpha_3' => 'GRC', 'iso_numeric' => '300'],
            ['name' => 'Portugal', 'iso_alpha_2' => 'PT', 'iso_alpha_3' => 'PRT', 'iso_numeric' => '620'],
            ['name' => 'Ireland', 'iso_alpha_2' => 'IE', 'iso_alpha_3' => 'IRL', 'iso_numeric' => '372']
        ];

        foreach ($countries as $country) {
            DB::table('countries')->insert([
                'name' => $country['name'],
                'iso_alpha_2' => $country['iso_alpha_2'],
                'iso_alpha_3' => $country['iso_alpha_3'],
                'iso_numeric' => $country['iso_numeric'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
