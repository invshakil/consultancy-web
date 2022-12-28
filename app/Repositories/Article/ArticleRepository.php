<?php

namespace App\Repositories\Article;

use App\Models\Application;
use App\Models\Article;
use App\Models\Category;
use App\Models\Job;
use App\Models\Keyword;
use App\Models\NewsLetter;
use App\Models\User;
use App\Models\Visitor;
use Cache;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Str;

class ArticleRepository implements ArticleInterface
{

    private $model;
    private $disk = 'public';

    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    public function save(Request $request)
    {
        $image_url = $this->storeImage($request, $currentArticle = '');
        $data = $this->storeData($request, $image_url);
        $article = $this->model::create($data);
        // Category
        $categoryIDs = $this->getCategoryIDs($request->input('categories'));
        $article->categories()->sync($categoryIDs);
        // Tags
        $tagIDs = $this->getTagIDs($request);
        $article->keywords()->sync($tagIDs);

        if($request->input('published')==='1'){
            $this->sendMail($article);
        }

        return $article;
    }
    public function update(Request $request, int $id): array
    {
        $article = Article::findOrFail($id);
        $isPublishedBefore = $article->published;
        $isTranslatedBefore = $article->title;
        $image_url = $this->storeImage($request, $currentArticle = $article);
        $data = $this->storeData($request, $image_url);
        if($article['slug']){
            $data['slug']=$article['slug'];
        }
        // Category
        $article->categories()->detach();
        $categoryIDs = $this->getCategoryIDs($request->input('categories'));
        $article->categories()->sync($categoryIDs);
        // Tags
        $tagIDs = $this->getTagIDs($request);
        $article->keywords()->detach();
        $article->keywords()->sync($tagIDs);

        $article->update($data);


        if($isPublishedBefore===0 && $request->input('published')===1){
            $this->sendMail($article);
        }
        if($isPublishedBefore===0 && !$isTranslatedBefore && $request->input('published')===1){
            $this->sendMailEnglish($article);
        }

        return ['article' => $article, 'previouslyPublished' => $isPublishedBefore];
    }

    public function delete(int $id)
    {
        $article = Article::findOrFail($id);
        if (File::exists($article->image)) {
            File::delete($article->image);
        }
        $article->categories()->detach();
        $article->keywords()->detach();

        return $article->delete();
    }

    private function sendMail($article)
    {
        $subscribers = NewsLetter::all();
        $data = [
            'name' => 'Tanventurer',
            'thanks' => 'সাথে থাকার জন্যে ধন্যবাদান্তে',
            'hello' => 'প্রিয় সাবস্ক্রাইবার!!',
            'email' => 'tanvirrezaanik@gmail.com',
            'contact' => 'আমার সাথে যোগাযোগ করতে পারেন এই ইমেইলে: ',
            'subject' => 'ট্যানভেঞ্চারে নতুন আর্টিকেল প্রকাশিত হয়েছে',
            'link' => "tanventurer.com/articles/$article->slug",
            'body' => 'ট্যানভেঞ্চারারে একটি নতুন আর্টিকেল প্রকাশিত হয়েছে! লেখাটি এখানে পড়তে পারেনঃ '
        ];

        for ($i = 0; $i < $subscribers->count(); $i++) {
            \Mail::send('email.contact-template', $data, function ($message) use ($subscribers, $i, $data) {
                $message->to($subscribers[$i]->email)
                    ->from($data['email'], $data['name'])
                    ->subject($data['subject']);
            });
        }
    }
    private function sendMailEnglish($article)
    {
        $subscribers = NewsLetter::all();
        $data = [
            'name' => env('APP_NAME'),
            'thanks' => 'Thanks for staying in touch',
            'hello' => 'Hello Dear Subscriber!!',
            'email' => env('SENDER_EMAIL'),
            'contact' => 'Get in touch with us for anything at: ',
            'subject' => 'Whoooo! Tan wrote a new something!!',
            'link' => env('APP_URL') ."/article/$article->slug",
            'body' => env('APP_NAME'). ' had a recent article published.You can find the post in this link: ',
        ];

        for ($i = 0; $i < $subscribers->count(); $i++) {
            \Mail::send('email.contact-template', $data, function ($message) use ($subscribers, $i, $data) {
                $message->to($subscribers[$i]->email)
                    ->from($data['email'], $data['name'])
                    ->subject($data['subject']);
            });
        }
    }

    private function getCategoryIDs($request): array
    {
        $newCategories = explode(',', $request);
        $categoryIDs = [];
        foreach ($newCategories as $category) {
            $cat = Category::where('id', $category)->orWhere('id', $category)->first();

            $categoryIDs[] = $cat->id;
        }

        return $categoryIDs;
    }

    private function getTagIDs($request): array
    {
        $newTags = explode(',', $request->input('keywords'));
        $tagIDs = [];
        foreach ($newTags as $tag) {
            $tag = Keyword::firstOrCreate(['title' => $tag]);
            $tagIDs[] = $tag->id;
        }
        return $tagIDs;
    }

    private function storeImage($request, $currentArticle): string
    {
        $image = $request->image;
        if ($request->hasFile('image')) {
            $image_ext = $image->getClientOriginalExtension();
            $image_full_name = 'cover_' . $this->slugify($request->input('title')) . '.' . $image_ext;
            $upload_path = 'article/images/';
            if (!\File::isDirectory($upload_path)) {
                \File::makeDirectory($upload_path, 777, true);
            }
            $img = Image::make($image->getRealPath());
//            \File::put(public_path($upload_path) . $image_full_name, base64_decode($image));
            $img->save($upload_path. $image_full_name);
            $image_url = $upload_path . $image_full_name;
        } else {
            $image_url = $currentArticle->image;
        }
        return $image_url;
    }

    private function storeData($request, $image_url): array
    {
        return [
            'user_id' => auth()->user()->id,
            'title' => $request->input('title'),
            'slug' => $this->slugify($request->input('title')),
            'excerpt' => $request->input('excerpt'),
            'description' => saveTextEditorImage($request->input('description'),trim($this->slugify($request->input('title')), ".") ),
            'published' => filter_var($request->input('published'), FILTER_VALIDATE_BOOLEAN),
            'featured' => filter_var($request->input('featured'), FILTER_VALIDATE_BOOLEAN),
            'image' => $image_url,
        ];
    }

    private function slugify($name): string
    {
        $trimmed=str_replace(' ', '-', $name);
        return str_replace('.', '-', $trimmed);
    }

    public function all(array $columns = [])
    {
        return count($columns) ? Article::select($columns)->orderBy('id')->get() : Article::orderBy('viewed')->get();
    }

    public function paginate($perPage = 10)
    {
        return Article::latest()
            ->with('author')
            ->with('categories')
            ->when(request()->has('category'), function ($q) {
                $q->whereHas('categories', function ($sq) {
                    $sq->where('category_id', \request('category'));
                });
            })
            ->when(request()->has('is_published'), function ($q) {
                $q->where('published', (bool)request('is_published'));
            })
            ->when(\request()->has('search'), function ($q) {
                $q->where('title' . '_' . app()->getLocale(), 'LIKE', '%' . \request('search') . '%');
            })
            ->orderBy('viewed', 'desc')
            ->paginate($perPage);
    }

    public function paginateWithFilter(int $limit)
    {
        // TODO: Implement paginateWithFilter() method.
    }

    public function paginateByCategoryWithFilter(int $perPage, int $categoryId)
    {
        return $this->baseQuery($categoryId)
            ->latest()
            ->with('author')
            ->with('categories')
            ->paginate($perPage);
    }

    public function getArticleCount()
    {
        return Article::where('created_at', '>', Carbon::now()->subDays(1))
            ->groupBy(\DB::raw('HOUR(created_at)'))
            ->count();
    }

    public function getAllArticleCount(): int
    {
        return Article::all()->count();
    }

    public function jobsInfo(): int
    {
        return Job::all()->count();
    }

    public function getJobCount()
    {
        return Job::where('created_at', '>', Carbon::now()->subDays(7))
            ->groupBy(\DB::raw('HOUR(created_at)'))
            ->count();
    }

    public function applicationInfo(): int
    {
        return Application::all()->count();
    }

    public function getApplicationCount()
    {
        return Application::where('created_at', '>', Carbon::now()->subDays(7))
            ->groupBy(\DB::raw('HOUR(created_at)'))
            ->count();
    }


    public function SetVisitor()
    {
        $ip = request()->ip();
        $visited_date = Carbon::now();
        $visitor = Visitor::firstOrCreate(['ip' => $ip], ['visit_date' => $visited_date]);
        $cacheKey = request()->ip();
        \Cache::remember($cacheKey, 60, function () use ($visitor) {
            $visitor->increment('hits');
            $visitor->increment('lastDayRecord');
            $visitor->save();
            return true;
        });

        Visitor::where('visit_date', '<', Carbon::now()->subDays(1))
            ->update(['lastDayRecord' => 0]);

        Visitor::where('created_at', '<', Carbon::now()->subDays(1))
            ->update(['visit_date' => Carbon::now(), 'created_at' => Carbon::now()]);

    }

    public function getTotalVisitCount(): int
    {
        return Visitor::sum('hits');
    }

    public function getLastDaysTotalVisitCount(): int
    {
        return Visitor::where('updated_at', '>', Carbon::now()->subDays(1))
            ->sum('lastDayRecord');
    }

    public function getUniqueVisitorCount(): int
    {
        return Visitor::all()->count();
    }

    public function getLastWeeksUniqueVisitorCount()
    {
        return Visitor::where('updated_at', '>', Carbon::now()->subDays(7))
            ->count('id');
    }

    public function getLastWeeksVisitCountByDay()
    {
        return Visitor::select(DB::raw('sum(hits) as visits'))
            ->where('visit_date', ">", DB::raw('NOW() - INTERVAL 1 WEEK'))
            ->groupBy('visit_date')
            ->get();
    }

    public function getSubsCount(): int
    {
        return NewsLetter::all()->count();
    }

    public function getLastWeekSubsCount(): int
    {
        return NewsLetter::where('created_at', '>', Carbon::now()->subDays(7))
            ->count('id');
    }

    private function baseQuery(int $categoryId = 1)
    {
        return $this->model->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('published', '=', 1);
            $q->when($categoryId !== 0, function ($sq) use ($categoryId) {
                $sq->where('category_id', $categoryId);
            });
        });
    }

    public function publishedArticles(int $categoryId, int $limit): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->model
            ->where('published', 1)
            ->with('categories')
            ->with('author')
            ->latest()
            ->paginate($limit);
    }

    public function getNovels()
    {
        return $this->baseQuery(7)
            ->with('categories')
            ->latest()
            ->with('author')
            ->paginate(5);
    }

    public function getAuthor($slug)
    {
        return User::where('id', $slug)
            ->first();
    }

    public function getAuthorArticles($slug)
    {
        return $this->model
            ->where('user_id', $slug)
            ->limit(3)
            ->get();
    }

    public function publishedFeaturedArticles( int $limit)
    {
        return $this->model
            ->where('featured', 1)
            ->where('published', 1)
            ->latest()
            ->with('author')
            ->limit($limit)
            ->get();
    }
    public function mostReadArticles(int $categoryId, int $limit)
    {
        return $this->baseQuery($categoryId)
            ->limit($limit)
            ->with('author')
            ->with('categories')
            ->orderBy('viewed', 'desc')
            ->get();
    }

    public function getArticle($condition, $isSlug = false)
    {
        return $this->model
            ->with(['categories' => function ($q) use ($condition, $isSlug) {
                $q->with(['articles' => function ($sq) use ($condition, $isSlug) {
                    $sq->where('published', '=', true)
                        ->when($isSlug, function ($s) use ($condition) {
                            $s->where('slug', '!=', $condition);
                        })
                        ->when(!$isSlug, function ($s) use ($condition) {
                            $s->where('article_id', '!=', $condition);
                        })
                        ->inRandomOrder()
                        ->limit(4);
                }]);
            }])
            ->with(['author'])
            ->with(['keywords'])
            ->where('published', true)
            ->when($isSlug, function ($q) use ($condition) {
                $q->where('slug', $condition);
            })
            ->when(!$isSlug, function ($q) use ($condition) {
                $q->where('id', $condition);
            })
            ->first();
    }

    public function getSimilarArticles($categoryId, $limit)
    {
        return $this->baseQuery($categoryId)
            ->inRandomOrder()
            ->limit($limit)
            ->with('author')
            ->get();
    }

    public function searchArticles($query, $perPage)
    {
        return $this->baseQuery(1)
            ->with('author')
            ->where('description', 'LIKE', '%' . $query . '%')
            ->orWhere('description', 'LIKE', '%' . $query . '%')
            ->orWhere('title', 'LIKE', '%' . $query . '%')
            ->orWhere('title', 'LIKE', '%' . $query . '%')
            ->latest()
            ->limit(5)
            ->paginate($perPage);
    }

    public function getAllTags()
    {
        return Keyword::all()->unique('title');
    }

    public function getTagInfoWithArticles($tag, $perPage, $includeFavorites = false): array
    {
        $string = Str::title(str_replace('-', ' ', trim($tag)));
        $tag = Keyword::where('title', 'LIKE', '%' . $string . '%')->get();
        $tags = Keyword::all()->unique('title');

        return [
            'tagInfo' => count($tag) ? $tag[0] : null,
            'tags' => count($tags) ? $tags : null,
            'articles' => count($tag) ? $this->getArticlesByTag($perPage, $tag->pluck('id')->toArray(), $includeFavorites) : []
        ];
    }

    public function getArticlesByTag($perPage, array $keywordIds, $includeFavorites = false)
    {
        $q = $this->model->whereHas('keywords', function ($q) use ($keywordIds) {
            $q->whereIn('keyword_id', $keywordIds);
        })
            ->with('categories:id,name,slug')
            ->with('keywords:id,title')
            ->with('author')
            ->where('published', true)
            ->latest();

        return $perPage === 4 ? $q->limit($perPage)->get() : $q->paginate($perPage);
    }

}
