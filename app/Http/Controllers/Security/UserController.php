<?php

namespace App\Http\Controllers\Security;

use App\Config\Pagination;
use App\Helpers\JsonResponseHelper;
use App\Models\User;
use App\Notifications\ChangeRoleNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getAllUsers(Request $request)
    {
        $skip = $request->skip ?? Pagination::SKIP;
        $take = $request->take ?? Pagination::TAKE;
        return User::getAllUsers($request, $skip, $take);
    }

    public function changeRole($user_id, $action)
    {
        DB::beginTransaction();
        try {
            $userSession = Auth::guard('api')->user();
            if ($userSession->permissions->pluck('name')->count() > 0 && in_array('user.changeRole', $userSession->permissions->pluck('name')->toArray())) {
                if ($action === 'accepted') {
                    $user = User::where('id', decrypt($user_id))->where('rejected_change_role', null)->first();
                    if (!$user) return JsonResponseHelper::unauthorized('This user has been rejected in past, please contact the support team');
                    $user->removeRole('normal');
                    $user->assignRole('administrator');
                    User::where('id', decrypt($user_id))->update(['role_id' => '1', 'rejected_change_role' => false]);
                }

                if ($action === 'rejected') {
                    $user = User::where('id', decrypt($user_id))->first();
                    User::where('id', decrypt($user_id))->update(['rejected_change_role' => true]);
                }

                $user->notify(new ChangeRoleNotification(null, $action));
                DB::commit();
                return JsonResponseHelper::success('User role changed successfully');
            }
            return JsonResponseHelper::forbidden('You do not have permission to change role');
        } catch (\Throwable $th) {
            DB::rollBack();
            return JsonResponseHelper::error('Something went wrong', $th->__toString());
        }

    }

    public static function getEnterpriseUsers(Request $request){
        $skip = $request->skip ?? Pagination::SKIP;
        $take = $request->take ?? Pagination::TAKE;
        return User::getEnterpriseUsers($request, $skip, $take);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
