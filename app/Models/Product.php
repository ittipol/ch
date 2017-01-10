<?php

namespace App\Models;

class Product extends Model
{
  protected $table = 'products';
  protected $fillable = ['name','description','sku','quantity','stock_status_id','price','weight','weight_id','length','length_id','width','height'];
  protected $modelRelated = array('Image','Address');

  protected $validation = array(
    'rules' => array(
      'name' => 'required|max:255',
      'price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
    ),
    'messages' => array(
      'name.required' => 'ชื่อห้ามว่าง',
      'price.required' => 'จำนวนราคาห้ามว่าง',
      'price.regex' => 'จำนวนราคาไม่ถูกต้อง',
    )
  );
  
  public function __construct() {  
    parent::__construct();
  }
}
