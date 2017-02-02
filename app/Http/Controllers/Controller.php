<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\library\token;
use App\library\service;
use App\library\entity;
use App\library\form;
use App\library\modelData;
use App\library\paginator;
use Session;
use Route;
use Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $model;
    protected $slug;
    protected $data = array();
    protected $param;
    protected $query;
    protected $entity;
    protected $form;
    protected $modelData;
    protected $paginator;
    protected $error;

    public function __construct() { 

      $this->query = Request::query();
      $this->param = Route::current()->parameters();

      if(!empty($this->param['slug'])){
        $this->slug = service::loadModel('Slug')->getData(array(
          'conditions' => array(
            array('name','like',$this->param['slug'])
          ),
          'first' => true,
          'fields' => array('name','model','model_id')
        ));
      }

    }

    protected function error() {
      $data = array();

      if(!empty($this->error)) {
        $data['error'] = $this->error;
      }

      return view('errors.error',$data);
    }

    protected function setData($data = array()) {

      $this->data = array_merge($this->data,$data);

    }

    protected function view($view = null) {

      if(empty($view)) {
        $this->error = array(
          'message' => 'ขออภัย หน้านี้ไม่พร้อมใช้งาน'
        );
        return $this->error();
      }

    	return view($view,$this->data);
    }

}
