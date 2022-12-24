<?php

namespace App\Models;

use App\Models\Kelas as ModelsKelas;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Kelas extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;
    protected $primaryKey = 'id_kelas';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nama_kelas', 'harga'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    // protected $hidden = [
    //     'password',
    // ];

    public function studio(){
        return $this->hasMany(Studio::class, 'id_kelas');
    }
}
