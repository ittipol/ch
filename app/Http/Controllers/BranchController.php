<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use App\library\url;
use Redirect;

class BranchController extends Controller
{

  public function __construct() { 
    parent::__construct();
  }

  public function detail() {

    $model = Service::loadModel('Branch')->find($this->param['id']);

    if(empty($model)) {
      $this->error = array(
        'message' => 'ขออภัย ไม่พบประกาศนี้ หรือข้อมูลนี้อาจถูกลบแล้ว'
      );
      return $this->error();
    }

    $model->modelData->loadData(array(
      'models' => array('Image','Address','Contact'),
      'json' => array('Image')
    ));

    // Get Branches
    $jobIds = $model->getRalatedData('JobToBranch',array(
      'list' => 'job_id',
      'fields' => array('job_id'),
    ));

    $jobs = Service::loadModel('Job');
    $jobs->paginator->setPerPage(12);
    $jobs->paginator->setUrl('job/detail/{id}','detailUrl');
    $jobs->paginator->criteria(array(
      'conditions' => array(
        'in' => array(
          array('id',$jobIds)
        )
      ),
      'order' => array('id','DESC')
    ));

    $this->data = $model->modelData->build();
    $this->setData('jobs',$jobs->paginator->getModelData());

    return $this->view('pages.branch.detail');

  }

  public function add() {

    $model = Service::loadModel('Branch');

    $model->formHelper->loadFieldData('District',array(
      'conditions' => array(
        ['province_id','=',9]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'districts'
    ));

    $this->data = $model->formHelper->build();

    return $this->view('pages.branch.form.branch_add');
  }

  public function addingSubmit(CustomFormRequest $request) {

    $model = Service::loadModel('Branch');

    $request->request->add(['ShopTo' => array('shop_id' => $this->slug->model_id)]);

    if($model->fill($request->all())->save()) {
      Message::display('สาขา '.$model->name.' ถูกเพิ่มแล้ว','success');
      return Redirect::to(route('shop.branch.detail', ['slug' => $this->slug->slug,'id' => 1]));
    }else{
      return Redirect::back();
    }
  }

  public function edit() {

    $model = Service::loadModel('Branch')->find($this->param['id']);

    if(empty($model) || ($model->person_id != session()->get('Person.id'))) {
      $this->error = array(
        'message' => 'ขออภัย ไม่สามารถแก้ไขข้อมูลนี้ได้ หรือข้อมูลนี้อาจถูกลบแล้ว'
      );
      return $this->error();
    }

    $model->formHelper->loadFieldData('District',array(
      'conditions' => array(
        ['province_id','=',9]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'districts'
    ));

    $model->formHelper->loadData(array(
      'json' => array('Image')
    ));

    $this->data = $model->formHelper->build();

    return $this->view('pages.branch.form.branch_edit');

  }

  public function editingSubmit(CustomFormRequest $request) {

    $model = Service::loadModel('Branch')->find($this->param['id']);

    if(empty($model) || ($model->person_id != session()->get('Person.id'))) {
      $this->error = array(
        'message' => 'ขออภัย ไม่สามารถแก้ไขข้อมูลนี้ได้ หรือข้อมูลนี้อาจถูกลบแล้ว'
      );
      return $this->error();
    }

    if($model->fill($request->all())->save()) {

      Message::display('ข้อมูลถูกบันทึกแล้ว','success');
      return Redirect::to(route('shop.branch.detail', ['slug' => $this->slug->slug,'id' => $model->id]));
    }else{
      return Redirect::back();
    }
    
  }

}
