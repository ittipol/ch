<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use App\library\url;
use Redirect;


class AdvertisingController extends Controller
{
  public function __construct() { 
    parent::__construct();
  }

  public function add() {

    $model = Service::loadModel('Advertising');

    $model->formHelper->loadFieldData('AdvertisingType',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'advertisingTypes'
    ));

    $model->formHelper->setData('branches',request()->get('shop')->getRelatedShopData('Branch'));

    $this->data = $model->formHelper->build();

    return $this->view('pages.advertising.form.advertising_post');
  }

  public function addingSubmit(CustomFormRequest $request) {

    $model = Service::loadModel('Advertising');

    $request->request->add(['ShopRelateTo' => array('shop_id' => request()->get('shop')->id)]);

    if($model->fill($request->all())->save()) {
      Message::display('ลงประกาศแล้ว','success');
      return Redirect::to('shop/'.$request->shopSlug.'/advertising');
    }else{
      return Redirect::back();
    }

  }

  public function edit() {

    $model = Service::loadModel('Advertising')->find($this->param['id']);

    if(empty($model)) {
      $this->error = array(
        'message' => 'ขออภัย ไม่สามารถแก้ไขข้อมูลนี้ได้ หรือข้อมูลนี้อาจถูกลบแล้ว'
      );
      return $this->error();
    }

    $model->formHelper->loadData(array(
      'models' => array('Image','Tagging'),
      'json' => array('Image','Tagging')
    ));

    $model->formHelper->loadFieldData('AdvertisingType',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'advertisingTypes'
    ));

    $relateToBranch = $model->getModelRelationData('RelateToBranch',array(
      'fields' => array('branch_id')
    ));

    $branches = array();
    if(!empty($relateToBranch)) {
      foreach ($relateToBranch as $value) {
        $branches['branch_id'][] = $value->branch->id;
      }
    }

    $model->formHelper->setFormData('RelateToBranch',$branches);

    $model->formHelper->setData('branches',request()->get('shop')->getRelatedShopData('Branch'));

    $this->data = $model->formHelper->build();

    return $this->view('pages.advertising.form.advertising_edit');
  }

  public function editingSubmit(CustomFormRequest $request) {

    $model = Service::loadModel('Advertising')->find($this->param['id']);

    if(empty($model)) {
      $this->error = array(
        'message' => 'ขออภัย ไม่สามารถแก้ไขข้อมูลนี้ได้ หรือข้อมูลนี้อาจถูกลบแล้ว'
      );
      return $this->error();
    }
dd($request->all());
    if($model->fill($request->all())->save()) {
      Message::display('ข้อมูลถูกบันทึกแล้ว','success');
      return Redirect::to('shop/'.request()->shopSlug.'/advertising');
    }else{
      return Redirect::back();
    }

  }

}
