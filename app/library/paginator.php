<?php 

namespace App\library;

use Session;

class Paginator {

  private $total;
  private $page = 1;
  private $lastPage;
  private $perPage = 24;
  private $pagingUrl;
  private $urls = array();
  public $error = false;

  public function __construct($model = null) {
    $this->model = $model;
  }

  // public function setModel($model = null) {
  //   $this->model = $model;
  // }

  public function setPerPage($perPage) {
    $this->perPage = (int)$perPage;
  }

  public function setPage($page) {
    $this->page = (int)$page;
  }

  public function setPagingUrl($url) {
    $this->pagingUrl = url($url);
  }

  public function setUrl($url,$index) {

    preg_match_all('/{[\w0-9]+}/', $url, $matches);

    $this->urls[$index] = array(
      'url' => url($url),
      'pattern' => $matches[0]
    );
  }

  public function parseUrl($record) {
    $urls = array();

    foreach ($this->urls as $index => $url) {

      foreach ($url['pattern'] as $pattern) {
    
        $field = substr($pattern, 1,-1);

        if(!empty($record[$field])) {
          $url['url'] = str_replace($pattern, $record[$field], $url['url']);
        }

      }

      $urls[$index] = $url['url'];

    }

    return $urls;
  }

  public function getModelData() {

    $offset = ($this->page - 1)  * $this->perPage;

    // $start = $offset + 1;
    // $end = min(($offset + $this->perPage), $this->total);

    $records = $this->model
    ->where('created_by','=',Session::get('Person.id'))
    ->take($this->perPage)
    ->skip($offset)
    ->get();

    $data = array();
    foreach ($records as $record) {
      $data[] = array_merge($record->paginationData(),$this->parseUrl($record->getAttributes()));
    }

    return $data;

  }

  public function next() {

    $pagingUrl = $this->pagingUrl.'?page={n}';
    
    $next['url'] = str_replace('{n}', $this->page+1, $pagingUrl);
    if(($this->page + 1) > $this->lastPage) {
      $next['url'] = null;
    }

    return $next;
  }

  public function prev() {

    $pagingUrl = $this->pagingUrl.'?page={n}';

    $prev['url'] = str_replace('{n}', $this->page-1, $pagingUrl);
    if(($this->page - 1) < 1) {
      $prev['url'] = null;
    }

    return $prev;
  }

  public function paging() {

    $paging = array();
    $pagingUrl = $this->pagingUrl.'?page={n}';

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

    return $paging;

  }

  public function build() {

    if(empty($this->model)) {
      return false;
    }

    $this->total = $this->model->count();
    $this->lastPage = (int)ceil($this->total / $this->perPage);

    // if(($this->page < 1) || ($this->page > $this->lastPage)) {
    //   $this->error = true;
    //   return false;
    // }

    return array(
      '_pagination' => array(
        'page' => $this->page,
        'lastPage' => $this->lastPage,
        'total' => $this->total,
        'paging' => $this->paging(),
        'next' => $this->next(),
        'prev' => $this->prev(),
        'data' => $this->getModelData()
      )
    );

  }

}

?>