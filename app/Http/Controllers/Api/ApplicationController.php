<?php

namespace App\Http\Controllers\Api;

use App\Models\Application;
use Exception;
use File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $allApplications = Application::with('job')->paginate(10);
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

//    private function storeFile($request)
//    {
//        $validatedData = $request->validate(['file' => 'required|csv,txt,xlx,xls,pdf|max:2048',]);
//        $name = $request->file('file')->getClientOriginalName();
//        $path = $request->file('file')->store('public/files');
//        $save = new File;
//        $save->name = $name;
//        $save->path = $path;
//        return $save->path;
//    }

    public function edit($slug): JsonResponse
    {
        try {
            $article = Image::where('id', $slug)
                ->with(['gallery'])->first();

            return $this->successResponse($article);
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
        $albumInfo = $this->albumRepository->update($request, $id);
        \Artisan::call('cache:clear');

        return $this->successResponse($albumInfo['album']);
    }

    /**
     * Deletes Category & Returns boolean
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->albumRepository->delete($id);
        \Artisan::call('cache:clear');

        return $this->successResponse();
    }

    /**
     * @param $article
     */
    private function sendNotification($article): void
    {
        \Artisan::call('cache:clear');

        $data = [
            "article_id" => $article->id,
            "title" => $article->title,
            "body" => $article->excerpt,
            "image" => $article->image
        ];

        \Artisan::call("send:notification", [
            'notificationData' => $data
        ]);
    }
}
