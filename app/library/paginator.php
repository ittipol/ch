<?php 

namespace App\library;

class Paginator {

  private $total;
  private $page = 1;
  private $lastPage;
  private $perPage = 24;
  private $url;
  private $data = array();
  public $error = false;

  public function __construct($model = null) {
    $this->model = $model;
  }

  public function setModel($model = null) {
    $this->model = $model;
  }

  public function setPerPage($perPage) {
    $this->perPage = (int)$perPage;
  }

  public function setPage($page) {
    $this->page = (int)$page;
  }

  public function setUrl($url) {
    $this->url = $url;
  }

  public function build() {

    if(empty($this->model)) {
      return false;
    }

    $currency = new Currency;
    $imageStyle = Service::loadModel('ImageStyle');

    $this->total = $this->model->all()->count();
    $this->lastPage = (int)ceil($this->total / $this->perPage);

    if(($this->page < 1) || ($this->page > $this->lastPage)) {
      $this->error = true;
      return false;
    }

    $offset = ($this->page - 1)  * $this->perPage;

    // $start = $offset + 1;
    // $end = min(($offset + $this->perPage), $this->total);

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
        '_name_short' => String::subString($record->name,80),
        'description' => $record->description,
        '_price' => $currency->format($record->price),
        '_imageUrl' => $imageUrl,
        // '_totalImage' => 0,
      );

    }

    $paging = array();
    $pagingUrl = $this->url.'?page={n}';

    $skip = true;
    if(($this->page - 4) < 1){

      for ($i=1; $i < 6; $i++) { 

        if($i > $this->lastPage) {
          $skip = false;
          break;
        }
        
        $paging[] = array(
          'pageNumber' => $i,
          'url' => str_replace('{n}', $i, $pagingUrl)
        );

      }

      if($skip) {

        if(($this->lastPage - 5) > 2) {
          $paging[] = array(
            'pageNumber' => '...',
            'url' => null
          );
        }
        
        $paging[] = array(
          'pageNumber' => $this->lastPage,
          'url' => str_replace('{n}', $this->lastPage, $pagingUrl)
        );

      }

      
    }elseif(($this->page + 4) > $this->lastPage) {

      $paging[] = array(
        'pageNumber' => 1,
        'url' => str_replace('{n}', 1, $pagingUrl)
      );

      if(($this->lastPage-5) > 2) {
        $paging[] = array(
          'pageNumber' => '...',
          'url' => null
        );
      }

      for ($i=4; $i >= 0; $i--) { 

        $paging[] = array(
          'pageNumber' => $this->lastPage-$i,
          'url' => str_replace('{n}', $this->lastPage-$i, $pagingUrl)
        );

      }

    }else{

      $paging[] = array(
        'pageNumber' => 1,
        'url' => str_replace('{n}', 1, $pagingUrl)
      );

      $paging[] = array(
        'pageNumber' => '...',
        'url' => null
      );

      $start = $this->page - 2;

      for($i=1; $i < 4; $i++) {
        $paging[] = array(
          'pageNumber' => $start+$i,
          'url' => str_replace('{n}', $start+$i, $pagingUrl)
        );
      }

      $paging[] = array(
        'pageNumber' => '...',
        'url' => null
      );

      $paging[] = array(
        'pageNumber' => $this->lastPage,
        'url' => str_replace('{n}', $this->lastPage, $pagingUrl)
      );

    }

    $prev['url'] = str_replace('{n}', $this->page-1, $pagingUrl);
    if(($this->page - 1) < 1) {
      $prev['url'] = null;
    }

    $next['url'] = str_replace('{n}', $this->page+1, $pagingUrl);
    if(($this->page + 1) > $this->lastPage) {
      $next['url'] = null;
    }

    return array(
      'pagination' => array(
        'page' => $this->page,
        'lastPage' => $this->lastPage,
        'total' => $this->total,
        'paging' => $paging,
        'next' => $next,
        'prev' => $prev,
        'data' => $this->data
      )
    );

  }

}

?>