<?php

namespace Realty\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Realty\Commands\Ads\CreateAd;
use Realty\Commands\Ads\UpdateAd;
use Realty\Exceptions\AdException;
use Realty\Http\Requests\Ads\ApproveAdRequest;
use Realty\Http\Requests\Ads\CreateAdRequest;
use Realty\Http\Requests\Ads\DisableAdRequest;
use Realty\Http\Requests\Ads\GetAdRequest;
use Realty\Http\Requests\Ads\RejectAdRequest;
use Realty\Http\Requests\Ads\RemoveAdRequest;
use Realty\Http\Requests\Ads\SelfAdsRequest;
use Realty\Http\Requests\Ads\UpdateAdRequest;
use Realty\Interfaces\ViewsManagerInterface;
use Realty\Models\Ad;
use Realty\Services\Ads\CreateAdService;
use Realty\Services\Ads\UpdateAdService;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use User\Models\User;

class AdsController extends Controller
{
    /**
     * @param  GetAdRequest  $request
     * @param  ViewsManagerInterface  $viewsManager
     * @return JsonResponse
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function ad(
        GetAdRequest $request,
        ViewsManagerInterface $viewsManager,
    ): JsonResponse {
        $ad = Ad::find($request->get('id'));
        $viewsManager->view($ad);

        $data = $ad->toArray();

        return response()->json(['status' => 'success', 'ob' => $data]);
    }

    /**
     * @param SelfAdsRequest $request
     * @return JsonResponse
     */
    public function selfAds(SelfAdsRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $query = Ad::query()->where('user_id', $user->id);

        if (in_array($request->get('status'), Ad::STATUSES)) {
            $query->where('status', $request->get('status'))->whereNull('deleted_at');
        }

        if ($request->get('status') === 'deleted') {
            $query = Ad::onlyTrashed()->where('user_id', $user->id);
        }

        return response()->json(['status' => 'success', 'ads' => $query->get()->map(fn(Ad $ad) => $ad->toArray())]);
    }

    /**
     * @return JsonResponse
     */
    public function approvedAds(): JsonResponse
    {
        $query = Ad::query()->where('status', Ad::STATUSES['APPROVED'])->whereNull('deleted_at');
        return response()->json(['status' => 'success', 'ads' => $query->get()->map(fn(Ad $ad) => $ad->toArray())]);
    }

    /**
     * @param  CreateAdRequest  $request
     * @param  CreateAdService  $service
     * @return JsonResponse
     */
    public function create(CreateAdRequest $request, CreateAdService $service): JsonResponse
    {
        [$caption, $description, $city, $images, $coordinates, $categoryId, $price, $user, $properties]
            = $this->getAdDataFromRequest($request);
        $command = new CreateAd($caption, $description, $city, $images, $coordinates, $categoryId, $price, $user, $properties);
        try {
            $service->handle($command);
        } catch (FileDoesNotExist $e) {
            return response()->json(['status' => 'error', 'code' => $e->getCode(), 'message' => 'File does not exist']);
        } catch (FileIsTooBig $e) {
            return response()->json(['status' => 'error', 'code' => $e->getCode(), 'message' => 'File is too big']);
        }

        return response()->json(['status' => 'success', 'message' => 'Ob created successfully'], 201);
    }

    /**
     * @param  UpdateAdRequest  $request
     * @param  UpdateAdService  $service
     * @return JsonResponse
     */
    public function update(UpdateAdRequest $request, UpdateAdService $service): JsonResponse
    {
        [$caption, $description, $city, $images, $coordinates, $categoryId, $price, $user, $properties]
            = $this->getAdDataFromRequest($request);
        $ad = Ad::find($request->get('id'));

        $command = new UpdateAd($caption, $description, $city, $images, $coordinates, $categoryId, $price, $user, $ad, $properties);

        try {
            $service->handle($command);
        } catch (FileDoesNotExist $e) {
            return response()->json(['status' => 'error', 'code' => $e->getCode(), 'message' => 'File does not exist']);
        } catch (FileIsTooBig $e) {
            return response()->json(['status' => 'error', 'code' => $e->getCode(), 'message' => 'File is too big']);
        }

        return response()->json(['status' => 'success', 'message' => 'Ob updated successfully'], 201);
    }

    /**
     * @param  RemoveAdRequest  $request
     * @return JsonResponse
     */
    public function remove(RemoveAdRequest $request): JsonResponse
    {
        $id = $request->get('id');
        $ad = Ad::find($id);
        $ad->delete();

        return response()->json(['status' => 'success', 'message' => 'Deleted successfully'], 201);
    }

    /**
     * @param  ApproveAdRequest  $request
     * @return JsonResponse
     *
     * @throws \Realty\Exceptions\AdException
     */
    public function approve(ApproveAdRequest $request): JsonResponse
    {
        $id = $request->get('id');
        try {
            Ad::find($id)->approve();
        } catch (AdException $e) {
            return response()->json(['status' => 'error', 'code' => AdException::CODES[$e->getCode()], 'message' => $e->getMessage()]);
        }

        return response()->json(['status' => 'success', 'message' => 'Approved successfully'], 201);
    }

    /**
     * @param  DisableAdRequest  $request
     * @return JsonResponse
     *
     * @throws \Realty\Exceptions\AdException
     */
    public function disable(DisableAdRequest $request): JsonResponse
    {
        $id = $request->get('id');
        try {
            Ad::find($id)->disable();
        } catch (AdException $e) {
            return response()->json(['status' => 'error', 'code' => AdException::CODES[$e->getCode()], 'message' => $e->getMessage()]);
        }

        return response()->json(['status' => 'success', 'message' => 'Disabled successfully'], 201);
    }

    /**
     * @param  RejectAdRequest  $request
     * @return JsonResponse
     *
     * @throws \Realty\Exceptions\AdException
     */
    public function reject(RejectAdRequest $request): JsonResponse
    {
        $id = $request->get('id');
        $reason = $request->get('reason');
        try {
            Ad::find($id)->reject($reason);
        } catch (AdException $e) {
            return response()->json(['status' => 'error', 'code' => AdException::CODES[$e->getCode()], 'message' => $e->getMessage()]);
        }

        return response()->json(['status' => 'success', 'message' => 'Rejected successfully'], 201);
    }

    /**
     * @param  Request  $request
     * @return array
     */
    private function getAdDataFromRequest(Request $request): array
    {
        return [
            $request->get('caption'),
            $request->get('description'),
            $request->get('city'),
            $request->file('images'),
            $request->get('coordinates'),
            $request->get('categoryId'),
            $request->get('price'),
            $request->user(),
            $request->get('properties'),
        ];
    }
}
