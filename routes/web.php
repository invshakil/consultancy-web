<?php

use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * PUBLIC ROUTES
 */

Route::get('/', [WebsiteController::class, 'home'])->name('home');
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('sitemap', function () {

    // create new sitemap object
    $sitemap = App::make('sitemap');

    // set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
    // by default cache is disabled
    $sitemap->setCache('laravel.sitemap', 60);

    // check if there is cached sitemap and build new only if is not
    if (!$sitemap->isCached()) {
        $sitemap->add(URL::to('/'), now(), '1.0', 'daily');

        // get all posts from db, with image relations
        $posts = \App\Models\Article::where('published', true)->select('id', 'published', 'title', 'image', 'slug', 'excerpt', 'updated_at')->latest()->get();

        // add every post to the sitemap
        foreach ($posts as $post) {
            $images = array(array(
                'url' => $post->image_url,
                'title' => $post->title,
                'caption' => $post->cover_caption != '' && $post->cover_caption != null ? $post->cover_caption : $post->title
            ));

            $sitemap->add(URL::to($post->slug), $post->updated_at, '0.8', 'daily', $images, $post->title);
        }

        $categories = \App\Models\Category::select('id', 'name', 'slug', 'updated_at', 'is_published')->where('is_published', true)->get();

        foreach ($categories as $category) {
            $sitemap->add(URL::to('/categories/' . $category->slug), $category->updated_at, '0.9', 'daily', [], $category->name);
        }
    }

    return $sitemap->render('xml');
});
Route::get('/jobs', [WebsiteController::class, 'job'])->name('job');
Route::get('/study/{country}', [WebsiteController::class, 'study'])->name('study');
Route::get('/search', [WebsiteController::class, 'searchArticle'])->name('search');
Route::get('/about', [WebsiteController::class, 'about'])->name('about');
Route::get('/blog', [WebsiteController::class, 'blog'])->name('blog');
Route::get('/{slug}', [WebsiteController::class, 'articleDetails'])->name('article-details');
Route::get('/upload-cv/{id}', [WebsiteController::class, 'resume'])->name('upload-cv');
Route::post('/submit-cv', [WebsiteController::class, 'submitCV'])->name('submit-cv');
Route::post('/contact-mail', [WebsiteController::class, 'contactMail'])->name('contact-mail');
Route::post('/contact-study', [WebsiteController::class, 'contactStudy'])->name('contact-study');
Route::get('/verify/{id}', [WebsiteController::class, 'verify'])->name('verify');
Route::get('categories/{slug}', [WebsiteController::class, 'categoryDetails'])->name('category');

/**
 * ADMIN ROUTES
 */
Route::get('/dashboard/{any}', [ApplicationController::class, 'index'])->where('any', '(.*)');

Route::get('/{slug}/{nextSlug}', function ($slug, $nextSlug) {
    if ($nextSlug == "amp" || $nextSlug == "feed") {
        return redirect()->route('article-details', ['slug' => $slug]);
    }

    abort(404);

    return false;
});
