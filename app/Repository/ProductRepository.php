<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProductRepository {
  /**
   * @var Model
   */
  private $model;
/**
   * @var Request
   */
  private $request;
  public function __construct(Model $model,Request $request){
    $this->model = $model;
    $this->request = $request;
  }

  public function selectConditions($conditions){
    // Depois pesquisa o que esse método explode faz
    $expressions = explode(';', $conditions);
            
    $where = '';
    foreach($expressions as $e){
        $explode = explode(':', $e);
        $where = $this->model->where($explode[0], $explode[1], $explode[2]);
    }

    return $where;
  }

  public function selectFilter($filters){
    return $this->model->selectRaw($filters);
  }
}