<?php

namespace App\Repositories\Core;

use Illuminate\support\Facades\DB;
use App\Repositories\Contracts\RepositoriesInterface;
use App\Repositories\Exceptions\PropertyTableNotExists;

class BaseQueryBuilderRepository implements RepositoriesInterface
{
    public $table;

    public function __construct()
    {
        $this->table = $this->resolveTable();
    }

    public function getAll()
    {
        return DB::table($this->table)->get();
    }

    public function findById($id)
    {
        return DB::table($this->table)->find($id);
    }

    public function findWhere($column, $value)
    {
        return DB::table($this->table)->where($column, $value)->get();
    }

    public function findWhereFirst($column, $value)
    {
        return DB::table($this->table)->where($column, $value)->first();
    }

    public function paginate($totalPage = 10)
    {
        return DB::table($this->table)->paginate($totalPage);
    }

    public function store(array $data)
    {
        return DB::table($this->table)->insert($data);
    }

    public function update($id, array $data)
    {
        return DB::table($this->table)->where('id',$id)->update($data);
    }

    public function delete($id)
    {
        return DB::table($this->table)->where('id',$id)->delete();
    }

    public function resolveTable()
    {
        if (!property_exists($this, 'table')) {
            throw new PropertyTableNotExists;
        }
        return $this->table;
    }
}
