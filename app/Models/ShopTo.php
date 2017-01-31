<?php

namespace App\Models;

class ShopTo extends Model
{
  public $table = 'shop_tos';
  protected $fillable = ['shop_id','model','model_id'];
  public $timestamps  = false;

  public function product() {
    return $this->hasOne('App\Models\Product','id','model_id');
  }

  public function branch() {
    return $this->hasOne('App\Models\Branch','id','model_id');
  }

  public function advertisement() {
    return $this->hasOne('App\Models\Advertisement','id','model_id');
  }

  public function __saveRelatedData($model,$options = array()) {
    return $this->fill(array(
      'shop_id' => $options['value']['shop_id'],
      'model' => $model->modelName,
      'model_id' => $model->id
    ))->save();
  }
}
