<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;
use App\Models\Imports\CurrencyExchangeRate;

class ImportCurrencyExchangeRates extends Command
{
    protected $signature = 'import:currency-exchange-rates';
    protected $description = 'Import currency exchange rates from ECB XML feed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $response = Http::get('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-hist.xml');
            $xml = simplexml_load_string($response->body());
            // Codigo para insertar todos los del dia actual

            foreach ($xml->Cube->Cube->Cube as $rate) {
                $existingRate = CurrencyExchangeRate::where('currency', $rate['currency'])->where('rate', $rate['rate'])->where('date', $xml->Cube->Cube['time'])->exists();
                if (!$existingRate) {
                    CurrencyExchangeRate::create([
                        'currency' => $rate['currency'],
                        'rate' => $rate['rate'],
                        'date' => $xml->Cube->Cube['time']
                    ]);
                }
            }

            // Codigo para insertar todos los registros historicos hasta la ultima fecha
            
            // foreach ($xml->Cube->Cube as $cube) {
            //     foreach ($cube->Cube as $rate) {
            //         $existingRate = CurrencyExchangeRate::where('currency', $rate['currency'])->where('date', $cube['time'])->first();
            //         if (!$existingRate) {
            //             CurrencyExchangeRate::create([
            //                 'currency' => $rate['currency'],
            //                 'rate' => $rate['rate'],
            //                 'date' => $cube['time']
            //             ]);
            //         }
            //     }
            // }

            $this->info('Currency exchange rates imported successfully.');
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }

    }
}
