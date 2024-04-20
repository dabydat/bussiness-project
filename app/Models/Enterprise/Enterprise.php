<?php

namespace App\Models\Enterprise;

use App\Enterprise\Enums\StatusEnum;
use App\Enums\Enterprise\DocumentTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'document_type',
        'status',
        'user_id',
        'country_id',
        'location',
        'phone_number'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public static function getAllEnterprises($request, $skip, $take)
    {
        $enterprises = new Enterprise;
        if($request->name <> "") $enterprises = $enterprises->where('name', 'ilike', '%' . $request->name . '%');
        if($request->email <> "") $enterprises = $enterprises->where('email', 'ilike', '%' . $request->email . '%');
        if($request->document_type <> "") $enterprises = $enterprises->where('document_type', $request->document_type);
        if($request->status <> "") $enterprises = $enterprises->where('status', $request->status);
        if($request->country_id <> "") $enterprises = $enterprises->where('country_id', $request->country_id);
        if($request->location <> "") $enterprises = $enterprises->where('location', 'ilike', '%' . $request->location . '%');
        if($request->phone_number <> "") $enterprises = $enterprises->where('phone_number', 'ilike', '%' . $request->phone_number . '%');
        if($request->user_id <> "") $enterprises = $enterprises->where('user_id', $request->user_id);
        return $enterprises->skip($skip)->take($take)->get();
    }

    // Obtener las empresas que no tienen actividades registradas
    public static function getEnterpriseWithoutActivities($skip, $take)
    {
        $enterprises = Enterprise::join('enterprise_activities', 'enterprises.id', '=', 'enterprise_activities.enterprise_id')->pluck('enterprises.id')->toArray();
        return Enterprise::whereNotIn('id', $enterprises)->skip($skip)->take($take)->get();
    }
}
