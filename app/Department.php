<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    protected $guarded = ['_token'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
