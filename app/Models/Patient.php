<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function user(){

        return $this->belongsTo('App\Models\User');
    }
}
