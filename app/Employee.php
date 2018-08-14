<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed branch
 */
class Employee extends Model
{
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
