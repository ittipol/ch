<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use Redirect;

class ItemController extends Controller
{
  public function __construct() { 
    parent::__construct();
  }

  public function listView() {

    $model = Service::loadModel('Item');
    
    $page = 1;
    if(!empty($this->query)) {
      $page = $this->query['page'];
    }

    $model->paginator->setPage($page);
    $model->paginator->setPagingUrl('item/list');
    $model->paginator->setUrl('item/detail/{id}','detailUrl');

    $this->setData($model->paginator->build());

    return $this->view('pages.item.list');
  }

  public function detail() {

    $model = Service::loadModel('Item')->find($this->param['id']);

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

    return $this->view('pages.item.detail');

  }

  public function post() {

    $model = Service::loadModel('Item');

    $model->form->loadFieldData('District',array(
      'conditions' => array(
        ['province_id','=',9]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'districts'
    ));

    $model->form->loadFieldData('ItemCategory',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'itemCategories'
    ));

    $model->form->loadFieldData('AnnouncementType',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'announcementTypes'
    ));

    $this->setData($model->form->build());
    $this->setData(array('defaultAnnouncementType' => 2));

    return $this->view('pages.item.form.item_post');
  }

  public function postingSubmit(CustomFormRequest $request) {

    $model = Service::loadModel('Item');

    if($model->fill($request->all())->save()) {
      Message::display('ลงประกาศเรียบร้อยแล้ว','success');
      return Redirect::to('item/detail/'.$model->id);
    }else{
      return Redirect::back();
    }

  }

  public function edit() {

    $model = Service::loadModel('Item')->find($this->param['id']);

    $model->form->loadFieldData('District',array(
      'conditions' => array(
        ['province_id','=',9]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'districts'
    ));

    $model->form->loadFieldData('ItemCategory',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'itemCategories'
    ));

    $model->form->loadFieldData('AnnouncementType',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'announcementTypes'
    ));

    $model->form->loadData(array(
      'json' => array('Image','Tagging')
    ));

    $this->setData($model->form->build());
    $this->setData(array(
      '_formData' => array(
        'ItemToCategory' => array(
          'item_category_id' => 1
        )
      )
    ));
// dd($this->data);
    return $this->view('pages.item.form.item_edit');

  }

  public function editingSubmit(CustomFormRequest $request) {

    $model = Service::loadModel('Item')->find($this->param['id']);

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
