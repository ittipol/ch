<?php 

namespace App\library;

class Paginator {
  public $total;
  public $lastPage;
  public $perPage = 15;
  public $url;
  public $nextPageUrl;
  public $prevPageUrl;
  public $data = array();

  public function __construct($model = null) {
    $this->model = $model;
  }

  public function setModel($model = null) {
    $this->model = $model;
  }

  public function setPerPage($perPage) {
    $this->perPage = $perPage;
  }

  public function setPage($perPage) {
    $this->perPage = $perPage;
  }

  public function build() {
    $this->total = $this->model->all()->count();

    $this->lastPage = (int)ceil($this->total / $this->perPage);

    $offset = ($page - 1)  * $this->perPage;

    dd($totalPage);

  }
}

?>