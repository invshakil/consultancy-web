<?php

namespace App\Http\Controllers\Api;

use App\Models\Application;
use Exception;
use File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Throwable;

class ApplicationController extends ApiController
{

    /**
     * Returns All categories
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $allApplications = Application::with('job')
            ->when(\request()->has('search'), function ($q) {
                $q->where('name', 'LIKE', '%' . \request('search') . '%');
            })
            ->when(request()->has('is_published'), function ($q) {
                $q->where('is_published', (bool)request('is_published'));
            })
            ->paginate(10);
        return $this->successResponse($allApplications);
    }

    /**
     * Creates Category & Returns created category
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(Request $request): JsonResponse
    {
        \DB::beginTransaction();
        $file=$this->storeFile($request);
        $data= [
            'name' => $request->input('name'),
            'phone' =>  $request->input('phone'),
            'email' => $request->input('email'),
            'job_id' => $request->input('jobID'),
            'whatsapp' => $request->input('whatsapp'),
            'source' => $request->input('source'),
            'exp_in' => $request->input('exp_in'),
            'exp_out' => $request->input('exp_out'),
            'passport' => $request->input('passport'),
            'cv' => $file,
        ];
        try {
            $application = Application::create($data);
            \DB::commit();
            return $this->successResponse($application);

        } catch (Throwable $throwable) {
            \DB::rollBack();
            $this->errorLog($throwable, 'api');

            return $this->failResponse($throwable->getMessage());
        }

    }

    /**
     * Updates Category & Returns updated category
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id): JsonResponse
    {
        $application=Application::find($id);
        if($application['is_published']===0){
            $data=['is_published'=>1];
        }
        else{
            $data=['is_published'=>0];
        }
        $applicationInfo = $application->update($data);
        \Artisan::call('cache:clear');

        return $this->successResponse($applicationInfo);
    }

    public function lastDay(): JsonResponse
    {
        $application=Application::where('created_at', '>', Carbon::now()->subDays(1))
            ->get();

        return $this->successResponse($application);
    }

}
