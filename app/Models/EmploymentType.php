<?php

namespace App\Models;

class EmploymentType extends Model
{
  public $table = 'employment_types';
  protected $fillable = ['name'];

  public function __construct() {  
    parent::__construct();
  }
}
