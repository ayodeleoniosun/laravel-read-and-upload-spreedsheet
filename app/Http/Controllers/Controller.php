<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Edenlife Meal Recommendation System API V1 Documentation",
     *      description="Edenlife Meal Recommendation System API V1 Documentation",
     *      @OA\Contact(
     *          email="ayodeleoniosun63@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Test Server"
     * )
     *
     *
     * * @OA\SecurityScheme(
     *      securityScheme="bearer_token",
     *      in="header",
     *      type="http",
     *      scheme="bearer",
     * )
     *
     */
}
