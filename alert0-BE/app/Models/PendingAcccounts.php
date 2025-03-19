<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendingAcccounts extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'gender',
        'role',
        'status',
        'phone',
        'verification_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

     protected $hidden = [
        'password'
     ];

     protected function verificationUrl()
     {
        return Attribute::get(fn () => $this->verification_id
            ? asset('storage/' . $this->verification_id)
            : asset('default-avatar.png'));
     }

}
