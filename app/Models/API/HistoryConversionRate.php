<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoryConversionRate extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['base_currency', 'conversion_rates', 'time_last_update_unix', 'time_next_update_unix'];

    public static function getConversionRatesByCurrencyAndTimestamp($currency, $timeLastUpdateUnix, $timeNextUpdateUnix)
    {
        return HistoryConversionRate::where('base_currency', $currency)
            ->where('time_last_update_unix', $timeLastUpdateUnix)
            ->where('time_next_update_unix', $timeNextUpdateUnix)
            ->first();
    }
}
