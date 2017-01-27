<?php 

namespace App\library;

class Paginator {

  private $total;
  private $page = 1;
  private $lastPage;
  private $perPage = 15;
  private $url;
  private $nextPageUrl;
  private $prevPageUrl;
  private $data = array();

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

    // if(substr($url, -1) != '/') {
    //   $url .= '/';
    // }

    $this->url = $url;

  }

  public function setDataUrl($url) {

  }

  public function build() {

    if(empty($this->model)) {
      return false;
    }

    $currency = new Currency;
    $imageStyle = Service::loadModel('ImageStyle');

    $this->total = $this->model->all()->count();
    $this->lastPage = (int)ceil($this->total / $this->perPage);
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
        '_name_short' => String::subString($record->name,70),
        'description' => $record->description,
        '_price' => $currency->format($record->price),
        '_imageUrl' => $imageUrl,
        // '_totalImage' => 0,
      );

    }

    $paging = array();
    $pagingUrl = $this->url.'?page={n}';

    // if($this->page > 3) {
    //   $paging[] = array(
    //     'pageNumber' => 1,
    //     'url' => str_replace('{n}', 1, $pagingUrl)
    //   );

    //   $paging[] = array(
    //     'pageNumber' => '...',
    //     'url' => null
    //   );
    // }


    // if($this->page < ($this->lastPage - 3)) {
    //   $paging[] = array(
    //     'pageNumber' => '...',
    //     'url' => null
    //   );

    //   $paging[] = array(
    //     'pageNumber' => $this->lastPage,
    //     'url' => str_replace('{n}', $this->lastPage, $pagingUrl)
    //   );
    // }

    if(($this->page >= 1) && ($this->page <= $this->lastPage)) {
  dd('xzz');
      if(($this->page - 5) < 1){

        for ($i=1; $i < 6; $i++) { 
          var_dump($i);

          if($this->page == $i) {
            // selected
          }

        }

      }elseif(($this->page + 5) > $this->lastPage) {

        for ($i=4; $i >= 0; $i--) { 
          var_dump($this->lastPage-$i);
        }

      }else{
  dd('xxx');
      }

    }

    

    dd($paging);

    // foreach ($paging as $key => $value) {
    //   if($value['pageNumber'] == $this->page) {
    //     $paging[$key] = array_merge($paging[$key],array(
    //       'selected' => true
    //     ));
    //   }
    // }

    // $paging['prev'] = array(
    //   'pageNumber' => 'ก่อนหน้า',
    //   'url' => str_replace('{n}', $this->page-1, $pagingUrl)
    // )

    // $paging['prev']['url'] = str_replace('{n}', $this->page-1, $pagingUrl);
    // if(($this->page - 1) < 1) {
    //   $paging['prev']['url'] = null;
    // }

    // $paging['next']['url'] = str_replace('{n}', $this->page+1, $pagingUrl);
    // if(($this->page + 1) > $this->lastPage) {
    //   $paging['next']['url'] = null;
    // }

    return array(
      'pagination' => array(
        'page' => $this->page,
        'lastPage' => $this->lastPage,
        'total' => $this->total,
        // 'url' => $this->url.'?page={n}',
        'paging' => $paging,
        'data' => $this->data
      )
    );

  }

}

?>