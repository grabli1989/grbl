<?php

namespace Realty\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Maize\Markable\Exceptions\InvalidMarkValueException;
use Realty\Http\Requests\Favorites\AddToFavoritesRequest;
use Realty\Http\Requests\Favorites\CountFavoritesRequest;
use Realty\Http\Requests\Favorites\HasFavoriteRequest;
use Realty\Http\Requests\Favorites\RemoveFromFavoritesRequest;
use Realty\Http\Requests\Favorites\ToggleFavoriteRequest;
use Realty\Interfaces\FavoriteServiceInterface;
use Realty\Models\Ad;

class FavoritesController extends Controller
{
    /**
     * @param  AddToFavoritesRequest  $request
     * @param  FavoriteServiceInterface  $favoriteService
     * @return JsonResponse
     */
    public function add(AddToFavoritesRequest $request, FavoriteServiceInterface $favoriteService): JsonResponse
    {
        $ad = Ad::find($request->get('id'));
        try {
            $favoriteService->add($ad);
        } catch (InvalidMarkValueException $e) {
            return response()->json(['status' => 'error', 'message' => 'invalid mark value']);
        }

        return $this->successResponse('Ob added to favorites', [], 201);
    }

    /**
     * @param  RemoveFromFavoritesRequest  $request
     * @param  FavoriteServiceInterface  $favoriteService
     * @return JsonResponse
     */
    public function remove(RemoveFromFavoritesRequest $request, FavoriteServiceInterface $favoriteService): JsonResponse
    {
        $ad = Ad::find($request->get('id'));
        $favoriteService->remove($ad);

        return $this->successResponse('Ob removed from favorites', [], 201);
    }

    /**
     * @param  ToggleFavoriteRequest  $request
     * @param  FavoriteServiceInterface  $favoriteService
     * @return JsonResponse
     */
    public function toggle(ToggleFavoriteRequest $request, FavoriteServiceInterface $favoriteService): JsonResponse
    {
        $ad = Ad::find($request->get('id'));
        $favoriteService->toggle($ad);

        return $this->successResponse('User toggled favorites', [], 201);
    }

    /**
     * @param  HasFavoriteRequest  $request
     * @param  FavoriteServiceInterface  $favoriteService
     * @return JsonResponse
     */
    public function has(HasFavoriteRequest $request, FavoriteServiceInterface $favoriteService): JsonResponse
    {
        $ad = Ad::find($request->get('id'));
        $result = $favoriteService->has($ad);

        return $this->successResponse('I have something for you', ['has' => $result]);
    }

    /**
     * @param  CountFavoritesRequest  $request
     * @param  FavoriteServiceInterface  $favoriteService
     * @return JsonResponse
     */
    public function count(CountFavoritesRequest $request, FavoriteServiceInterface $favoriteService): JsonResponse
    {
        $ad = Ad::find($request->get('id'));
        $result = $favoriteService->count($ad);

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
