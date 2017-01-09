<?php

namespace App\Models;

class Entity extends Model
{
  protected $table = 'entities';
  protected $fillable = ['model','model_id','slug','entity_type_id'];
}
