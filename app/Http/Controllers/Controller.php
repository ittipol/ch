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
use Session;
use Route;
use Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $ident;
    protected $formToken;
    protected $model;
    protected $data = array();
    protected $param;
    protected $query;
    protected $entity;
    protected $form;
    protected $error;

    public function __construct() { 

      $this->form = new Form();
      $this->query = Request::query();

      $this->middleware(function ($request, $next) {

        $this->param = Route::current()->parameters();

        if(!empty($this->param['entity_slug'])) {

          $slug = service::loadModel('Slug')->getData(array(
            'conditions' => array(
              array('name','like',$this->param['entity_slug'])
            ),
            'first' => true,
            'fields' => array('name','model','model_id')
          ));

          if(empty($slug)) {
            return response()->view('messages.message');
          }

          $entity = new Entity($slug);
          $this->entity = $entity->buildData();
        }

      //   if(!empty($this->param['modelAlias'])) {

      //     $model = service::loadModel(service::generateModelNameByModelAlias($this->param['modelAlias']));

      //     if(empty($model)) {
      //       // Go to display error page
      //       return response()->view('messages.message');
      //     }

      //     $this->model = $model;
      //   }

        return $next($request);
      });

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

      if(!empty($this->form->build())){
        $this->data = array_merge($this->data,$this->form->build());
      }
// dd($this->data['formData']);
    	return view($view,$this->data);
    }

}
