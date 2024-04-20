<?php

namespace App\Http\Controllers\Enterprise;

use App\Config\Pagination;
use App\Helpers\JsonResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Enterprise\CreateEnterpriseRequest;
use App\Models\Enterprise\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            return JsonResponseHelper::success('Enterprise created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return JsonResponseHelper::error('Something went wrong', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getEnterpriseWithoutActivities(Request $request)
    {
        $skip = $request->skip ?? Pagination::SKIP;
        $take = $request->take ?? Pagination::TAKE;
        return Enterprise::getEnterpriseWithoutActivities($skip, $take);
    }
}
