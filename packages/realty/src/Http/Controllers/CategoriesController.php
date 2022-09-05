<?php

namespace Realty\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\ArrayShape;
use Realty\Commands\Categories\CreateCategory;
use Realty\Commands\Categories\UpdateCategory;
use Realty\Exceptions\CategoryException;
use Realty\Http\Requests\Categories\CreateCategoryRequest;
use Realty\Http\Requests\Categories\GetCategoryRequest;
use Realty\Http\Requests\Categories\RemoveCategoryRequest;
use Realty\Http\Requests\Categories\UpdateCategoryRequest;
use Realty\Interfaces\MediaServiceInterface;
use Realty\Models\Category;
use Realty\Services\Categories\CreateCategoryService;
use Realty\Services\Categories\UpdateCategoryService;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class CategoriesController extends Controller
{
    /**
     * @param  MediaServiceInterface  $mediaService
     * @return JsonResponse
     */
    public function all(MediaServiceInterface $mediaService): JsonResponse
    {
        $data = [];

        /** @var Category[] $categories */
        $categories = Category::all();

        foreach ($categories as $category) {
            $data[] = $this->getCategoryData($category, $mediaService);
        }

        return response()->json(['status' => 'success', 'category' => $data]);
    }

    /**
     * @param  GetCategoryRequest  $request
     * @param  MediaServiceInterface  $mediaService
     * @return JsonResponse
     */
    public function category(GetCategoryRequest $request, MediaServiceInterface $mediaService): JsonResponse
    {
        /** @var Category $category */
        if (! $category = Category::find($request->get('id'))) {
            return response()->json([
                'status' => 'error',
                'code' => CategoryException::CODES[0],
                'message' => 'Category not found',
            ]);
        }

        $data = $this->getCategoryData($category, $mediaService);

        return response()->json(['status' => 'success', 'category' => $data]);
    }

    /**
     * @param  CreateCategoryRequest  $request
     * @param  CreateCategoryService  $service
     * @return JsonResponse
     */
    public function create(CreateCategoryRequest $request, CreateCategoryService $service): JsonResponse
    {
        $name = $request->get('name');
        $mediaId = $request->get('mediaId');
        $position = $request->get('position');

        $command = new CreateCategory($name, $mediaId, $position);

        try {
            $service->handle($command);
        } catch (FileCannotBeAdded $e) {
            return response()->json([
                'status' => 'error',
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Category create successfully']);
    }

    /**
     * @param  UpdateCategoryRequest  $request
     * @param  UpdateCategoryService  $service
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, UpdateCategoryService $service): JsonResponse
    {
        $id = $request->get('id');
        $name = $request->get('name');
        $mediaId = $request->get('mediaId');
        $position = $request->get('position');

        $command = new UpdateCategory($id, $name, $mediaId, $position);

        try {
            $service->handle($command);
        } catch (FileCannotBeAdded $e) {
            return response()->json([
                'status' => 'error',
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Category update successfully']);
    }

    /**
     * @param  RemoveCategoryRequest  $request
     * @return JsonResponse
     */
    public function remove(RemoveCategoryRequest $request): JsonResponse
    {
        Category::find($request->id)->delete();

        return response()->json(['status' => 'success']);
    }

    /**
     * @param  Category  $category
     * @param  MediaServiceInterface  $mediaService
     * @return array
     */
    #[ArrayShape(['name' => 'string', 'position' => 'int', 'translations' => 'array', 'media' => 'array'])]
    private function getCategoryData(Category $category, MediaServiceInterface $mediaService): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'position' => $category->position,
            'translations' => $category->getTranslationsArray(),
            'media' => $mediaService->prepareMedias($category->getMedia('categories')),
        ];
    }
}
