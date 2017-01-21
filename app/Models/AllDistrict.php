<?php

namespace App\Models;

class AllDistrict extends Model
{
  public $table = 'all_districts';
  protected $fillable = ['province_id','name','name_en','zip_code'];
  public $timestamps  = false;
}
