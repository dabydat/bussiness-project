<?php

namespace App\Http\Controllers\APIRequest;

use Carbon\Carbon;
use App\API\GuzzleClientApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\JsonResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\API\HistoryConversionRate;

class ConversionRatesController extends Controller
{
    protected $baseCurrency = 'USD';
    protected $apiUrl;
    protected $apiToken;

    public function __construct()
    {
        $this->apiUrl = env('API_ACCESS_LINK');
        $this->apiToken = env('API_KEY');
    }

    public function getConversionRates(Request $request)
    {
        DB::beginTransaction();
        try {
            $currency = $request->baseCurrency ?? $this->baseCurrency;
            // Carbon::now()->utc() devuelve la fecha y hora actual en formato UTC. Luego, utilizamos el método setTime(0, 0, 1) para establecer la hora a 00:00:01. Finalmente, utilizamos el método unix() para obtener los valores en formato Unix timestamp.
            $timeLastUpdateUnix = Carbon::now()->utc()->setTime(0, 0, 1)->unix();
            $timeNextUpdateUnix = Carbon::tomorrow()->utc()->setTime(0, 0, 1)->unix();
            $data = HistoryConversionRate::getConversionRatesByCurrencyAndTimestamp($currency, $timeLastUpdateUnix, $timeNextUpdateUnix);
            if (!is_null($data)) {
                return JsonResponseHelper::success('Conversion Rates', ['base_currency' => $currency, 'data' => json_decode($data->conversion_rates)]);
            }

            $url = $this->apiUrl . $this->apiToken . 'latest/' . $currency;
            $data = GuzzleClientApi::getRequest($url);
            $data = json_decode($data);
            HistoryConversionRate::create([
                'base_currency' => $data->base_code,
                'conversion_rates' => json_encode($data->conversion_rates),
                'time_last_update_unix' => $data->time_last_update_unix,
                'time_next_update_unix' => $data->time_next_update_unix
            ]);
            DB::commit();
            return JsonResponseHelper::success('Conversion Rates', ['base_currency' => $currency, 'data' => $data->conversion_rates]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return JsonResponseHelper::error('Something went wrong', $th->getMessage());
        }

    }
}
