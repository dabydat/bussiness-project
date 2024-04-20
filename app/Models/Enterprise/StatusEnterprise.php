<?php

namespace App\Models\Enterprise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusEnterprise extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'description',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
