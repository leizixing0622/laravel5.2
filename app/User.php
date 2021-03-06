<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function organizations() {
    	return $this->belongsToMany('App\Organization')->withTimestamps();
    }
    public function roles() {
    	return $this->belongsToMany('App\Role')->withTimestamps();
    }
    public function avatar(){
        return $this->hasOne('App\File', 'user_id', 'id');
    }
}
