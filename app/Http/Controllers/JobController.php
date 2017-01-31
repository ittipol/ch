<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use Redirect;

class JobController extends Controller
{
  public function __construct() { 
    parent::__construct();
    $this->model = Service::loadModel('Job');
  }

  public function add() {

    if(!Service::loadModel('Shop')->checkPersonToShop($this->slug->model_id)){
      $this->error = array(
        'message' => 'คุณไม่มีสิทธิแก้ไขร้านค้านี้'
      );
      return $this->error();
    }

    $this->form->setModel($this->model);
    $this->form->employmentType();
    $this->form->shopTo(array(
      'shopId' => $this->slug->model_id,
      'model' => 'Branch'
    ));

    return $this->view('pages.job.form.job_post');
  }

  public function submitAdding(CustomFormRequest $request) {

    if(!Service::loadModel('Shop')->checkPersonToShop($this->slug->model_id)){
      $this->error = array(
        'message' => 'คุณไม่มีสิทธิแก้ไขร้านค้านี้'
      );
      return $this->error();
    }

    if($this->model->fill($request->all())->save()) {
      Message::display('ลงประกาศงานแล้ว','success');
      return Redirect::to('shop/'.$this->slug->name.'/job');
    }else{
      return Redirect::back();
    }

  }

  public function edit() {

    if(!Service::loadModel('Shop')->checkPersonToShop($this->slug->model_id)){
      $this->error = array(
        'message' => 'คุณไม่มีสิทธิแก้ไขร้านค้านี้'
      );
      return $this->error();
    }

    $model = $this->model->find($this->param['job_id']);

    if(empty($model)) {
      $this->error = array(
        'message' => 'ไม่พบประกาศขายนี้'
      );
      return $this->error();
    }

    $this->modelData->setModel($model);
    $this->modelData->loadData();
    
    $this->form->setModel($model);
    $this->form->employmentType();
    $this->form->shopTo(array(
      'shopId' => $this->slug->model_id,
      'model' => 'Branch'
    ));

    return $this->view('pages.job.form.job_post');
  }

  // public function addCat() {
  //   exit('!!!');
  //       $data = array(
  //   'โต๊ะรีดผ้า',
  //   'ตะกร้าผ้า',
  //   'จักรเย็บผ้าและอุปกรณ์',
  //   'อุปกรณ์ดับกลิ่นผ้า'
  //       );

  //       $parentId = 927;

  //       foreach ($data as $value) {

  //         $_value = array(
  //           'name' => $value
  //         );

  //         if(!empty($parentId)) {
  //           $_value = array(
  //             'parent_id' => $parentId,
  //             'name' => $value
  //           );
  //         }

  //         Service::loadModel('Category')->newInstance()->fill($_value)->save();
  //       }
  //       dd('saved');

  // }
}
