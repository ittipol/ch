<?php

namespace App\Models;

class Branch extends Model
{
  public $table = 'branches';
  protected $fillable = ['name','description','created_by'];
  protected $modelRelated = array('Image','Address','Contact','ShopTo');
  protected $directory = true;

  protected $validation = array(
    'rules' => array(
      'name' => 'required|max:255',
    ),
    'messages' => array(
      'name.required' => 'ชื่อสาขาห้ามว่าง',
    )
  ); 

  public function __construct() {  
    parent::__construct();
  }

  public function buildModelData() {
    return array(
      'name' => $this->name,
    );
  }

}

