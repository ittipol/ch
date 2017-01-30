<?php

namespace App\Models;

class ShopToBranch extends Model
{
  public $table = 'shop_to_branchs';
  protected $fillable = ['shop_id','branch_id'];
  public $timestamps  = false;

  public function shop() {
    return $this->hasOne('App\Models\Shop','id','shop_id');
  }

  public function branch() {
    return $this->hasOne('App\Models\Branch','id','branch_id');
  }

  public function __saveRelatedData($model,$options = array()) {
    return $this->fill(array(
      'shop_id' => $options['value']['shop_id'],
      'branch_id' => $model->id
    ))->save();
  }
}
