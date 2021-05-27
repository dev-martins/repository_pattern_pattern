<?php

namespace App\Repositories\Core\QueryBuilder;

use App\Repositories\Core\BaseQueryBuilderRepository;
use App\Repositories\Contracts\ProductRepositoryInterface;

class QueryBuilderProductRepository extends BaseQueryBuilderRepository implements ProductRepositoryInterface
{
    public $table = 'products';
}
