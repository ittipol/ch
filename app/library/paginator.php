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

    $page = 1;

    $this->total = $this->model->all()->count();

    $this->lastPage = (int)ceil($this->total / $this->perPage);

    $offset = ($page - 1)  * $this->perPage;

    $start = $offset + 1;
    $end = min(($offset + $this->perPage), $this->total);

    $records = $this->model->take($this->perPage)->skip($offset)->get();

    foreach ($records as $record) {

      $image = $record->getRalatedModelData('Image',array(
        'first' => true
      ))->buildModelData();

      $this->data[] = array(
        'id' => $record->id,
        'name' => $record->name,
        'description' => $record->description,
        '_price' => 'THB '.number_format($record->price, 0, '.', ','),
        '_url' => '',
        '_imageUrl' => $image['_url']    
      );

    }

    return $this->data;

  }

}

?>