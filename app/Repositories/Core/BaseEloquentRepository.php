<?php

namespace App\Repositories\Core;

use App\Repositories\Contratcs\RepositoriesInterface;

class BaseEloquentRepository  implements RepositoriesInterface
{
    public function getAll(){

    }
    public function findById($id){

    }
    public function findWhere($column,$valor){

    }
    public function findWhereFirst($column,$valor){
        
    }
    public function paginate($totalPage = 10){
        
    }
    public function store(array $data){
        
    }
    public function update($id,array $data){
        
    }
    public function delete($id){
        
    }
}
