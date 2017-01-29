<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use Redirect;

class BranchController extends Controller
{

  public function __construct() { 
    parent::__construct();

    if(!empty($this->param['slug'])){
      $this->slug = service::loadModel('Slug')->getData(array(
        'conditions' => array(
          array('name','like',$this->param['slug'])
        ),
        'first' => true,
        'fields' => array('name','model','model_id')
      ));
    }

    $this->model = Service::loadModel('Branch');
  }

  public function add() {

    if(!Service::loadModel('Shop')->checkPersonToShop($this->slug->model_id)){
      $this->error = array(
        'message' => 'คุณไม่มีสิทธิแก้ไขร้านค้านี้'
      );
      return $this->error();
    }

    $this->form->setModel($this->model);
    $this->form->loadFieldData('District',array(
      'conditions' => array(
        ['province_id','=',9]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'districts'
    ));

    return $this->view('pages.branch.form.branch_add');
  }

  public function submitAdding(CustomFormRequest $request) {

    if(!Service::loadModel('Shop')->checkPersonToShop($this->slug->model_id)){
      $this->error = array(
        'message' => 'คุณไม่มีสิทธิแก้ไขร้านค้านี้'
      );
      return $this->error();
    }

    $request->request->add(['ShopToBranch' => array('shop_id' => $this->slug->model_id)]);

    if($this->model->fill($request->all())->save()) {
      Message::display('สาขา '.$this->model->name.' ถูกเพิ่มแล้ว','success');
      return Redirect::to('shop/'.$this->slug->name.'/job');
    }else{
      return Redirect::back();
    }
  }

}
