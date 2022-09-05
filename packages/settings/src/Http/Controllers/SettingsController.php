<?php

namespace Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Settings\Exceptions\SettingsException;
use Settings\Http\Requests\DropSettingRequest;
use Settings\Http\Requests\GetSettingRequest;
use Settings\Http\Requests\PutSettingRequest;
use Settings\Http\Requests\UserAssignSettingRequest;
use Settings\Http\Requests\UserRevokeSettingRequest;
use Settings\Services\SettingsService;
use User\Models\User;

class SettingsController extends Controller
{
    /**
     * @param  GetSettingRequest  $request
     * @param  SettingsService  $service
     * @return JsonResponse
     */
    public function get(GetSettingRequest $request, SettingsService $service): JsonResponse
    {
        $property = $request->get('property');
        if (! $value = $service->get($property)) {
            return response()->json(['status' => 'error', 'code' => SettingsException::CODES[0], 'message' => "Setting where property $property not found"]);
        }
        $data = ['property' => $property, 'value' => $value];

        return response()->json($data);
    }

    /**
     * @param  PutSettingRequest  $request
     * @param  SettingsService  $service
     * @return JsonResponse
     */
    public function put(PutSettingRequest $request, SettingsService $service): JsonResponse
    {
        try {
            $service->put($request->get('property'), $request->get('value'));
        } catch (SettingsException $e) {
            return $this->settingsExceptionResponse($e);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * @param  DropSettingRequest  $request
     * @param  SettingsService  $service
     * @return JsonResponse
     */
    public function drop(DropSettingRequest $request, SettingsService $service): JsonResponse
    {
        try {
            $service->drop($request->get('property'));
        } catch (SettingsException $e) {
            return $this->settingsExceptionResponse($e);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * @param  UserAssignSettingRequest  $request
     * @param  SettingsService  $service
     * @return JsonResponse
     */
    public function userAssignSetting(UserAssignSettingRequest $request, SettingsService $service): JsonResponse
    {
        $user = User::find($request->get('userId'));
        try {
            $service->assignSetting($user, $request->get('property'));
        } catch (SettingsException $e) {
            return $this->settingsExceptionResponse($e);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * @param  UserRevokeSettingRequest  $request
     * @param  SettingsService  $service
     * @return JsonResponse
     */
    public function userRevokeSetting(UserRevokeSettingRequest $request, SettingsService $service): JsonResponse
    {
        $user = User::find($request->get('userId'));
        try {
            $service->revokeSetting($user, $request->get('property'));
        } catch (SettingsException $e) {
            return $this->settingsExceptionResponse($e);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * @param  SettingsException|\Exception  $e
     * @return JsonResponse
     */
    private function settingsExceptionResponse(SettingsException|\Exception $e): JsonResponse
    {
        return response()->json(['status' => 'error', 'code' => SettingsException::CODES[$e->getCode()], 'message' => $e->getMessage()]);
    }
}
