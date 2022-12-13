<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\Job;
use App\Models\Visitor;
use App\Repositories\Article\ArticleRepository;
use App\Repositories\Job\JobRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JobController extends ApiController
{
    public $jobRepository;

    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    /**
     * Returns All categories
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */

    public function index(Request $request)
    {

        $allArticles = $this->successResponse($this->jobRepository->paginate(10));
        $response = [
            'all' => $allArticles,
        ];

        return response($response, 201);
    }

    /**
     * Creates Category & Returns created category
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|unique:jobs,title',
        ]);

        \DB::beginTransaction();

        try {
            $job = $this->jobRepository->save($request);

            // While creating new article, if it is directly published, then send notification
            if ($job->published) {
                $this->sendNotification($job);
            }

            \DB::commit();

            return $this->successResponse($job);

        } catch (\Throwable $throwable) {
            \DB::rollBack();
            $this->errorLog($throwable, 'api');

            return $this->failResponse($throwable->getMessage());
        }

    }

    public function edit($slug): JsonResponse
    {
        try {
            $article = Job::where('slug', $slug)
                ->with('country')->first();

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
        $request->validate([
            'title' => 'required'
        ]);

        $articleInfo = $this->jobRepository->update($request, $id);

        // if the article is not published before send notification
        if (!$articleInfo['previouslyPublished']) {
            $this->sendNotification($articleInfo['article']);
        }

        \Artisan::call('cache:clear');

        return $this->successResponse($articleInfo['article']);
    }

    /**
     * Deletes Category & Returns boolean
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->jobRepository->delete($id);
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
