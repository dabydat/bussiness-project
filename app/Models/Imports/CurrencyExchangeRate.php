<?php

namespace App\Models\Imports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyExchangeRate extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['currency', 'rate', 'date'];
}
