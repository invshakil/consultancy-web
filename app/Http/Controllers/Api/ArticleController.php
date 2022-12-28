<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\Visitor;
use App\Repositories\Article\ArticleRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends ApiController
{
    public $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Returns All categories
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|\Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $allArticles = $this->successResponse($this->articleRepository->paginate(10), true);

        $response = [
            'all' => $allArticles,
        ];

        return response($response, 201);
    }

    public function dashboard(){

        $count = $this->successResponse($this->articleRepository->getArticleCount(), true);
        $hitsPerUser = $this->successResponse($this->articleRepository->getUniqueVisitorCount(), true);
        $hits = $this->successResponse($this->articleRepository->getTotalVisitCount(), true);
        $hitsLastDay = $this->successResponse($this->articleRepository->getLastDaysTotalVisitCount(), true);
        $hitsPerUserLastWeek = $this->successResponse($this->articleRepository->getLastWeeksUniqueVisitorCount(), true);
        $getSubsCount = $this->successResponse($this->articleRepository->getSubsCount(), true);
        $getLastWeekSubsCount = $this->successResponse($this->articleRepository->getLastWeekSubsCount(), true);
        $hitsPerDayLastWeek = $this->successResponse($this->articleRepository->getLastWeeksVisitCountByDay(), true);
        $AllCount = $this->successResponse($this->articleRepository->getAllArticleCount(), true);
        $jobCount = $this->successResponse($this->articleRepository->jobsInfo(), true);
        $jobCountLastWeek = $this->successResponse($this->articleRepository->getJobCount(), true);
        $applicationCount = $this->successResponse($this->articleRepository->applicationInfo(), true);
        $applicationCountLastWeek = $this->successResponse($this->articleRepository->getApplicationCount(), true);

        $response = [
            'countInLastDay' => $count,
            'allArticleCount' => $AllCount,
            'allTimeUniqueVisitors' => $hitsPerUser,
            'LastWeeksUniqueVisitors' => $hitsPerUserLastWeek,
            'totalVisits' => $hits,
            'totalVisitsLastDay' => $hitsLastDay,
            'getSubsCount' => $getSubsCount,
            'getLastWeekSubsCount' => $getLastWeekSubsCount,
            'hitsPerDayLastWeek' => $hitsPerDayLastWeek,
            'jobCount'=>$jobCount,
            'jobCountLastWeek'=>$jobCountLastWeek,
            'applicationCount'=>$applicationCount,
            'applicationCountLastWeek'=>$applicationCountLastWeek,
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
            'title' => 'required|unique:articles,title',
        ]);

        \DB::beginTransaction();

        try {
            $article = $this->articleRepository->save($request);

            // While creating new article, if it is directly published, then send notification
            if ($article->published) {
                $this->sendNotification($article);
            }

            \DB::commit();

            return $this->successResponse($article);

        } catch (\Throwable $throwable) {
            \DB::rollBack();
            $this->errorLog($throwable, 'api');

            return $this->failResponse($throwable->getMessage());
        }

    }

    public function edit($slug): JsonResponse
    {
        try {
            $article = Article::where('slug', $slug)
                ->with(['categories', 'keywords'])->first();

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

        $articleInfo = $this->articleRepository->update($request, $id);

        // if the article is not published before send notification
        if (!$articleInfo['previouslyPublished']) {
            $this->sendNotification($articleInfo['article']);
        }

        \Artisan::call('cache:clear');

        return $this->successResponse($articleInfo['article']);
    }

    /**
     * Updates Category & Returns updated category
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function translate(Request $request, int $id): JsonResponse
    {
        $articleInfo = $this->articleRepository->translate($request, $id);

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
        $this->articleRepository->delete($id);
        \Artisan::call('cache:clear');

        return $this->successResponse();
    }

    public function mostRead(): JsonResponse
    {
        $articles = $this->articleRepository->mostReadArticles(1, 5);

        return $this->successResponse($articles);
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
