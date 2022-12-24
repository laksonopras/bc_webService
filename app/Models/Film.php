<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Film extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;
    protected $primaryKey = 'id_film';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'judul', 'rating', 'storyline', 'poster', 'banner'

    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */

    public function jadwal(){
        return $this->hasMany(Jadwal::class, 'id_film');
    }
}
