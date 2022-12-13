<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use App\Models\Industry;
use Artisan;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndustryController extends ApiController
{

    /**
     * Returns All categories
     * @param Request $request
     * @return JsonResponse
     */

    public function index(Request $request): JsonResponse
    {
        if ($request->input('page') == '*') {
            return $this->successResponse(Industry::get());
        } else {
            return $this->successResponse(Industry::paginate(10));
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
            'title' => 'required|unique:industries,title',
        ]);
        try {
            $data = $request->all();
//            $data['slug'] = $this->slugify($data['name']);
            Artisan::call('cache:clear');
            $industry = Industry::create($data);
            return $this->successResponse($industry);
        } catch (Exception $exception) {
            $this->errorLog($exception, 'api');

            return $this->failResponse($exception->getMessage());
        }

    }

    public function show(int $id): JsonResponse
    {
        try {
            return $this->successResponse(Industry::find($id));
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
            'title' => 'required',
        ]);

        $data = $request->all();
        $industry = Industry::where('id', $id)->update($data);

        return $this->successResponse($industry);
    }

    /**
     * Deletes Category & Returns boolean
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        Industry::where('id', $id)->delete();

        return $this->successResponse();
    }
}
