<?php

namespace Realty\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Realty\Http\Requests\Properties\CreatePropertyRequest;
use Realty\Http\Requests\Properties\CreateQuestionRequest;
use Realty\Http\Requests\Properties\CreateSetRequest;
use Realty\Http\Requests\Properties\DropPropertyRequest;
use Realty\Http\Requests\Properties\DropQuestionRequest;
use Realty\Http\Requests\Properties\DropSetRequest;
use Realty\Http\Requests\Properties\PickUpQuestionsRequest;
use Realty\Http\Requests\Properties\UpdatePropertyRequest;
use Realty\Http\Requests\Properties\UpdateQuestionRequest;
use Realty\Http\Requests\Properties\UpdateSetRequest;
use Realty\Http\Resources\PropertyResource;
use Realty\Http\Resources\PropertySetResource;
use Realty\Http\Resources\QuestionResource;
use Realty\Models\Property;
use Realty\Models\PropertySet;
use Realty\Models\Question;
use Realty\Services\Properties\CreatePropertyService;
use Realty\Services\Properties\CreateQuestionService;
use Realty\Services\Properties\CreateSetService;
use Realty\Services\Properties\DropPropertyService;
use Realty\Services\Properties\DropQuestionService;
use Realty\Services\Properties\DropSetService;
use Realty\Services\Properties\UpdatePropertyService;
use Realty\Services\Properties\UpdateQuestionService;
use Realty\Services\Properties\UpdateSetService;

class PropertiesController extends Controller
{
    /**
     * @param  PickUpQuestionsRequest  $request
     * @return JsonResponse
     */
    public function pickUp(PickUpQuestionsRequest $request): JsonResponse
    {
        $questions = Question::whereNull('relate_property_id')
            ->orWhereIn('relate_property_id', $request->getCommand()->properties);

        return response()->json(['status' => 'success', 'questions' => QuestionResource::collection($questions->get())]);
    }

    /**
     * @return JsonResponse
     */
    public function sets(): JsonResponse
    {
        return response()->json(['status' => 'success', 'sets' => PropertySetResource::collection(PropertySet::all())]);
    }

    /**
     * @param  CreateSetRequest  $request
     * @param  CreateSetService  $service
     * @return JsonResponse
     */
    public function createSet(CreateSetRequest $request, CreateSetService $service): JsonResponse
    {
        $service->handle($request->getCommand());

        return response()->json(['status' => 'success', 'message' => 'Property set successfully created'], 201);
    }

    /**
     * @param  UpdateSetRequest  $request
     * @param  UpdateSetService  $service
     * @return JsonResponse
     */
    public function updateSet(UpdateSetRequest $request, UpdateSetService $service): JsonResponse
    {
        $service->handle($request->getCommand());

        return response()->json(['status' => 'success', 'message' => 'Property set successfully updated'], 201);
    }

    /**
     * @param  DropSetRequest  $request
     * @param  DropSetService  $service
     * @return JsonResponse
     */
    public function dropSet(DropSetRequest $request, DropSetService $service): JsonResponse
    {
        $service->handle($request->getCommand());

        return response()->json(['status' => 'success', 'message' => 'Property set successfully deleted'], 201);
    }

    /**
     * @return JsonResponse
     */
    public function questions(): JsonResponse
    {
        return response()->json(['status' => 'success', 'questions' => QuestionResource::collection(Question::all())]);
    }

    /**
     * @param  CreateQuestionRequest  $request
     * @param  CreateQuestionService  $service
     * @return JsonResponse
     */
    public function createQuestion(CreateQuestionRequest $request, CreateQuestionService $service): JsonResponse
    {
        $service->handle($request->getCommand());

        return response()->json(['status' => 'success', 'message' => 'Question successfully created'], 201);
    }

    /**
     * @param  UpdateQuestionRequest  $request
     * @param  UpdateQuestionService  $service
     * @return JsonResponse
     */
    public function updateQuestion(UpdateQuestionRequest $request, UpdateQuestionService $service): JsonResponse
    {
        $service->handle($request->getCommand());

        return response()->json(['status' => 'success', 'message' => 'Question successfully updated'], 201);
    }

    /**
     * @param  DropQuestionRequest  $request
     * @param  DropQuestionService  $service
     * @return JsonResponse
     */
    public function dropQuestion(DropQuestionRequest $request, DropQuestionService $service): JsonResponse
    {
        $service->handle($request->getCommand());

        return response()->json(['status' => 'success', 'message' => 'Question successfully deleted'], 201);
    }

    /**
     * @return JsonResponse
     */
    public function properties(): JsonResponse
    {
        return response()->json(['status' => 'success', 'properties' => PropertyResource::collection(Property::all())]);
    }

    /**
     * @param  CreatePropertyRequest  $request
     * @param  CreatePropertyService  $service
     * @return JsonResponse
     */
    public function createProperty(CreatePropertyRequest $request, CreatePropertyService $service): JsonResponse
    {
        $service->handle($request->getCommand());

        return response()->json(['status' => 'success', 'message' => 'Property successfully created'], 201);
    }

    /**
     * @param  UpdatePropertyRequest  $request
     * @param  UpdatePropertyService  $service
     * @return JsonResponse
     */
    public function updateProperty(UpdatePropertyRequest $request, UpdatePropertyService $service): JsonResponse
    {
        $service->handle($request->getCommand());

        return response()->json(['status' => 'success', 'message' => 'Property successfully updated'], 201);
    }

    /**
     * @param  DropPropertyRequest  $request
     * @param  DropPropertyService  $service
     * @return JsonResponse
     */
    public function dropProperty(DropPropertyRequest $request, DropPropertyService $service): JsonResponse
    {
        $service->handle($request->getCommand());

        return response()->json(['status' => 'success', 'message' => 'Property successfully deleted'], 201);
    }

    /**
     * @return JsonResponse
     */
    public function questionTypes(): JsonResponse
    {
        return response()->json(['status' => 'success', 'types' => Question::TYPES]);
    }
}
