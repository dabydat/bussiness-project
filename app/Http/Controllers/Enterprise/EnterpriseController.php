<?php

namespace App\Http\Controllers\Enterprise;

use App\Config\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\JsonResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Enterprise\Enterprise;
use App\Http\Requests\Enterprise\CreateEnterpriseRequest;

class EnterpriseController extends Controller
{
    public function getAllEnterprises(Request $request)
    {
        $skip = $request->skip ?? Pagination::SKIP;
        $take = $request->take ?? Pagination::TAKE;
        return Enterprise::getAllEnterprises($request, $skip, $take);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeEnterprise(CreateEnterpriseRequest $request)
    {
        DB::beginTransaction();
        try {
            if (Enterprise::where('user_id', $request->user_id)->exists()) {
                return JsonResponseHelper::error('User already has an enterprise. You just can have one.');
            }
            Enterprise::create($request->all());
            DB::commit();
            return JsonResponseHelper::resourceCreated('Enterprise created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return JsonResponseHelper::error('Something went wrong', $th->getMessage());
        }
    }

    public function getEnterpriseWithoutActivities(Request $request)
    {
        $skip = $request->skip ?? Pagination::SKIP;
        $take = $request->take ?? Pagination::TAKE;
        return Enterprise::getEnterpriseWithoutActivities($skip, $take);
    }
}
