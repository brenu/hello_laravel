<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository {
  /**
   * @var Model
   */
  private $model;
  public function __construct(Model $model){
    $this->model = $model;
  }

  public function selectConditions($conditions){
    // Depois pesquisa o que esse método explode faz
    $expressions = explode(';', $conditions);
            
    $where = '';
    foreach($expressions as $e){
        $explode = explode(':', $e);
        $this->model = $this->model->where($explode[0], $explode[1], $explode[2]);
    }

  }

  public function selectFilter($filters){
    $this->model = $this->model->selectRaw($filters);
  }

  public function getResult(){
    return $this->model;
  }
}