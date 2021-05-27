<?php

namespace App\Repositories\Core;

// use Illuminate\support\Facades\DB;
use Illuminate\Database\DatabaseManager as DB;
use App\Repositories\Contracts\RepositoriesInterface;
use App\Repositories\Exceptions\PropertyTableNotExists;

class BaseQueryBuilderRepository implements RepositoriesInterface
{
    public $table;
    private $orderBy = [
        'column' => 'id',
        'order'  => 'DESC'
    ];

    public function __construct(DB $db)
    {
        $this->table = $this->resolveTable();
        $this->db = $db;
    }

    public function orderBy($column, $order = 'DESC')
    {
        $this->orderBy = [
            'column' => $column,
            'order'  => $order
        ];

        return $this;
    }

    public function getAll()
    {
        return $this->db->table($this->table)->orderBy('id','DESC')->get();
        // return $this->db->table($this->table)->get();
    }

    public function findById($id)
    {
        return $this->db->table($this->table)->find($id);
    }

    public function findWhere($column, $value)
    {
        return $this->db->table($this->table)->where($column, $value)->get();
    }

    public function findWhereFirst($column, $value)
    {
        return $this->db->table($this->table)->where($column, $value)->first();
    }

    public function paginate($totalPage = 10)
    {
        return $this->db->table($this->table)->paginate($totalPage);
    }

    public function store(array $data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function update($id, array $data)
    {
        return $this->db->table($this->table)->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->db->table($this->table)->where('id', $id)->delete();
    }

    public function resolveTable()
    {
        if (!property_exists($this, 'table')) {
            throw new PropertyTableNotExists;
        }
        return $this->table;
    }
}
