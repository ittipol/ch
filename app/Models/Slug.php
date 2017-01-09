<?php

namespace App\Models;

use App\library\token;

class Slug extends Model
{
  public $table = 'slugs';
  protected $fillable = ['model','model_id','name'];

  // ** reserved word **
  // company
  // online-shop
  // job
  // ad
  // product

  public function __construct() {  
    parent::__construct();
  }

  public function __saveRelatedData($model,$options = array()) {

    if(empty($model->behavior['Slug']['field'])) {
      return false;
    }

    $options = array(
      'field' => $model->behavior['Slug']['field']
    );

    $save = true;

    do {
      $slug = $this->generateSlug($model,$options); 

      if(empty($slug)){
        $save = false;
      }

    } while ($this->checkDataExistBySlug($slug));

    if($save) {
      return $this->_save($model->includeModelAndModelId(array('name' => $slug)));
    }

    return $save;

  }

  private function generateSlug($model,$options = array()) {

    if(empty($options['field']) || empty($model->{$options['field']})){
      return false;
    }

    $slug = str_replace(' ', '-', trim($model->{$options['field']}));
    $slug .= '-'.$model->id;

    return $slug;

  }

  public function checkDataExistBySlug($slug) {
    return $this->where('name','like',$slug)->exists();
  }

  public function setUpdatedAt($value) {}

}
