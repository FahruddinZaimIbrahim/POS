<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use illuminate\Database\Eloquent\Casts\Attribute;

//class UserModel extends Model implements AuthenticatableContract
class UserModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    //use HasFactory, Authenticatable; 

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = ['level_id', 'username', 'nama', 'password','image'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id','level_id');
    }
    protected function image(): Attribute{
        return Attribute::make(
            get:fn($image)=>url('/storage/posts'.$image),
        );
    }
}
