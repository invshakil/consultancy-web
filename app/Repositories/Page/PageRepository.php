<?php


namespace App\Repositories\Page;

use App\Models\Article;
use App\Models\Keyword;
use App\Models\News;
use App\Models\Page;
use Illuminate\Http\Request;

class PageRepository implements PageInterface
{
    private $model;

    public function __construct(Page $page)
    {
        $this->model = $page;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function save(Request $request)
    {

        $page = $this->model->create([
            'user_id' => auth()->user()->id,
            'title' => $request->input('title'),
            'slug' => $this->slugify($request->input('title')),
            'excerpt' => $request->input('excerpt'),
            'description' => saveTextEditorImage($request->input('description'),$request->input('title')),
            'published' => filter_var($request->input('published'), FILTER_VALIDATE_BOOLEAN),
        ]);

        // Keywords
        $newKeywords = explode(',', $request->input('keywords'));
        $keywordIds = [];

        foreach ($newKeywords as $keyword) {
            $keyword = Keyword::firstOrCreate(['title' => $keyword]);
            $keywordIds[] = $keyword->id;
        }

        $page->keywords()->sync($keywordIds);


        return $page;
    }    /**
     * @param $request
     * @return mixed
     */

    public function saveNews(Request $request)
    {

        return News::create([
            "title" => $request->input('title'),
            "description" => $request->input('description'),
            'published' => filter_var($request->input('published'), FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    private function slugify($name): string
    {
        return str_replace(' ', '-', $name);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function update(Request $request, int $id)
    {
        $page = $this->model->findOrFail($id);

        $data = [
            'title' => $request->input('title'),
            'slug' => $this->slugify($request->input('title')),
            'excerpt' => $request->input('excerpt'),
            'description' => saveTextEditorImage($request->input('description')),
            'published' => filter_var($request->input('published'), FILTER_VALIDATE_BOOLEAN),
        ];

        // Keywords
        $page->keywords()->detach();
        $newKeywords = explode(',', $request->input('keywords'));
        $keywordIds = [];

        foreach ($newKeywords as $keyword) {
            $keyword = Keyword::firstOrCreate(['title' => $keyword]);
            $keywordIds[] = $keyword->id;
        }

        $page->keywords()->sync($keywordIds);

        return $page->update($data);
    }
    /**
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function updateNews(Request $request, int $id)
    {
        $news = News::findOrFail($id);

        $data = [
            "title" => $request->input('title'),
            "description" => $request->input('description'),
            'published' => filter_var($request->input('published'), FILTER_VALIDATE_BOOLEAN),
        ];
        return $news->update($data);
    }
    public function translate(Request $request, int $id): array
    {
        $article = Page::findOrFail($id);
        $data = $this->translateData($request);
        $article->update($data);

        return ['article' => $article];
    }

    public function delete(int $id)
    {
        $page = $this->model->findOrFail($id);
        $page->keywords()->detach();
        $page->pageLinks()->delete();

        return $page->delete();
    }

    public function all(array $columns = [])
    {
        return count($columns) ? $this->model->select($columns)->orderBy('id')->get() : $this->model->orderBy('id')->get();
    }
    public function allNews(array $columns = [])
    {
        return count($columns) ? News::select($columns)->orderBy('id')->get() : News::orderBy('id')->get();
    }

    public function paginate($perPage = 10)
    {
        return $this->model->latest()
            ->when(request()->has('is_published'), function ($q) {
                $q->where('published', (bool)request('is_published'));
            })
            ->when(\request()->has('search'), function ($q) {
                $q->where('title'.'_'.app()->getLocale(), 'LIKE', '%' . \request('search') . '%');
            })
            ->paginate($perPage);
    }
    public function paginateNews($perPage = 10)
    {
        return News::latest()
            ->when(request()->has('is_published'), function ($q) {
                $q->where('published', (bool)request('is_published'));
            })
            ->when(\request()->has('search'), function ($q) {
                $q->where('title'.'_'.app()->getLocale(), 'LIKE', '%' . \request('search') . '%');
            })
            ->paginate($perPage);
    }

}
