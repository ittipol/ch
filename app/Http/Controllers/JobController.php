<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use App\library\url;
use Redirect;

class JobController extends Controller
{
  public function __construct() { 
    parent::__construct();
  }

  public function detail() {

    $model = Service::loadModel('Job')->find($this->param['id']);

    if(empty($model)) {
      $this->error = array(
        'message' => 'ขออภัย ไม่พบประกาศนี้'
      );
      return $this->error();
    }

    $model->modelData->loadData(array(
      'models' => array('Image','Tagging'),
      'json' => array('Image')
    ));

    $this->setData($model->modelData->build());

    // Get Shop Address
    $shop = $model->getRalatedModelData('ShopTo',array(
      'first' => true,
    ))->shop;

    // Get Slug
    $slugName = $shop->getRalatedModelData('Slug',array(
      'first' => true,
    ))->name;

    // Get Branches
    $branchIds = $model->getRalatedData('JobToBranch',array(
      'list' => 'branch_id',
      'fields' => array('branch_id'),
    ));

    $branches = Service::loadModel('Branch')->whereIn('id',$branchIds)->get();
    
    $url = new Url;
    $url->setUrl('shop/'.$slugName.'/branch_detail/{id}','detailUrl');

    $branchLocations = array();
    $hasBranchLocation = false;
    foreach ($branches as $branch) {

      $address = $branch->modelData->loadAddress();

      if(!empty($address)){

        $hasBranchLocation = true;

        $graphics = json_decode($address['_geographic'],true);
        $branchLocations[] = array_merge(array(
          'id' => $branch->id,
          'address' => $branch->name,
          'latitude' => $graphics['latitude'],
          'longitude' => $graphics['longitude']
        ),$url->parseUrl($branch->getAttributes())); 
      }
    }

    $this->setData(array(
      'shopAddress' => $shop->modelData->loadAddress(),
      'branchLocations' => json_encode($branchLocations),
      'hasBranchLocation' => $hasBranchLocation
    ));

    return $this->view('pages.job.detail');

  }

  public function add() {

    if(!Service::loadModel('Shop')->checkPersonInShop($this->slug->model_id)){
      $this->error = array(
        'message' => 'คุณไม่มีสิทธิแก้ไขร้านค้านี้'
      );
      return $this->error();
    }

    $model = Service::loadModel('Job');

    $model->form->loadFieldData('EmploymentType',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'employmentTypes'
    ));
    $model->form->shopTo(array(
      'shopId' => $this->slug->model_id,
      'model' => 'Branch'
    ));

    $this->setData($model->form->build());

    return $this->view('pages.job.form.job_add');
  }

  public function addingSubmit(CustomFormRequest $request) {

    if(!Service::loadModel('Shop')->checkPersonInShop($this->slug->model_id)){
      $this->error = array(
        'message' => 'คุณไม่มีสิทธิแก้ไขร้านค้านี้'
      );
      return $this->error();
    }

    $model = Service::loadModel('Job');

    $request->request->add(['ShopTo' => array('shop_id' => $this->slug->model_id)]);

    if($model->fill($request->all())->save()) {
      Message::display('ลงประกาศงานแล้ว','success');
      return Redirect::to('shop/'.$this->slug->name.'/job');
    }else{
      return Redirect::back();
    }

  }

  public function edit() {

    if(!Service::loadModel('Shop')->checkPersonInShop($this->slug->model_id)){
      $this->error = array(
        'message' => 'คุณไม่มีสิทธิแก้ไขร้านค้านี้'
      );
      return $this->error();
    }

    $model = Service::loadModel('Job')->find($this->param['id']);

    if(empty($model)) {
      $this->error = array(
        'message' => 'ไม่พบประกาศขายนี้'
      );
      return $this->error();
    }
    
    $model->form->loadData();
    $model->form->loadFieldData('EmploymentType',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'employmentTypes'
    ));
    $model->form->shopTo(array(
      'shopId' => $this->slug->model_id,
      'model' => 'Branch'
    ));

    $this->setData($model->form->build());

    return $this->view('pages.job.form.job_edit');
  }

  public function editingSubmit(CustomFormRequest $request) {

    $model = Service::loadModel('Job')->find($this->param['id']);

    if($model->fill($request->all())->save()) {
      Message::display('ข้อมูลถูกบันทึกแล้ว','success');
      return Redirect::to('shop/'.$this->slug->name.'/job');
    }else{
      return Redirect::back();
    }

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
