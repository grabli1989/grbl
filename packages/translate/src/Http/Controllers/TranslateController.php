<?php

namespace Translate\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Translate\Exceptions\TranslateException;
use Translate\Http\Requests\TranslateRequest;
use Translate\TranslateApi\TranslateApi;

class TranslateController extends Controller
{
    /**
     * @param  TranslateRequest  $request
     * @param  TranslateApi  $translateApi
     * @return JsonResponse
     *
     * @throws TranslateException
     */
    public function translate(TranslateRequest $request, TranslateApi $translateApi): JsonResponse
    {
        $source = $request->get('source');
        $target = $request->get('target');
        $text = $request->get('text');

        try {
            $result = $translateApi->translate($source, $target, $text);
        } catch (\ErrorException $e) {
            logger($e);

            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }

        return response()->json(['status' => 'success', 'result' => $result]);
    }
}
