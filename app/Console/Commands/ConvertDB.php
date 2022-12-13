<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use App\Models\Keyword;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Throwable;

class ConvertDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It converts articles data from old UVL DB to new';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws Throwable
     */


    public function handle()
    {
        $posts = Post::latest()->get()->toArray();

        foreach ($posts as $post) {
            try {
               dd($post);
            } catch (Throwable $throwable) {
                \DB::rollBack();

                \Log::info('Article Could not fetch:' . $post['title']);
                \Log::error('Error:' . $throwable->getMessage() . ' | Line: ' . $throwable->getLine());
                $this->info('Error:' . $throwable->getMessage() . ' | Line: ' . $throwable->getLine());
            }
        }

        return true;
    }
}
