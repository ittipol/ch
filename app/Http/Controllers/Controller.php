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

      $this->form = new Form();
      $this->modelData = new ModelData();
      $this->paginator = new Paginator();

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

    protected function view($view = null) {

      if(empty($view)) {
        $this->error = array(
          'message' => 'ขออภัย หน้านี้ไม่พร้อมใช้งาน'
        );
        return $this->error();
      }

      if(!empty($this->entity)) {
        $this->data['entity'] = $this->entity;
      }

      $form = $this->form->build();
      if(!empty($form)){
        $this->data = array_merge($this->data,$form);
      }

      $modelData = $this->modelData->build();
      if(!empty($modelData)){
        $this->data = array_merge($this->data,$modelData);
      }

      $pagination = $this->paginator->build();
      if(!empty($pagination)){
        $this->data = array_merge($this->data,$pagination);
      }
dd($this->data);
    	return view($view,$this->data);
    }

}
