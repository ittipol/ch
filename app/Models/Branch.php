<?php

namespace App\Models;

class Branch extends Model
{
  public $table = 'branchs';
  protected $fillable = ['name','description','created_by'];
  protected $modelRelated = array('Image','Address','Contact','ShopToBranch');
  protected $directory = true;

  public function __construct() {  
    parent::__construct();
  }

}

