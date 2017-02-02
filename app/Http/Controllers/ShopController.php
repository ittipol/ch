<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use Redirect;

class ShopController extends Controller
{

  public function __construct() { 
    parent::__construct();

    // $this->middleware(function ($request, $next) {
    //   return $next($request);
    // });

    if(!empty($this->slug->model_id)) {
      $this->model = Service::loadModel('Shop')->find($this->slug->model_id);
    }else{
      $this->model = Service::loadModel('Shop');
    }
    
  }

  public function index() {

    $this->model->modelData->loadData();

    $this->setData($this->model->modelData->build());
    $this->setData(array(
      'shopUrl' => Service::url('shop/'.$this->param['slug'])
    ));

    return $this->view('pages.shop.main');
  }

  public function setting() {

  }

  public function product() {
    
    $page = 1;
    if(!empty($this->query)) {
      $page = $this->query['page'];
    }

    return $this->view('pages.shop.product');
  }

  public function job() {

    if(!$this->model->checkPersonInShop()){
      $this->error = array(
        'message' => 'คุณไม่มีสิทธิแก้ไขร้านค้านี้'
      );
      return $this->error();
    }

    $page = 1;
    if(!empty($this->query)) {
      $page = $this->query['page'];
    }

    $job = Service::loadModel('Job');
    $job->paginator->setPage($page);
    $job->paginator->setPagingUrl('shop/'.$this->param['slug'].'/job');
    $job->paginator->setUrl('shop/'.$this->param['slug'].'/job_edit/{id}','editUrl');
    $job->paginator->setUrl('job/detail/{id}','detailUrl');

    $this->setData($job->paginator->build());
    $this->setData(array(
      'shopUrl' => Service::url('shop/'.$this->param['slug'])
    ));

    return $this->view('pages.job.main');
  }

  public function advertisement() {

  }

  public function create() {

    $this->model->form->loadFieldData('District',array(
      'conditions' => array(
        ['province_id','=',9]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'districts'
    ));

    $this->setData($this->model->form->build());

    return $this->view('pages.shop.form.shop_create');
  }

  public function submitCreating(CustomFormRequest $request) {

    if($this->model->fill($request->all())->save()) {
      Message::display('บริษัทหรือร้านค้าของคุณถูกเพิ่มลงในชุมชนแล้ว','success');
      return Redirect::to('shop/'.$this->slug->name);
    }else{

      switch ($this->model->errorType) {
        case 1;
          $_message = 'คุณได้เพิ่มร้านค้าชื่อว่า '.$this->model->name.' ไปแล้ว โปรดใช้ชื่ออื่น';
          return Redirect::back()->withErrors([$_message]);
          break;

        case 2;
          $_message = 'มีร้านค้าชื่อ '.$this->model->name.' นี้แล้ว';
          return Redirect::back()->withErrors([$_message]);
          break;
      }

      return Redirect::back();
    }

  }
}
