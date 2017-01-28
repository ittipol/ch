<?php

namespace App\Models;

use App\library\string;
use Session;

class Shop extends Model
{
  protected $table = 'shops';
  protected $fillable = ['name','description','brand_story','created_by'];
  protected $modelRelated = array('Image','Address','Contact','OfficeHour');
  public $errorType;

  protected $behavior = array(
    'Slug' => array(
      'field' => 'name'
    ),
    // 'Lookup' => array(
    //   'format' =>  array(
    //     'keyword' => '{{name}}'
    //   )
    // )
  );

  protected $validation = array(
    'rules' => array(
      'name' => 'required|max:255',
      'Contact.phone_number' => 'required|regex:/^[\d-]*$/|min:10|max:255',
    ),
    'messages' => array(
      'name.required' => 'ชื่อแบรนด์ ร้านค้าหรือธุรกิจห้ามว่าง',
      'Contact.phone_number.numeric' => 'เบอร์โทรศัพท์ต้องเป็นตัวเลขเท่านั้น',
      'Contact.phone_number.min' => 'เบอร์โทรศัพท์ไม่ถูกต้อง',
      'Contact.phone_number.regex' => 'รูปแบบเบอร์โทรศัพท์ไม่ถูกต้อง',
      'Contact.phone_number.required' => 'เบอร์โทรศัพท์ห้ามว่าง',
    )
  ); 

  public function __construct() {  
    parent::__construct();
  }

  public static function boot() {

    parent::boot();

    Shop::saving(function($model){

      if($model->where([
          ['name','like',$model->name],
          ['created_by','=',Session::get('Person.id')]
        ])
        ->exists()) {
        $model->errorType = 1;
        return false;
      }elseif($model->where([
          ['name','like',$model->name],
        ])
        ->exists()) {
        $model->errorType = 2;
        return false;
      }

    });

    Shop::saved(function($model){

      if($model->state == 'create') {

        $role = new Role();

        $personToShop = new PersonToShop;
        $personToShop->saveSpecial(array(
          'shop_id' => $model->id,
          'person_id' => Session::get('Person.id'),
          'role_id' => $role->getIdByalias('admin')
        ));

      }

    });
  
  }

  public function getPermission($id = null) {

    if(empty($id)) {
      $id = $this->id;
    }

    $personToShop = new PersonToShop;
    $person = $personToShop->getData(array(
      'conditions' => array(
        ['person_id','=',session()->get('Person.id')],
        ['shop_id','=',$id],
      ),
      'fields' => array('role_id')
    ));

    $permission = array();
    if(!empty($person)) {
      $role = $person->role;
      $permission = array(
        'add' => $role->adding_permission,
        'edit' => $role->editing_permission,
        'delete' => $role->deleting_permission,
      );
    }

    return $permission;
  }

  public function buildModelData() {

    return array(
      'name' => $this->name,
      'description' => $this->description,
      '_short_description' => strip_tags(String::subString($this->description,500)),
      '_permission' => $this->getPermission(),
      '_logo' => '',
      '_cover' => '',
    );
  }

}
