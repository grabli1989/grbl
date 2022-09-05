<?php

namespace Search\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Realty\Http\Requests\Search\SearchRequest;
use Realty\Interfaces\SearchServiceInterface;
use Search\Exceptions\SearchException;

class SearchController extends Controller
{
    /**
     * @param  SearchRequest  $request
     * @param  SearchServiceInterface  $searchService
     * @return JsonResponse
     */
    public function search(SearchRequest $request, SearchServiceInterface $searchService): JsonResponse
    {
        $string = $request->get('string', '');
        $perPage = $request->get('perPage');

        $result = [];

        try {
            foreach (SearchServiceInterface::SEARCHABLE as $searchable => $class) {
                $searchResult = $searchService->search($string, $searchable, $perPage);
                foreach ($searchResult as $item) {
                    $result[$searchable][$item->id] = $item->searchData();
                }
            }
        } catch (SearchException $e) {
            return response()->json([
                'status' => 'error',
                'code' => SearchException::CODES[$e->getCode()],
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json(['status' => 'success', 'result' => $result]);
    }
}
