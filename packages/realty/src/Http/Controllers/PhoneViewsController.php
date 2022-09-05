<?php

namespace Realty\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Maize\Markable\Exceptions\InvalidMarkValueException;
use Realty\Http\Requests\PhoneViews\AddToPhoneViewsRequest;
use Realty\Http\Requests\PhoneViews\CountPhoneViewsRequest;
use Realty\Http\Requests\PhoneViews\HasPhoneViewRequest;
use Realty\Http\Requests\PhoneViews\RemoveFromPhoneViewsRequest;
use Realty\Http\Requests\PhoneViews\TogglePhoneViewRequest;
use Realty\Interfaces\PhoneViewsServiceInterface;
use Realty\Models\Ad;

class PhoneViewsController extends Controller
{
    /**
     * @param  AddToPhoneViewsRequest  $request
     * @param  PhoneViewsServiceInterface  $phoneViewsService
     * @return JsonResponse
     */
    public function add(AddToPhoneViewsRequest $request, PhoneViewsServiceInterface $phoneViewsService): JsonResponse
    {
        $ad = Ad::find($request->get('id'));
        try {
            $phoneViewsService->add($ad);
        } catch (InvalidMarkValueException $e) {
            return response()->json(['status' => 'error', 'message' => 'invalid mark value']);
        }

        return $this->successResponse('Ob added to phone views', ['phone' => $ad->user->phone], 201);
    }

    /**
     * @param  RemoveFromPhoneViewsRequest  $request
     * @param  PhoneViewsServiceInterface  $phoneViewsService
     * @return JsonResponse
     */
    public function remove(RemoveFromPhoneViewsRequest $request, PhoneViewsServiceInterface $phoneViewsService): JsonResponse
    {
        $ad = Ad::find($request->get('id'));
        $phoneViewsService->remove($ad);

        return $this->successResponse('Ob removed from phone views', [], 201);
    }

    /**
     * @param  TogglePhoneViewRequest  $request
     * @param  PhoneViewsServiceInterface  $phoneViewsService
     * @return JsonResponse
     */
    public function toggle(TogglePhoneViewRequest $request, PhoneViewsServiceInterface $phoneViewsService): JsonResponse
    {
        $ad = Ad::find($request->get('id'));
        $phoneViewsService->toggle($ad);

        return $this->successResponse('User toggled phone view', [], 201);
    }

    /**
     * @param  HasPhoneViewRequest  $request
     * @param  PhoneViewsServiceInterface  $phoneViewsService
     * @return JsonResponse
     */
    public function has(HasPhoneViewRequest $request, PhoneViewsServiceInterface $phoneViewsService): JsonResponse
    {
        $ad = Ad::find($request->get('id'));
        $result = $phoneViewsService->has($ad);

        return $this->successResponse('I have something for you', ['has' => $result]);
    }

    /**
     * @param  CountPhoneViewsRequest  $request
     * @param  PhoneViewsServiceInterface  $phoneViewsService
     * @return JsonResponse
     */
    public function count(CountPhoneViewsRequest $request, PhoneViewsServiceInterface $phoneViewsService): JsonResponse
    {
        $ad = Ad::find($request->get('id'));
        $result = $phoneViewsService->count($ad);

        return $this->successResponse('I have something for you', ['count' => $result]);
    }

    /**
     * @param  string  $message
     * @param  array  $result
     * @param  int  $status
     * @return JsonResponse
     */
    private function successResponse(string $message, array $result = [], int $status = 200): JsonResponse
    {
        return response()->json(array_merge(['status' => 'success', 'message' => $message], $result), $status);
    }
}
