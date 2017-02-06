<?php

namespace App\Models;

use App\library\date;

class PersonExperience extends Model
{
  protected $table = 'person_experiences';
  protected $fillable = ['person_id','name','gender','birth_date','private_websites','profile_image_id','active'];
  protected $modelRelations = array('Image','Address','Contact');
  protected $directory = true;
  
  public $imageTypes = array(
    'profile-image' => array(
      'limit' => 1
    )
  );

  protected $validation = array(
    'rules' => array(
      'name' => 'required|max:255',
    ),
    'messages' => array(
      'name.required' => 'ชื่อห้ามว่าง',
      'birth_date' => 'required|date_format:Y-m-d'
    )
  );

  public static function boot() {

    parent::boot();

    PersonExperience::saving(function($model){

      if(!empty($model->modelRelationData['Image']['profile-image']['image'])) {

        $image = new Image;
        $imageId = $image->addImage($model,$model->modelRelationData['Image']['profile-image']['image'],array(
          'type' => 'profile-image',
          'token' => $model->modelRelationData['Image']['profile-image']['token']
        ));

        if(!empty($imageId)) {
          $model->profile_image_id = $imageId;
        }
        
        unset($model->modelRelationData['Image']['profile-image']);
      }

    });

  }

  public function getByPersonId() {
    return $this->where('person_id','=',session()->get('Person.id'))->first();
  }

  public function checkExistByPersonId() {
    return $this->where('person_id','=',session()->get('Person.id'))->exists();
  }

//   protected function afterSave() {
// dd($this);
//     $imageType = new ImageType;

//     $profileImage = $this->getModelRelationData('Image',
//       array(
//         'conditions' => array(
//           array('image_type_id','=',$imageType->getIdByalias('profile-image'))
//         ),
//         'first' => true
//       )
//     );

//     $this->profile_image_id = $profileImage->id;
//     $this->save();

//     dd($profileImage->id);

//   }

  public function fill(array $attributes) {

    if(!empty($attributes)) {

      $websites = array();
      foreach ($attributes['private_websites'] as $value) {
        if(!empty($value)) {
          $websites[] = $value;
        }
      }

      $attributes['private_websites'] = '';
      if(!empty($websites)) {
        $attributes['private_websites'] = json_encode($websites);
      }
      
    }

    return parent::fill($attributes);

  }

  public function buildModelData() {

    $date = new Date;

    $gender = '-';
    if(!empty($this->gender)) {

    }

    $birthDate = '-';
    if(!empty($this->birth_date)) {
      $date->covertDateToSting($this->birth_date);
    }

    return array(
      'id' => $this->id,
      'name' => $this->name,
      'gender' => $gender,
      'birthDate' => $birthDate
    );

  }

  public function buildFormData() {
    
    list($year,$month,$day) = explode('-', $this->birth_date); 

    return array(
      'name' => $this->name,
      'gender' => $this->gender,
      'private_websites' => $this->private_websites,
      'birth_day' => $day,
      'birth_month' => $month,
      'birth_year' => $year,
    );

  }

}
