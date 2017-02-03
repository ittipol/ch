<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use Redirect;

class RealEstateController extends Controller
{
  public function __construct() { 
    parent::__construct();
  }

  public function listView() {

    $model = Service::loadModel('RealEstate');

    $page = 1;
    if(!empty($this->query)) {
      $page = $this->query['page'];
    }

    $model->paginator->setPage($page);
    $model->paginator->setPagingUrl('real-estate/list');
    $model->paginator->setUrl('real-estate/detail/{id}','detailUrl');

    $this->setData($model->paginator->build());

    return $this->view('pages.real_estate.list');
  }

  public function detail() {

    $model = Service::loadModel('RealEstate')->find($this->param['id']);

    if(empty($model)) {
      $this->error = array(
        'message' => 'ขออภัย ไม่พบประกาศนี้'
      );
      return $this->error();
    }

    $model->modelData->loadData(array(
      'json' => array('Image')
    ));

    $this->setData($model->modelData->build());

    return $this->view('pages.real_estate.detail');

  }

  public function post() { 

    $model = Service::loadModel('RealEstate');

    $model->form->loadFieldData('District',array(
      'conditions' => array(
        ['province_id','=',9]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'districts'
    ));

    $model->form->loadFieldData('RealEstateType',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'realEstateTypes'
    ));

    $model->form->loadFieldData('AnnouncementType',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'announcementTypes'
    ));

    $model->form->loadFieldData('RealEstateFeature',array(
      'conditions' => array(
        ['real_estate_feature_type_id','=',1]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'feature'
    ));

    $model->form->loadFieldData('RealEstateFeature',array(
      'conditions' => array(
        ['real_estate_feature_type_id','=',2]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'facility'
    ));

    $this->setData($model->form->build());
    $this->setData(array('defaultAnnouncementType' => 2));

    return $this->view('pages.real_estate.form.real_estate_post');
  }

  public function postingSubmit(CustomFormRequest $request) {

    $model = Service::loadModel('RealEstate');

    if($model->fill($request->all())->save()) {
      Message::display('ลงประกาศเรียบร้อยแล้ว','success');
      return Redirect::to('real-estate/detail/'.$model->id);
    }else{
      return Redirect::back();
    }
  }

  public function edit() {

    $model = Service::loadModel('RealEstate')->find($this->param['id']);

    if(empty($model)) {
      $this->error = array(
        'message' => 'ไม่พบประกาศขายนี้'
      );
      return $this->error();
    }

    $model->form->loadFieldData('District',array(
      'conditions' => array(
        ['province_id','=',9]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'districts'
    ));

    $model->form->loadFieldData('RealEstateType',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'realEstateTypes'
    ));

    $model->form->loadFieldData('AnnouncementType',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'announcementTypes'
    ));

    $model->form->loadFieldData('RealEstateFeature',array(
      'conditions' => array(
        ['real_estate_feature_type_id','=',1]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'feature'
    ));

    $model->form->loadFieldData('RealEstateFeature',array(
      'conditions' => array(
        ['real_estate_feature_type_id','=',2]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'facility'
    ));

    $model->form->loadData(array(
      'json' => array('Image','Tagging')
    ));

    $this->setData($model->form->build());

    return $this->view('pages.real_estate.form.real_estate_edit');

  }

  public function editingSubmit(CustomFormRequest $request) {

    $model = Service::loadModel('RealEstate')->find($this->param['id']);

    if(empty($model)) {
      $this->error = array(
        'message' => 'ไม่พบประกาศขายนี้'
      );
      return $this->error();
    }

    if($model->fill($request->all())->save()) {
      Message::display('ข้อมูลถูกบันทึกแล้ว','success');
      return Redirect::to('real-estate/detail/'.$model->id);
    }else{
      return Redirect::back();
    }
    
  }

}
