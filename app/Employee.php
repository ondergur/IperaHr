<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    protected $guarded = ['_token'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
