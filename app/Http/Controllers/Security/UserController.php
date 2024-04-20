<?php

namespace App\Http\Controllers\Security;

use App\Models\User;
use App\Config\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\JsonResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Enterprise\Enterprise;
use App\Notifications\ChangeRoleNotification;
use App\Models\Enterprise\EnterpriseActivity;

class UserController extends Controller
{
    /**
     * Retrieves all users based on the provided request parameters.
     *
     * @param Request $request The request object containing pagination parameters.
     * @return \Illuminate\Database\Eloquent\Collection The collection of all users.
     */
    public function getAllUsers(Request $request)
    {
        $skip = $request->skip ?? Pagination::SKIP;
        $take = $request->take ?? Pagination::TAKE;
        return User::getAllUsers($request, $skip, $take);
    }

    /**
     * Change the role of a user.
     *
     * @param int $user_id The ID of the user.
     * @param string $action The action to perform ('accepted' or 'rejected').
     * @throws \Throwable If an error occurs during the role change process.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the result of the role change.
     */
    public function changeRole($user_id, $action)
    {
        DB::beginTransaction();
        try {
            $userSession = Auth::guard('api')->user();
            if ($userSession->permissions->pluck('name')->count() > 0 && in_array('user.changeRole', $userSession->permissions->pluck('name')->toArray())) {
                if ($action === 'accepted') {
                    $user = User::where('id', decrypt($user_id))->where('rejected_change_role', null)->first();
                    if (!$user)
                        return JsonResponseHelper::unauthorized('This user has been rejected in past, please contact the support team');
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

    /**
     * Retrieves of all users that have an enterprise based on the provided request parameters.
     *
     * @param Request $request The request object containing pagination parameters.
     * @return \Illuminate\Database\Eloquent\Collection The collection of all users that have an enterprise.
     */
    public static function getEnterpriseUsers(Request $request)
    {
        $skip = $request->skip ?? Pagination::SKIP;
        $take = $request->take ?? Pagination::TAKE;
        return User::getEnterpriseUsers($request, $skip, $take);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $userSession = Auth::guard('api')->user();
            $user = User::where('id', $id)->first();
            if ($userSession->getAuthIdentifier() === $user->id)
                return JsonResponseHelper::error('You cannot delete yourself');
            if ($user->hasRole('administrator'))
                return JsonResponseHelper::error('You cannot delete an administrator');
            $enterprise = Enterprise::where('user_id', $id)->first();
            if (!is_null($enterprise)) {
                $enterprise_activities = EnterpriseActivity::where('enterprise_id', $enterprise->id)->count();
                if ($enterprise_activities > 0) {
                    return JsonResponseHelper::error('This user has an enterprise and activities associated, you cannot delete it');
                } else {
                    return JsonResponseHelper::error('This user have an enterprise, you cannot delete it');
                }
            }
            User::destroy($id);
            DB::commit();
            return JsonResponseHelper::success('User deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return JsonResponseHelper::error('Something went wrong', $th->getMessage());
        }
    }

    /**
     * Updates the status of a user.
     *
     * @param string $id The ID of the user.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the success or failure of the update.
     * @throws \Throwable If an error occurs during the update.
     */
    public function updateStatus(string $id)
    {
        DB::beginTransaction();
        try {
            $userSession = Auth::guard('api')->user();
            $user = User::where('id', $id)->first();
            if (is_null($user))
                return JsonResponseHelper::error('This user does not exists');
            if ($userSession->getAuthIdentifier() === $user->id)
                return JsonResponseHelper::error('You cannot change status to yourself');
            User::where('id', $id)->update(['status' => $user->status === true ? false : true]);
            DB::commit();
            return JsonResponseHelper::success('User status updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return JsonResponseHelper::error('Something went wrong', $th->getMessage());
        }
    }

    /**
     * Updates the user data with the given ID.
     *
     * @param Request $request The request object containing the updated user data.
     * @param string $id The ID of the user to be updated.
     * @throws \Throwable If an error occurs during the update process.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the result of the update operation.
     */
    public function update(Request $request, string $id)
    {
        $password = $request->password;
        unset($request['password']);
        $userSession = Auth::guard('api')->user();
        DB::beginTransaction();
        try {
            if (isset($request->email)) {
                if (User::where('email', $request->email)->exists() && $userSession->getAuthIdentifier() != $id) {
                    return JsonResponseHelper::error('Email already exists');
                }
            }
            User::where('id', $id)->update($request->all(), ['password' => Hash::make($password)]);
            DB::commit();
            return JsonResponseHelper::success('User data updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return JsonResponseHelper::error('Something went wrong', $th->getMessage());
        }
    }
}
