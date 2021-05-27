<?php

namespace App\Repositories\Core\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Core\BaseEloquentRepository;

class EloquentUserRepository extends BaseEloquentRepository implements UserRepositoryInterface
{
    public function entity()
    {
        return User::class;
    }

    public function search(array $data)
    {
        return $this->entity
            ->where(function ($query) use ($data) {

                if (isset($data['name'])) {
                    $query->where('name', 'LIKE', "%{$data['name']}%");
                }

                if (isset($data['email'])) {
                    $query->orWhere('email', 'LIKE', "%{$data['email']}%");
                }
                
            })->orderBy('id', 'DESC')->paginate(10);
    }
}
