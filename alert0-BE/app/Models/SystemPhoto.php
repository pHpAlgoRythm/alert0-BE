<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemPhoto extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $table = 'system_photo';

     protected $fillable = [
        'photo_name',
        'photo'
     ];

     public $timestamps = true;
}
