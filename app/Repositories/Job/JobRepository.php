<?php

namespace App\Repositories\Job;

use App\Models\Article;
use App\Models\Category;
use App\Models\Country;
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

class JobRepository
{

    private $model;

    public function __construct(Job $job)
    {
        $this->model = $job;
    }

    public function save(Request $request)
    {
        $data = $this->storeData($request);
        $job = $this->model::create($data);
        $categoryIDs = $this->getCategoryIDs($request->input('country'));
        $job->country()->sync($categoryIDs);

//        if($request->input('published')==='1'){
//            $this->sendMail($job);
//        }

        return $job;
    }
    private function getCategoryIDs($request): array
    {
        $newCategories = explode(',', $request);
        $categoryIDs = [];
        foreach ($newCategories as $category) {
            $cat = Country::where('id', $category)->first();
            $categoryIDs[] = $cat->id;
        }

        return $categoryIDs;
    }
    public function update(Request $request, int $id): array
    {
        $job = Job::findOrFail($id);
        $isPublishedBefore = $job->published;
        $data = $this->storeData($request);
        if($job['slug']){
            $data['slug']=$job['slug'];
        }
        $categoryIDs = $this->getCategoryIDs($request->input('country'));
        $job->country()->detach();
        $job->country()->sync($categoryIDs);

        $job->update($data);

//        if($isPublishedBefore===0 && $request->input('published')===1){
//            $this->sendMail($job);
//        }
//        if($isPublishedBefore===0 && $request->input('published')===1){
//            $this->sendMailEnglish($job);
//        }

        return ['article' => $job, 'previouslyPublished' => $isPublishedBefore];
    }

    public function delete(int $id)
    {
        $job = Job::findOrFail($id);

        return $job->delete();
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
            'link' => "tanventurer.com/articles/$article->slug_bn",
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
            'name' => 'Tanventurer',
            'thanks' => 'Thanks for staying in touch',
            'hello' => 'Hello Dear Subscriber!!',
            'email' => 'tanvirrezaanik@gmail.com',
            'contact' => 'Get in touch with me for anything at: ',
            'subject' => 'Whoooo! Tan wrote a new something!!',
            'link' => "tanventurer.com/articles/$article->slug_en",
            'body' => 'Tanventurer had a recent article published.You can find the post in this link: ',
        ];

        for ($i = 0; $i < $subscribers->count(); $i++) {
            \Mail::send('email.contact-template', $data, function ($message) use ($subscribers, $i, $data) {
                $message->to($subscribers[$i]->email)
                    ->from($data['email'], $data['name'])
                    ->subject($data['subject']);
            });
        }
    }

    private function storeData($request): array
    {
        return [
            'title' => $request->input('title'),
            'slug' => $this->slugify($request->input('title')),
            'excerpt' => $request->input('excerpt'),
            'quality' => $request->input('quality'),
            'responsibility' => $request->input('responsibility'),
            'salary' => $request->input('salary'),
            'vacancy' => $request->input('vacancy'),
            'length' => $request->input('length'),
            'exp_min' => $request->input('exp_min'),
            'exp_max' => $request->input('exp_max'),
            'industry' => $request->input('industry'),
            'type' => $request->input('type'),
            'description' => $request->input('description'),
            'published' => filter_var($request->input('published'), FILTER_VALIDATE_BOOLEAN),
        ];
    }

    private function slugify($name): string
    {
        $trimmed=str_replace(' ', '-', $name);
        return str_replace('.', '-', $trimmed);
    }

    public function all(array $columns = [])
    {
        return count($columns) ? Job::select($columns)->orderBy('id')->get() : Job::orderBy('viewed')->get();
    }

    public function paginate($perPage)
    {
        return Job::latest()
            ->with('country')
            ->when(request()->has('is_published'), function ($q) {
                $q->where('published', (bool)request('is_published'));
            })
            ->when(\request()->has('search'), function ($q) {
                $q->where('title', 'LIKE', '%' . \request('search') . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    public function publishedArticles(int $categoryId, int $limit): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->model
            ->where('published', 1)
            ->latest()
            ->paginate($limit);
    }

    public function getArticle($condition, $isSlug = false)
    {
        return $this->model
            ->where('published', true)
            ->when($isSlug, function ($q) use ($condition) {
                $q->where('slug', $condition);
            })
            ->when(!$isSlug, function ($q) use ($condition) {
                $q->where('id', $condition);
            })
            ->first();
    }

    public function searchArticles($query, $perPage)
    {
        return $this->model
            ->where('description', 'LIKE', '%' . $query . '%')
            ->orWhere('title', 'LIKE', '%' . $query . '%')
            ->latest()
            ->limit(5)
            ->paginate($perPage);
    }

    public function getAllTags()
    {
        return Keyword::all()->unique('title');
    }
}
