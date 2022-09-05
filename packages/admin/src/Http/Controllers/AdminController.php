<?php

namespace Admin\Http\Controllers;

use Admin\Http\Requests\AdsAllRequest;
use Admin\Http\Requests\UpdateUserRequest;
use Admin\Http\Requests\UserGetRequest;
use Admin\Http\Requests\UsersAllRequest;
use Admin\Services\UpdateUserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Realty\Models\Ad;
use User\Models\User;
use User\Resources\User\UserResource;

class AdminController extends Controller
{
    /**
     * @param UsersAllRequest $request
     * @param UserResource $userResource
     * @return JsonResponse
     */
    public function usersAll(UsersAllRequest $request, UserResource $userResource): JsonResponse
    {
        $usersData = User::hasUsersRoles()->orWhereDoesntHave('roles')->get()
            ->map(function (User $user) use ($userResource) {
                return $userResource->array($user);
            });

        return response()->json(['status' => 'success', 'data' => $usersData]);
    }

    /**
     * @param UserGetRequest $request
     * @param UserResource $userResource
     * @return JsonResponse
     */
    public function userGet(UserGetRequest $request, UserResource $userResource): JsonResponse
    {
        $user = User::findOrFail($request->getCommand()->id);

        return response()->json(['status' => 'success', 'data' => $userResource->array($user)]);
    }

    /**
     * @param UpdateUserRequest $request
     * @param UpdateUserService $service
     * @return JsonResponse
     */
    public function updateUser(UpdateUserRequest $request, UpdateUserService $service): JsonResponse
    {
        $service->handle($request->getCommand());

        return response()->json(['status' => 'success', 'message' => 'successfully update']);
    }

    /**
     * @param AdsAllRequest $request
     * @return JsonResponse
     */
    public function adsAll(AdsAllRequest $request): JsonResponse
    {
        $query = Ad::query();

        if (in_array($request->get('status'), Ad::STATUSES)) {
            $query->where('status', $request->get('status'))->whereNull('deleted_at');
        }

        if ($request->get('status') === 'deleted') {
            $query = Ad::onlyTrashed();
        }

        return response()->json(['status' => 'success', 'ads' => $query->get()->map(fn(Ad $ad) => $ad->toArray())]);
    }
}
