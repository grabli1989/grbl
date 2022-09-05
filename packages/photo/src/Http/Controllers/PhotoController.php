<?php

namespace Photo\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Photo\Http\Requests\AppendPhotoRequest;
use Photo\Http\Requests\GetPhotoRequest;
use Photo\Media\MediaService;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use User\Models\User;

class PhotoController extends Controller
{
    /**
     * @param  AppendPhotoRequest  $request
     * @return JsonResponse
     */
    public function appendPhoto(AppendPhotoRequest $request, MediaService $mediaService): JsonResponse
    {
        $payload = $request->file('payload');
        $collection = $request->get('collection', 'default');

        /** @var User $user */
        $user = $request->user();

        try {
            $media = $user->addMedia($payload)->toMediaCollection($collection);
        } catch (FileDoesNotExist $e) {
            return response()->json(['status' => 'error', 'code' => $e->getCode(), 'message' => 'File does not exist']);
        } catch (FileIsTooBig $e) {
            return response()->json(['status' => 'error', 'code' => $e->getCode(), 'message' => 'File is too big']);
        } catch (InvalidManipulation $e) {
            return response()->json(['status' => 'error', 'code' => $e->getCode(), 'message' => 'Invalid manipulation']);
        }

        return response()->json([
            'status' => 'success',
            'media' => $mediaService->prepareMedia($media),
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function get(GetPhotoRequest $request, MediaService $mediaService): JsonResponse
    {
        if (! $media = Media::find($request->get('id'))) {
            return response()->json(['status' => 'error', 'message' => 'Media not found']);
        }

        return response()->json([
            'status' => 'success',
            'media' => $mediaService->prepareMedia($media),
        ]);
    }
}
