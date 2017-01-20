<?php

namespace App\Models;

class Item extends Model
{
  protected $table = 'items';
  protected $fillable = ['name','description','price','announcement_type_id','used','created_by'];
  protected $modelRelated = array('Image','Address','Tagging','Contact');
  protected $directory = true;

  protected $validation = array(
    'rules' => array(
      'name' => 'required|max:255',
      'price' => 'required|max:255',
      'item_category_id' => 'required' 
    ),
    'messages' => array(
      'name.required' => 'ชื่อห้ามว่าง',
      'price.required' => 'จำนวนราคาห้ามว่าง',
      'item_category_id.required' => 'หมวดหมู่หลักสินค้าห้ามว่าง',
    )
  );

  public function __construct() {  
    parent::__construct();
  }

  public function announcementType() {
    return $this->hasOne('App\Models\AnnouncementType','id','announcement_type_id');
  }
}
