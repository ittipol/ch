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
    $this->model = Service::loadModel('RealEstate');
  }

  public function listView() {
    $page = 1;
    if(!empty($this->query)) {
      $page = $this->query['page'];
    }

    $this->paginator->setModel($this->model);
    $this->paginator->setPage($page);
    $this->paginator->setPagingUrl('real-estate/list');
    $this->paginator->setUrl('real-estate/detail','detailUrl');

    return $this->view('pages.real-estate.list');
  }

  public function detail($realEstateId) {

    $realEstate = $this->model->find($realEstateId);

    if(empty($realEstate)) {
      $this->error = array(
        'message' => 'ขออภัย ไม่พบประกาศนี้'
      );
      return $this->error();
    }

    $this->modelData->setModel($realEstate);
    $this->modelData->loadData(array(
      'json' => array('Image')
    ));

    return $this->view('pages.real-estate.detail');

  }

  public function post() { 

    $this->form->setModel($this->model);
    $this->form->loadFieldData('District',array(
      'conditions' => array(
        ['province_id','=',9]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'districts'
    ));
    $this->form->realEstateType();
    $this->form->announcementType();
    $this->form->loadFieldData('RealEstateFeature',array(
      'conditions' => array(
        ['real_estate_feature_type_id','=',1]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'feature'
    ));

    $this->form->loadFieldData('RealEstateFeature',array(
      'conditions' => array(
        ['real_estate_feature_type_id','=',2]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'facility'
    ));

    $this->data = array(
      'defaultAnnouncementType' => 2
    );

    return $this->view('pages.real-estate.form.real-estate_post');
  }

  public function submitPosting(CustomFormRequest $request) {
    if($this->model->fill($request->all())->save()) {
      Message::display('ลงประกาศเรียบร้อยแล้ว','success');
      return Redirect::to('real-estate/detail/'.$this->model->id);
    }else{
      return Redirect::back();
    }
  }
}
