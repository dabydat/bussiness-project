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

    public static function getAllActivities($request, $skip, $take)
    {
        $activities = new Activity;
        if($request->activity <> "") $activities = $activities->where('activity', 'ilike', '%' . $request->activity . '%');
        return $activities->skip($skip)->take($take)->get();
    }

}
