<?php

namespace App\Models;

class Product extends Model
{
  public $table = 'products';
  protected $fillable = ['name','description','sku','quantity','stock_status_id','price','weight','weight_id','length','length_id','width','height'];

  public $form = array(
    'title' => 'สินค้า',
    'template' => array(
      'add' => array(
        'textHeader' => 'เพิ่มบริษัทหรือร้านค้าของคุณ',
        'textButton' => 'เพิ่ม'
      ),
      'edit' => array(
        'textHeader' => 'แก้ไขบริษัทหรือร้านค้าของคุณ',
        'textButton' => 'แก้ไข'
      )
    ),
    'messages' => array(
      'add' => array(
        'success' => 'ร้านค้าหรือสถานประกอบการถูกเพิ่มเรียบร้อยแล้ว',
        'fail' => 'ไม่สามารถเพิ่มสถานประกอบการหรือร้านค้า กรุณาลองใหม่อีกครั้ง'
      ),
      'edit' => array(
        'success' => 'ร้านค้าหรือสถานประกอบการถูกแก้ไขเรียบร้อยแล้ว',
        'fail' => 'ไม่สามารถเพิ่มสถานประกอบการหรือร้านค้า กรุณาลองใหม่อีกครั้ง'
      )
    ),
    'fieldsExceptValidation' => array(
      'edit' => array(
        'name'
      )
    ),
    'requiredModelData' => array(
      'District' => array(
        'key' => 'id',
        'field' => 'name',
        'name' => 'districts'
      ),
      'BusinessEntity' => array(
        'key' => 'id',
        'field' => 'name',
        'name' => 'businessEntities'
      )
    )
  );

  public $validation = array(
    'rules' => array(
      'price' => 'required',
    ),
    'messages' => array(
      'price.required' => 'กรุณากรอกชื่อบริษัทหรือร้านค้าของคุณ',
    ),
    // 'except' => array(
    //   'price' => array('add')
    // )
  );
  
  public function __construct() {  
    parent::__construct();
  }
}
