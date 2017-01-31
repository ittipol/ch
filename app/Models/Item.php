<?php

namespace App\Models;

use App\library\currency;

class Item extends Model
{
  protected $table = 'items';
  protected $fillable = ['name','announcement_detail','description','price','announcement_type_id','used','created_by'];
  protected $modelRelated = array('Image','Address','Tagging','Contact','ItemToCategory');
  protected $directory = true;

  protected $validation = array(
    'rules' => array(
      'name' => 'required|max:255',
      // 'price' => 'required|regex:/^[\d,]*(\.\d{1,2})?$/|max:255',
      'price' => 'required|regex:/^[0-9,]*(\.[0-9]{1,2})?$/|max:255',
      'Contact.phone_number' => 'required|max:255',
      // 'Contact.email' => 'email|unique:contacts,email|max:255',
      'ItemToCategory.item_category_id' => 'required' 
    ),
    'messages' => array(
      'name.required' => 'ชื่อห้ามว่าง',
      'price.required' => 'จำนวนราคาห้ามว่าง',
      'price.regex' => 'รูปแบบจำนวนราคาไม่ถูกต้อง',
      'Contact.phone_number.required' => 'เบอร์โทรศัพท์ห้ามว่าง',
      'ItemToCategory.item_category_id.required' => 'หมวดหมู่หลักสินค้าห้ามว่าง',
    )
  ); 

  public function __construct() {  
    parent::__construct();
  }

  public function announcementType() {
    return $this->hasOne('App\Models\AnnouncementType','id','announcement_type_id');
  }

  public function itemToCategories() {
    return $this->hasOne('App\Models\ItemToCategory','item_id','id');
  }

  public function fill(array $attributes) {

    if(!empty($attributes)) {
      $attributes['price'] = str_replace(',', '', $attributes['price']);
    }

    return parent::fill($attributes);

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
