<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    public $timestamps = false;
    protected $primaryKey = "DoctorId";
}
