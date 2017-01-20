<?php

namespace App\Models;

class Item extends Model
{
  protected $table = 'items';
  protected $fillable = ['name','description','announcement_type_id','used','created_by'];
}
