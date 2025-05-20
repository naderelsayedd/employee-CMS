<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes ;
    protected $fillable = ['first_name', 'middle_name', 'last_name', 'address', 'zip_code', 'date_of_birth', 'date_hired', 'country_id', 'state_id', 'city_id', 'department_id'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
