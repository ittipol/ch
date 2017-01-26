<?php 

namespace App\library;

class Paginator {
  public $total;
  public $page = 1;
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

  public function setPage($page) {
    $this->page = $page;
  }

  public function build() {

    $currency = new Currency;
    $imageStyle = Service::loadModel('ImageStyle');

    $this->total = $this->model->all()->count();
    $this->lastPage = (int)ceil($this->total / $this->perPage);

    $offset = ($this->page - 1)  * $this->perPage;

    $start = $offset + 1;
    $end = min(($offset + $this->perPage), $this->total);

    $records = $this->model
    ->take($this->perPage)
    ->skip($offset)
    ->get();

    foreach ($records as $record) {

      $image = $record->getRalatedModelData('Image',array(
        'conditions' => array(
          array('image_style_id','=',$imageStyle->getIdByalias('list'))
        ),
        'first' => true
      ));

      $imageUrl = '/images/common/no-img.png';
      if(!empty($image)) {
        $image = $image->buildModelData();
        $imageUrl = $image['_url'];
      }

      $this->data[] = array(
        'id' => $record->id,
        'name' => $record->name,
        'description' => $record->description,
        '_price' => $currency->format($record->price),
        '_url' => '',
        '_imageUrl' => $imageUrl,    
      );

    }

    return $this->data;

  }

}

?>