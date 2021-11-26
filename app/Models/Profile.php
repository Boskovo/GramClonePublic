<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $guarded = [];


    public function ProfileImage() {

        $ImagePath =  ($this->image) ? '/storage/' . $this->image : 'https://i.pinimg.com/474x/65/25/a0/6525a08f1df98a2e3a545fe2ace4be47.jpg';

        return  $ImagePath;
    }

    public function followers() {
        return $this->belongsToMany(User::class);
    }


    public function user() {
        
        return $this->belongsTo(User::class);
    }

    use HasFactory;
}
