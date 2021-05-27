<?php

namespace App\Repositories\Core\QueryBuilder;

use Illuminate\support\Facades\DB;
use App\Repositories\Core\BaseQueryBuilderRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class QueryBuilderCategoryRepository extends BaseQueryBuilderRepository implements CategoryRepositoryInterface
{
    public $table = 'categories';

    public function search(array $data)
    {
        return DB::table($this->table)
            ->where(function ($query) use ($data) {

                if (isset($data['title'])) {
                    $query->where('title', $data['title']);
                }

                if (isset($data['url'])) {
                    $query->where('url', $data['url']);
                }

                if (isset($data['description'])) {
                    $query->where('description', 'LIKE', "%{$data['description']}%");
                }
            })->orderBy('id', 'DESC')->paginate(10);
    }

    public function productsByCategory($id)
    {
        return $this->db->table('products')
        ->where('category_id',$id)
        ->count();
    }
}
