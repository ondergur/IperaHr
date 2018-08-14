<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed company
 */
class Branch extends Model
{

    protected $guarded = ['_token'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
