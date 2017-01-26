<?php

namespace App\Models;

use App\library\currency;

class Item extends Model
{
  protected $table = 'items';
  protected $fillable = ['name','announcement_detail','description','price','announcement_type_id','used','created_by'];
  protected $modelRelated = array('Image','Address','Tagging','Contact','ItemToCategory');
  protected $directory = true;
  protected $imageCache = array('xs','md');

  protected $validation = array(
    'rules' => array(
      'name' => 'required|max:255',
      'price' => 'required|max:255',
      'Contact.phone_number' => 'required|max:255',
      // 'Contact.email' => 'email|unique:contacts,email|max:255',
      'ItemToCategory.item_category_id' => 'required' 
    ),
    'messages' => array(
      'name.required' => 'ชื่อห้ามว่าง',
      'price.required' => 'จำนวนราคาห้ามว่าง',
      'Contact.phone_number.required' => 'เบอร์โทรศัพท์ห้ามว่าง',
      'ItemToCategory.item_category_id.required' => 'หมวดหมู่หลักสินค้าห้ามว่าง',
    )
  ); 

  public function __construct() {  
    parent::__construct();
  }

  public static function boot() {

    parent::boot();

    Item::saving(function($model){
      $model->price = str_replace(',', '', $model->price);
    });

  }

  public function announcementType() {
    return $this->hasOne('App\Models\AnnouncementType','id','announcement_type_id');
  }

  public function itemToCategories() {
    return $this->hasOne('App\Models\ItemToCategory','item_id','id');
  }

  public function buildModelData() {

    $currency = new Currency;

    return array(
      'id' => $this->id,
      'announcement_type_id' => $this->announcement_type_id,
      'name' => $this->name,
      'description' => $this->description,
      '_price' => $currency->format($this->price),
      '_used' => $this->used ? 'สินค้าใหม่' : 'สินค้ามือสอง',
      '_announcementTypeName' => $this->announcementType->name,
      '_categoryName' => $this->itemToCategories->category->name
    );

  }

}
