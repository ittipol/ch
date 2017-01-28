<?php

namespace App\Models;

class Shop extends Model
{
  protected $table = 'shops';
  protected $fillable = ['business_entity_id','name','brand_story','created_by'];
  protected $modelRelated = array('Image','Address','Contact');
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
            dd('aaaa');
    });

    Shop::saved(function($model){

      if($model->state == 'create') {
        // save person to shop
      }


    });
  }

}
