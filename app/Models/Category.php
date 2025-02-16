<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
  protected $fillable=['name'];
    public function Event(){
        return $this->hasMany(Event::class);
    }
    public function canDelete(){
      return $this->event()->count() === 0;
    }
}
