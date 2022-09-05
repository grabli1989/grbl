<?php

                            // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! //
                            // THIS ROUTES WORKS ONLY IF USING LOCAL ENVIRONMENT //
                            // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! //

use Carbon\Carbon;

Route::middleware('auth:sanctum')
    ->match(['post', 'option'], '/code', function (Illuminate\Http\Request $request) {
        return $request->user()->getCode();
    })->withoutMiddleware(['userIsConfirmed']);

Route::match(['post', 'option'], '/force-confirmation', function (Illuminate\Http\Request $request) {
    $user = $request->user();
    $user->is_confirmed = true;
    $user->phone_verified_at = Carbon::now();
    $user->save();

    $temp = [
        'accessToken' => $user->createToken('auth_token', ['assertIsConfirmed'])->plainTextToken,
        'tokenType' => 'Bearer',
    ];

    return response()->json(array_merge(['status' => 'success', 'message' => 'User phone confirmation successfully'], $temp));
})
    ->name('confirmation')->withoutMiddleware(['userIsConfirmed']);
