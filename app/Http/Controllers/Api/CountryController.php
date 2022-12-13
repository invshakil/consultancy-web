<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Country;
use App\Repositories\Category\CategoryRepository;
use Artisan;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CountryController extends ApiController
{

    /**
     * Returns All categories
     * @param Request $request
     * @return JsonResponse
     */

    public function index(Request $request): JsonResponse
    {
        if ($request->input('page') == '*') {
            return $this->successResponse(Country::withCount('jobs')->get());
        } else {
            return $this->successResponse( Country::withCount('jobs')->paginate(10));
        }
    }

    /**
     * Creates Category & Returns created category
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|unique:countries,name',
        ]);
        try {
            $data = $request->all();
//            $data['slug'] = $this->slugify($data['name']);
            Artisan::call('cache:clear');
            $country = Country::create($data);
            return $this->successResponse($country);
        } catch (Exception $exception) {
            $this->errorLog($exception, 'api');

            return $this->failResponse($exception->getMessage());
        }

    }

    public function show(int $id): JsonResponse
    {
        try {
            return $this->successResponse(Country::find($id));
        } catch (Exception $exception) {
            $this->errorLog($exception, 'api');

            return $this->failResponse($exception->getMessage());
        }
    }

    /**
     * Updates Category & Returns updated category
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data = $request->all();
        $country = Country::where('id', $id)->update($data);

        return $this->successResponse($country);
    }

    /**
     * Deletes Category & Returns boolean
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        Country::where('id', $id)->delete();

        return $this->successResponse();
    }
}
