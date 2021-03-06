<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'description',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'roles_id'
    ];

    public $primaryKey = 'name';
    public $incrementing = false;

    public function roles()
    {
        return $this->belongsTo(Roles::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class)
            ->withPivot('rating', 'review', 'favorite')
            ->withTimestamps();
    }

    public function getFriends()
    {
        return $friendship = DB::table('friends')
            ->select('*')
            ->where('nameSecond', Auth::user()->name)
            ->orWhere('nameFirst', Auth::user()->name)
            ->get();
    }

}
