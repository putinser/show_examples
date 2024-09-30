<?php

namespace App\Http\Controllers\Api\advert;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiCollection;
use App\Http\Requests\ApiFileSmall;
use App\Http\Requests\ApiSuccessResponse;
use Auth;
use Throwable;

class ExampleController extends Controller
{
    private ExampleService $exampleService;

    /**
     * @param ExampleService $exampleService
     */
    public function __construct(ExampleService $exampleService)
    {
        $this->exampleService = $exampleService;
    }

    public function getSomeCollection($id)
    {
        $someCollection = $this->exampleService->getSomeCollection();

        return new ApiSuccessResponse(new ApiCollection($someCollection, ApiFileSmall::class));
    }
}
