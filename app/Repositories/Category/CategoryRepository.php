<?php


namespace App\Repositories\Category;


use App\Models\Category;
use Artisan;

class CategoryRepository implements CategoryInterface
{
    private $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function create(array $data)
    {
        $data['slug'] = $this->slugify($data['name']);
        $data['position'] = Category::max('position') + 1;
        Artisan::call('cache:clear');

        return $this->model->create($data);
    }

    private function slugify($name): string
    {
        return str_replace(' ','_',$name);
    }

    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    public function update(array $data, int $id)
    {
        $data['slug'] = $this->slugify($data['name']);
        Artisan::call('cache:clear');

        return $this->model->where('id', $id)->update($data);
    }

    public function delete(int $id)
    {
        Artisan::call('cache:clear');

        return $this->model->where('id', $id)->delete();
    }

    public function all(array $columns = [], bool $fetchPublishedOnly = false)
    {
        return $this->model->when(count($columns), function ($q) use ($columns) {
            $q->select($columns);
        })->when($fetchPublishedOnly, function ($q) {
            $q->where('is_published', true);
        })->orderBy('id')->get();
    }

    public function paginate($perPage = 10)
    {
        return $this->model->orderBy('position', 'asc')->withCount('articles')->paginate($perPage);
    }

    public function priorityUpdate(array $ids): bool
    {
        foreach ($ids as $key => $id) {
            $this->model->where('id', $id)->update(['position' => $key + 1]);
        }
        Artisan::call('cache:clear');

        return true;
    }
}
