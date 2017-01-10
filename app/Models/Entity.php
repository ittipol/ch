<?php

namespace App\Models;

use Session;

class Entity extends Model
{
  protected $table = 'entities';
  protected $fillable = ['name','entity_type_id'];
  protected $modelRelated = array('Address','Contact');

  protected $behavior = array(
    'Slug' => array(
      'field' => 'name'
    ),
    // 'Wiki' => array(
    //   'format' =>  array(
    //     'subject' => '{{name}}',
    //     'description' => '{{description}}',
    //   )
    // ),
    'Lookup' => array(
      'format' =>  array(
        'keyword' => '{{name}}'
      )
    )
  );

  protected $validation = array(
    'rules' => array(
      'name' => 'required|max:255',
      'Contact.phone_number' => 'required|min:8',
      'Contact.email' => 'email',
    ),
    'messages' => array(
      'name.required' => 'ชื่อห้ามว่าง',
      'Contact.phone_number.required' => 'หมายเลขโทรศัพท์ห้ามว่าง',
      'Contact.phone_number.min' => 'หมายเลขโทรศัพท์ไม่ถูกต้อง',
      'Contact.email.email' => 'อีเมลไม่ถูกต้อง',
    ),
    'except' => array(
      'Contact.phone_number' => array(
        'entity_type_id' => 2
      )
    )
  );

  public static function boot() {

    parent::boot();

    Entity::saved(function($model){

      if($model->state == 'create') {

        $role = new Role();

        $personToEntity = new PersonToEntity;
        $personToEntity->saveSpecial(array(
          'entity_id' => $model->id,
          'person_id' => Session::get('Person.id'),
          'role_id' => $role->getIdByalias('admin')
        ));
      }

      $lookup = new Lookup;
      $lookup->__saveRelatedData($model);

    });
  }

  public function setUpdatedAt($value) {}
}
