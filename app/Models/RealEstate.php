<?php

namespace App\Models;

class RealEstate extends Model
{
  protected $table = 'real_estates';
  protected $fillable = ['announcement_type_id','real_estate_type_id','name','description','price','home_area','land_area','indoor','furniture','facility','feature','need_broker',];
  protected $modelRelated = array('Image','Address','Tagging','Contact');
  protected $directory = true;

  // protected $validation = array(
  //   'rules' => array(
  //     'name' => 'required|max:255',
  //     'price' => 'required|max:255',
  //     'Contact.phone_number' => 'required|max:255',
  //     // 'Contact.email' => 'email|unique:contacts,email|max:255',
  //     'ItemToCategory.item_category_id' => 'required' 
  //   ),
  //   'messages' => array(
  //     'name.required' => 'ชื่อห้ามว่าง',
  //     'price.required' => 'จำนวนราคาห้ามว่าง',
  //     'Contact.phone_number.required' => 'เบอร์โทรศัพท์ห้ามว่าง',
  //     'ItemToCategory.item_category_id.required' => 'หมวดหมู่หลักสินค้าห้ามว่าง',
  //   )
  // );

  public function __construct() {  
    parent::__construct();
  }

  public static function boot() {

    parent::boot();

    RealEstate::saving(function($model){
      $model->price = str_replace(',', '', $model->price);
      $model->feature = json_encode($model->feature);
      $model->facility = json_encode($model->facility);
      $model->home_area = json_encode($model->home_area);
      $model->land_area = json_encode($model->land_area);
      $model->indoor = json_encode($model->indoor);
    });

  }

  public function announcementType() {
    return $this->hasOne('App\Models\AnnouncementType','id','announcement_type_id');
  }

  public function realEstateType() {
    return $this->hasOne('App\Models\RealEstateType','id','real_estate_type_id');
  }

  public function buildModelData() {

    $facility = json_decode($this->facility,true);

    $facilities = array();
    if(!empty($facility)) {
      $facility = RealEstateFeature::whereIn('id',$facility)->get();
      $facilities = array();
      foreach ($facility as $value) {
        $facilities[] = array(
          'id' =>  $value->id,
          'name' =>  $value->name
        );
      }
    }

    $feature = json_decode($this->feature,true);

    $features = array();
    if(!empty($feature)) {
      $feature = RealEstateFeature::whereIn('id',$feature)->get();
      $features = array();
      foreach ($feature as $value) {
        $features[] = array(
          'id' =>  $value->id,
          'name' =>  $value->name
        );
      }
    }

    $homeArea = json_decode($this->home_area,true);

    $_homeArea = '-';
    if(!empty($homeArea['sqm'])) {
      $_homeArea = $homeArea['sqm'].' ตารางเมตร';
    }

    $landArea = json_decode($this->land_area,true);

    $_landArea = '-';
    if(!empty($landArea['sqm'])) {
      $_landArea .= $landArea['sqm'].' ตารางเมตร / ';
    }

    if(!empty($landArea['rai'])) {
      $_landArea .= $landArea['rai'].' ไร่ ';
    }

    if(!empty($landArea['ngan'])) {
      $_landArea .= $landArea['ngan'].' งาน ';
    }

    if(!empty($landArea['wa'])) {
      $_landArea .= $landArea['wa'].' ตารางวา ';
    }

    $furniture = '-';
    if(!empty($this->furniture)) { 

      switch ($this->furniture) {
        case 'e':
          $furniture = 'ไม่มี';
          break;
        
        case 's':
          $furniture = 'มีบางส่วน';
          break;

        case 'f':
          $furniture = 'ตกแต่งครบ';
          break;
      }

    }

    $indoor = json_decode($this->indoor,true);

    $rooms = array(
      'bedroom' => 'ห้องนอน',
      'bathroom' => 'ห้องน้ำ',
      'living_room' => 'ห้องนั่งเล่น',
      'home_office' => 'ห้องทำงาน',
      'floors' => 'จำนวนชั้น',
      'carpark' => 'ที่จอดรถ'
    );

    $_indoor = array();
    foreach ($indoor as $room => $value) {
      $_indoor[] = array(
        'room' => $room,
        'name' => $rooms[$room],
        'value' => $value
      );
    }

    return array(
      'id' => $this->id,
      'announcement_type_id' => $this->announcement_type_id,
      'real_estate_type_id' => $this->real_estate_type_id,
      'name' => $this->name,
      'description' => $this->description,
      'need_broker' => $this->need_broker,
      '_furniture' => $furniture,
      '_need_broker' => $this->need_broker ? 'ต้องการตัวแทนขาย' : 'ไม่ต้องการตัวแทนขาย',
      '_price' => '฿'.number_format($this->price, 0, '.', ','),
      '_homeArea' => $_homeArea,
      '_landArea' => trim($_landArea),
      '_indoors' => $_indoor,
      '_facilities' => $facilities,
      '_features' => $features,
      '_announcementTypeName' => $this->announcementType->name,
      '_realEstateTypeName' => $this->realEstateType->name
    );
  }

}
