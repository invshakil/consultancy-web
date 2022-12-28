<?php

namespace App\Http\Controllers;


use App\Models\Application;
use App\Models\Category;
use App\Models\Country;
use App\Models\Industry;
use App\Models\Job;
use App\Models\News;
use App\Models\NewsLetter;
use App\Models\Page;
use App\Models\PageLink;
use App\Repositories\Article\ArticleRepository;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Http\Request;
use Session;
use Share;
use Throwable;

// OR with multi

// OR


class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    private $articleRepository;
    private $baseSeoData;
    private $homePageSeoData;

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->homePageSeoData = json_decode(setting()->get('general'), true);
        $this->baseSeoData = [
            'title' => $this->homePageSeoData['home_page_title'],
            'description' => $this->homePageSeoData['home_page_description'],
            'keywords' => $this->homePageSeoData['home_page_keywords'],
            'image' => asset('images/logo.png'),
            'type' => 'website',
            'site' => env('APP_URL'),
            'app_name' => $this->homePageSeoData['app_name'],
            'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1'
        ];
        $this->articleRepository = $articleRepository;
        $this->articleRepository->SetVisitor();

        $footerPages = \Cache::remember('footer_pages', config('cache.default_ttl'), function () {
            return PageLink::where('key', 'footer_pages')->with('page:id,title,slug')->get()->toArray();
        });
        $mostReadPosts = \Cache::remember('most_read_posts', config('cache.half_ttl'), function () {
            return $this->articleRepository->mostReadArticles(0, 3);
        });

        view()->share('footerPages', $footerPages);
        view()->share('settings', $this->homePageSeoData);
        view()->share('mostReadPosts', $mostReadPosts);
    }

    public function home()
    {
        $featuredPosts = \Cache::remember('featured_posts', config('cache.half_ttl'), function () {
            return $this->articleRepository->publishedFeaturedArticles(2);
        });
        $this->seo($this->baseSeoData);
        $news = News::where('published', 1)->get();

        return view('pages.home.index', compact('news', 'featuredPosts'));
    }

    public function about()
    {
        $this->baseSeoData['title'] = 'Contact-' . $this->homePageSeoData['home_page_title'];
        $this->seo($this->baseSeoData);

        return view('pages.about.index');
    }
    public function blog()
    {
        $publishedArticles = $this->articleRepository->publishedArticles(1, 6);
        $mostReadArticles = \Cache::remember('most_read_articles', config('cache.half_ttl'), function () {
            return $this->articleRepository->mostReadArticles(1, 3);
        });
        $featuredArticles = \Cache::remember('featuredArticles', config('cache.half_ttl'), function () {
            return $this->articleRepository->publishedFeaturedArticles(3);
        });

        $this->seo($this->baseSeoData);

        return view('pages.blog.index',
            compact(
                'publishedArticles',
                'mostReadArticles',
                'featuredArticles',
            )
        );
    }

    public function job()
    {
        $exp = explode('-', \request('exp'));
        $jobs = Job::where('published', 1)
            ->with('country')
            ->when(request()->has('country'), function ($q) {
                if (\request('country')[0] !== 'all') {
                    $q->whereHas('country', function ($sq) {
                        $sq->whereIn('country_id', \request('country'));
                    });
                }
            })
            ->when(request()->has('type'), function ($q) {
                if (request('type')[0] !== 'all') {
                    $q->whereIn('type', request('type'));
                }
            })
            ->when(request()->has('industry'), function ($q) {
                if (request('industry')[0] !== 'all') {
                    $q->whereIn('industry', request('industry'));
                }
            })
            ->when(request()->has('exp'), function ($q) use ($exp) {
                if ($exp[0] != 'all') {
                    $q->where('exp_min', '<=', (int)$exp[0]);
                }
            })
            ->when(request()->has('length'), function ($q) {
                if (\request('length')[0] != 'all') {
                    $q->whereIn('length', \request('length'));
                }
            })
            ->when(request()->has('search'), function ($sq) {
                $sq->where('industry', 'LIKE', '%' . \request('search') . '%');
            })
            ->paginate(5);

        $countries = Country::all();
        $industries = Industry::all();

        $requestedCountries = [];
        if (\request('country')) {
            $ct = Country::whereIn('id', \request('country'))->select('name')->get()->toArray();
            foreach ($ct as $c) {
                $requestedCountries[] = $c['name'];
            }
        }
        $this->baseSeoData['title'] = $this->homePageSeoData['job_title'];
        $this->baseSeoData['description'] = $this->homePageSeoData['job_description'];
        $this->seo($this->baseSeoData);
        $shareLinks = $this->getShareLinks($jobs);


        return view('pages.job.index',
            compact('jobs', 'countries', 'industries', 'requestedCountries', 'shareLinks')
        );
    }

    public function getShareLinks($data){
        foreach ($data as $d){
            return Share::page(url()->current(), $d->title)
                ->facebook()
                ->twitter()
                ->linkedin($d->excerpt)
                ->whatsapp()
                ->telegram()
                ->getRawLinks();
        }
    }

    public function resume()
    {
        $this->seo($this->baseSeoData);
        return view('pages.resume.index');
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:news_letters,email',
        ]);

        $data=['email'=>$request->input('email'), 'status'=>true];
        NewsLetter::create($data);
        return response('subscribed', 201);
    }

    public function contactMail(Request $request)
    {
        $this->sendMail($request);
        $this->seo($this->baseSeoData);
        return response('sent', 201);
    }

    public function contactStudy(Request $request)
    {
        $this->sendMailStudy($request);
        $this->seo($this->baseSeoData);
        return response('sent mail', 201);
    }

    private function sendMail($request)
    {
//        dd($request->input());
        $data = [
            'name' => $request->input('name'),
            'hello' => 'Hello Admin!',
            'email' => $request->input('email'),
            'subject' => 'New E-Mail Received For ' . env('APP_NAME'),
            'body' => $request->input('message')
        ];

        \Mail::send('email.contact-admin', $data, function ($message) use ($data) {
            $message->to(env('RECEIVER_EMAIL'))
                ->from($data['email'], $data['name'])
                ->subject($data['subject']);
        });
    }

    private function sendMailStudy($request)
    {
//        dd($request->input());
        $data = [
            'name' => $request->input('name'),
            'hello' => 'Hello Admin!',
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'whatsapp' => $request->input('whatsapp'),
            'subject' => 'New E-Mail Received For ' . env('APP_NAME'),
        ];

        \Mail::send('email.contact-study', $data, function ($message) use ($data) {
            $message->to(env('RECEIVER_EMAIL'))
                ->from($data['email'], $data['name'])
                ->subject($data['subject']);
        });
    }

    public function submitCV(Request $request)
    {
        \DB::beginTransaction();

        $file = $this->storeFile($request);
        $data = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
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
            $application = Application::updateOrCreate(['email' => $request->input('email'), 'job_id' => $request->input('jobID')], $data);
            if ($request->input('sub') == true) {
                NewsLetter::updateOrCreate(['email' => $request->input('email')], ['email' => $request->input('email')]);
            }
            \DB::commit();
            return response($application, 201);

        } catch (Throwable $throwable) {
            \DB::rollBack();
            $this->errorLog($throwable, 'api');

            return response($throwable->getMessage(), 520);
        }
    }

    private function storeFile($request)
    {
        $request->validate([
            'file' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf|max:2048'
        ]);
        if ($request->file('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $request->input('name') . '_' . $file->getClientOriginalName();

            // File upload location
            $upload_path = 'applications/files/';
            if (!\File::isDirectory($upload_path)) {
                \File::makeDirectory($upload_path, 777, true);
            }

            // Upload file
            $file->move($upload_path, $filename);

            Session::flash('message', 'Upload Successfully.');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'File not uploaded.');
            Session::flash('alert-class', 'alert-danger');
        }
        return $upload_path . $filename;
    }


    public function verify()
    {
        $this->seo($this->baseSeoData);
        return view('pages.verify.index');
    }

    public function study($slug)
    {
        $country=$slug;
        $this->seo($this->baseSeoData);
        return view('pages.study.index', compact('country'));
    }

    public function newsLetters(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'email' => 'email|required|unique:news_letters,email',
        ]);

        NewsLetter::create([
            'email' => $request->input('email')
        ]);

        return back()->with("success", "Thanks! We Got You!!");
    }


    public function sendNewsLetters(Request $request): \Illuminate\Http\RedirectResponse
    {
        $subscribers = NewsLetter::all();
        $data = [];
        for ($i = 0; $i < $subscribers->count(); $i++) {
            \Mail::send('email.mail', $data, function ($message) use ($subscribers, $i) {
                $message->to($subscribers[$i]->email)
                    ->from('Anikreza22@gmail.com', 'Anik Reza')
                    ->subject('Subject Line');
            });
        }

        return back()->with("success", "Thank You, We've Got You");
    }


    public function articleDetails($slug)
    {
        $article = $this->articleRepository->getArticle($slug, true);
        if (!$article) {
            return $this->renderPage($slug);
        }
        $category = $article['categories'][0];
        $similarArticles = $this->articleRepository->getSimilarArticles($category['id'], 2);
        $tags = $article->keywords;
        $tagTitles = [];
        foreach ($tags as $tag) {
            $tagTitles[] = $tag->title;
        }

        $cacheKey = request()->ip() . $slug;
        \Cache::remember($cacheKey, 60, function () use ($article) {
            $article->viewed = $article->viewed + 1;
            $article->save();
            return true;
        });

        $appName = env('APP_NAME');
        $this->baseSeoData['title'] = $article['title'] . '-' . $appName;
        $this->baseSeoData['description'] = $article['excerpt'] . '-' . $appName;
        $this->baseSeoData['keywords'] = $tagTitles;
        $this->seo($this->baseSeoData);
        $shareLinks = $this->getSeoLinksForDetailsPage($article);

        return view('pages.articleDetail.index', compact('article', 'shareLinks', 'similarArticles'));
    }

    public function searchArticle(Request $request)
    {
        $searchTerm = $request->input('query');
        $searchedArticles = $this->articleRepository->searchArticles($searchTerm, 5);

        $segments = [
            ['name' => $searchTerm],
        ];

        // SEO META INFO
        $appName = env('APP_NAME');
        $this->baseSeoData['title'] = "$searchTerm - $appName";
        $this->seo($this->baseSeoData);

        return view('pages.search.index', compact('segments', 'searchTerm', 'searchedArticles'));
    }

    public function renderPage($slug)
    {
        $page = Page::where('slug', $slug)->with('keywords')->first();

        if (!$page) {
            abort(404);
        }

        //visitor count
        $cacheKey = request()->ip() . $slug;
        \Cache::remember($cacheKey, 60, function () use ($page) {
            $page->viewed = $page->viewed + 1;
            $page->save();
            return true;
        });

        $segments = [
            ['name' => $page['title'], 'url' => url($slug)]
        ];
        $shareLinks = $this->getSeoLinksForDetailsPage($page);

        return view('pages.page-details.index', compact('page', 'segments', 'shareLinks'));
    }

    private function generatePageClass(): \stdClass
    {
        $page = new \stdClass();
        $page->title = 'Columnist';
        $page->excerpt = null;
        $page->keywords = [];
        $page->image_url = null;
        return $page;
    }

    private function getSeoLinksForDetailsPage($data)
    {
        $this->baseSeoData = [
            'title' => $data['title'] . " | {$this->baseSeoData['app_name']}",
            'description' => $data['excerpt'],
            'keywords' => count($data->keywords) ? implode(", ", $data->keywords->pluck('title')->toArray()) : $this->baseSeoData['keywords'],
            'image' => $data->image_url,
            'type' => 'article',
            'site' => env('APP_URL'),
            'app_name' => $this->baseSeoData['app_name'],
            'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1'
        ];
        $this->seo($this->baseSeoData);

        return Share::page(url()->current(), $data->title)
            ->facebook()
            ->twitter()
            ->linkedin($data->excerpt)
            ->whatsapp()
            ->telegram()
            ->getRawLinks();
    }

    private function seo($data)
    {
        SEOMeta::setTitle($data['title'], false);
        SEOMeta::setDescription($data['description']);
//        SEOMeta::addMeta('name', $value = null, $name = 'name');
        SEOMeta::setKeywords($data['keywords']);
        SEOMeta::setRobots($data['robots']);
        SEOMeta::setCanonical(url()->full());

        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('@nimo');
        SEOTools::jsonLd()->addImage(asset('/images/logo.png'));

//        OpenGraph::addProperty('keywords', '$value'); // value can be string or array
        OpenGraph::setTitle($data['title']); // define title
        OpenGraph::setDescription($data['description']);  // define description
        OpenGraph::setSiteName($data['app_name']);
        OpenGraph::setArticle($data);

        if ($data['image']) {
            OpenGraph::addImage($data['image']); // add image url
        } else {
            OpenGraph::addImage($this->homePageSeoData['home_page_image_url']); // add image url
        }

        OpenGraph::setUrl(url()->current()); // define url
        OpenGraph::setSiteName($data['app_name']); //define site_name

        TwitterCard::setType('summary'); // type of twitter card tag
        TwitterCard::setTitle($data['title']); // title of twitter card tag
        TwitterCard::setDescription($data['description']); // description of twitter card tag

        if ($data['image']) {
            TwitterCard::setImage($data['image']); // add image url
        } else {
            TwitterCard::setImage($this->homePageSeoData['home_page_image_url']); // add image url
        }

        TwitterCard::setSite($data['site']); // site of twitter card tag
        TwitterCard::setUrl(url()->current()); // url of twitter card tag

        if (isset($data['read_time'])) {
            TwitterCard::addValue('label1', 'Est. reading time'); // value can be string or array
            TwitterCard::addValue('data1', $data['read_time']); // value can be string or array
        }

//        JsonLd::addValue($key, $value); // value can be string or array
        JsonLd::setType($data['type']); // type of twitter card tag
        JsonLd::setTitle($data['title']); // title of twitter card tag
        JsonLd::setDescription($data['description']); // description of twitter card tag

        if ($data['image']) {

            JsonLd::setImage($data['image']); // add image url
        } else {
            JsonLd::setImage($this->homePageSeoData['home_page_image_url']); // add image url
        }
        JsonLd::setSite('@Nimo'); // site of twitter card tag
        JsonLd::setUrl(url()->current()); // url of twitter card tag
    }
}
