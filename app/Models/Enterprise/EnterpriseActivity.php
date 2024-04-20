<?php

namespace App\Models\Enterprise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterpriseActivity extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'enterprise_id',
        'activity_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public static function getAllEnterpriseActivities($request, $skip, $take)
    {
        $enterprises = new EnterpriseActivity;
        if($request->enterprise_id <> "") $enterprises = $enterprises->where('enterprise_id', $request->enterprise_id);
        if($request->activity_id <> "") $enterprises = $enterprises->where('activity_id', $request->activity_id);
        $enterprises = $request->enterprise_name <> "" ? $enterprises->with(['enterprises'  => function ($query) use ($request) {$query->where('enterprises.name', 'ilike', '%' . $request->enterprise_name . '%');}]) : $enterprises->with(['enterprises']);
        $enterprises = $request->activity <> "" ? $enterprises->with(['activities'  => function ($query) use ($request) {$query->where('activity', 'ilike', '%' . $request->activity . '%');}]) : $enterprises->with(['activities']);
        return $enterprises->skip($skip)->take($take)->get();
    }

    public static function enterpriseActivityExists($enterprise_id, $activity_id)
    {
        return EnterpriseActivity::where('enterprise_id', $enterprise_id)->where('activity_id', $activity_id)->exists();
    }

    public function enterprises()
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id');
    }

    public function activities()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
