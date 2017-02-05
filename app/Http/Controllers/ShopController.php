<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
// use App\library\url;
use App\library\message;
use Redirect;

class ShopController extends Controller
{
// เพิ่มสิ่งที่ต้องการสื่อถึงลูกค้า

// วิธีส่งต้องกำหนดได้เอง
// ไม่เจอครัช ร้านเราใช้ขนส่งเอกชน Kerry Express มารับถึงหน้าบ้านเบย แพงหน่อยแต่บวกค่ารถค่าเวลาต่อแถวก็คุ้มกว่าครับ เอาเวลาไปทำอย่างอื่นได้ตั้งเยอะน้าาาาน้องตะกร้าาา ^_^

  public function __construct() { 
    parent::__construct();

    // $this->middleware(function ($request, $next) {
    //   return $next($request);
    // });
    
  }

  // public function index() {}

  public function manage() {

    $model = request()->get('shop');

    $model->modelData->loadData();

    $this->data = $model->modelData->build();
    $this->setData('shopUrl',request()->get('shopUrl'));

    return $this->view('pages.shop.main');
  }

  public function setting() {}

  // public function product() {
    
  //   $page = 1;
  //   if(!empty($this->query)) {
  //     $page = $this->query['page'];
  //   }

  //   return $this->view('pages.shop.product');
  // }

  public function job() {

    $model = request()->get('shop');

    $page = 1;
    if(!empty($this->query)) {
      $page = $this->query['page'];
    }

    $job = Service::loadModel('Job');
    $job->paginator->setPage($page);
    $job->paginator->setPagingUrl('shop/'.request()->slug.'/job');
    $job->paginator->setUrl('shop/'.$this->param['slug'].'/job_edit/{id}','editUrl');
    $job->paginator->setUrl('job/detail/{id}','detailUrl');
    $job->paginator->onlyMyData();

    $this->data = $job->paginator->build();
    $this->setData('shopUrl',request()->get('shopUrl'));

    return $this->view('pages.job.main');
  }

  public function advertisement() {

  }

  public function create() {

    $model = Service::loadModel('Shop');

    $model->form->loadFieldData('District',array(
      'conditions' => array(
        ['province_id','=',9]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'districts'
    ));

    $this->mergeData($model->form->build());

    return $this->view('pages.shop.form.shop_create');
  }

  public function creatingSubmit(CustomFormRequest $request) {

    $model = Service::loadModel('Shop');

    if($model->fill($request->all())->save()) {
      Message::display('บริษัทหรือร้านค้าของคุณถูกเพิ่มลงในชุมชนแล้ว','success');
      return Redirect::to('shop/'.request()->slug);
    }else{

      switch ($model->errorType) {
        case 1;
          $_message = 'คุณได้เพิ่มร้านค้าชื่อว่า '.$model->name.' ไปแล้ว โปรดใช้ชื่ออื่น';
          return Redirect::back()->withErrors([$_message]);
          break;

        case 2;
          $_message = 'มีร้านค้าชื่อ '.$model->name.' นี้แล้ว';
          return Redirect::back()->withErrors([$_message]);
          break;
      }

      return Redirect::back();
    }

  }
}
