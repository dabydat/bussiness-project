<?php

namespace App\Models\Enterprise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        'activity',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public static function getAllActivities($skip, $take)
    {
        return Activity::skip($skip)->take($take)->get();
    }

}
