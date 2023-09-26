<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use App\Models\News;
use App\Repositories\Page\PageRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class BannerController extends ApiController
{
    public $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function index(Request $request): JsonResponse
    {
        return Banner::latest()
            ->when(request()->has('is_published'), function ($q) {
                $q->where('published', (bool)request('is_published'));
            })
            ->when(\request()->has('search'), function ($q) {
                $q->where('title', 'LIKE', '%' . \request('search') . '%');
            })
            ->paginate(10);
    }

    public function store(Request $request): JsonResponse
    {

    }

    public function edit($slug): JsonResponse
    {
        try {
            $news = News::where('id', $slug)->firstOrFail();

            return $this->successResponse($news);
        } catch (Exception $exception) {
            $this->errorLog($exception, 'api');

            return $this->failResponse($exception->getMessage());
        }
    }

    public function update(Request $request, $id): JsonResponse
    {

        $category = $this->pageRepository->updateNews($request, $id);
        \Artisan::call('cache:clear');

        return $this->successResponse($category);
    }


    public function destroy($id)
    {
        $news = News::findOrFail($id);

        return $news->delete();
    }

    public function get(News $news): JsonResponse
    {
        $news = $this->pageRepository->allNews(['id', 'title']);
        $newsIds = News::where('published',1)->pluck('id');

        return $this->successResponse(['news' => $news, 'newsIds' => $newsIds]);
    }
    public function saveNewsStatus(Request $request): JsonResponse
    {

        foreach ($request->ids as $id) {
            News::where('id', $id)->update(['published' => 1]);
        }

        return $this->successResponse();
    }

    public function deleteNews($id): JsonResponse
    {

        News::where('id', $id)->update(['published' => 0]);

        return $this->successResponse();
    }
}
