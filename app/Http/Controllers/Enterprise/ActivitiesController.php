<?php

namespace App\Http\Controllers\Enterprise;

use App\Config\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Enterprise\Activity;
use App\Helpers\JsonResponseHelper;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Enterprise\Enterprise;
use App\Models\Enterprise\EnterpriseActivity;
use App\Http\Requests\Enterprise\CreateActivityRequest;
use App\Http\Requests\Enterprise\CreateEnterpriseActivityRequest;

class ActivitiesController extends Controller
{
    public function getAllActivities(Request $request)
    {
        $skip = $request->skip ?? Pagination::SKIP;
        $take = $request->take ?? Pagination::TAKE;
        return Activity::getAllActivities($request, $skip, $take);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeActivity(CreateActivityRequest $request)
    {
        DB::beginTransaction();
        try {
            Activity::create($request->all());
            DB::commit();
            return JsonResponseHelper::resourceCreated('Activity created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return JsonResponseHelper::error('Something went wrong', $th->getMessage());
        }
    }

    public function getAllEnterpriseActivities(Request $request)
    {
        $skip = $request->skip ?? Pagination::SKIP;
        $take = $request->take ?? Pagination::TAKE;
        return EnterpriseActivity::getAllEnterpriseActivities($request, $skip, $take);
    }

    public function storeEnterpriseWithActivity(CreateEnterpriseActivityRequest $request)
    {
        $userSession = Auth::guard('api')->user();
        $enterpriseUser = Enterprise::where('user_id', $userSession->id)->where('id', $request->enterprise_id)->first();
        // Si eres usuario administrador, debe tener el permiso de asociar actividades
        // Si eres usuario de la empresa, debes asociar actividades
        if ($userSession->can('enterprise.asociateActivity') || !is_null($enterpriseUser)) {
            DB::beginTransaction();
            try {
                $message = gettype($request->activity_id) === 'array' ? 'Activities asociated with enterprise successfully' : 'Activity asociated with enterprise successfully';

                if (gettype($request->activity_id) === 'array') {
                    foreach ($request->activity_id as $activity) {
                        $exists = EnterpriseActivity::enterpriseActivityExists($request->enterprise_id, $activity);
                        if (!$exists) {
                            EnterpriseActivity::create(['enterprise_id' => $request->enterprise_id, 'activity_id' => $activity]);
                        }
                    }
                }

                if (gettype($request->activity_id) === 'integer') {
                    $exists = EnterpriseActivity::enterpriseActivityExists($request->enterprise_id, $request->activity_id);
                    if ($exists) return JsonResponseHelper::error('This activity is already related with this enterprise');
                    EnterpriseActivity::create(['enterprise_id' => $request->enterprise_id, 'activity_id' => $request->activity_id]);
                }

                DB::commit();
                return JsonResponseHelper::success($message);
            } catch (\Throwable $th) {
                DB::rollBack();
                return JsonResponseHelper::error('Something went wrong', $th->getMessage());
            }
        }

        return JsonResponseHelper::forbidden('You do not have permission to associate activities for permission or you are not the user of this enterprise');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function disasociateEnterpriseActivity(Request $request)
    {
        $userSession = Auth::guard('api')->user();
        $enterpriseUser = Enterprise::where('user_id', $userSession->id)->where('id', $request->enterprise_id)->first();
        // Si eres usuario administrador, debe tener el permiso de desasociar actividades
        // Si eres usuario de la empresa, puedes desasociar actividades
        if ($userSession->can('enterprise.asociateActivity') || !is_null($enterpriseUser)) {
            DB::beginTransaction();
            try {
                $message = gettype($request->activity_id) === 'array' ? 'Activities relationed with enterprise disasociated successfully' : 'Activity relationed with enterprise diasociated successfully';

                if (gettype($request->activity_id) === 'array') {
                    foreach ($request->activity_id as $activity) {
                        EnterpriseActivity::where('enterprise_id', $request->enterprise_id)->where('activity_id', $activity)->delete();
                    }
                }

                if (gettype($request->activity_id) === 'integer') {
                    $exists = EnterpriseActivity::where('enterprise_id', $request->enterprise_id)->where('activity_id', $request->activity_id)->first();
                    if (is_null($exists)) return JsonResponseHelper::error('This activity is not related with this enterprise');
                    $exists->delete();
                }

                DB::commit();
                return JsonResponseHelper::success($message);
            } catch (\Throwable $th) {
                DB::rollBack();
                return JsonResponseHelper::error('Something went wrong', $th->getMessage());
            }
        }
        return JsonResponseHelper::forbidden('You do not have permission to disassociate activities for permission or you are not the user of this enterprise');
    }
}
