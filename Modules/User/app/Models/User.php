<?php

namespace Modules\User\Models;

use Modules\User\Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
   /** @use HasFactory<UserFactory> */
   use HasFactory, Notifiable;

   /**
    * Create a new factory instance for the model.
    */
   protected static function newFactory(): UserFactory
   {
      return UserFactory::new();
   }

   /**
    * The attributes that are mass assignable.
    *
    * @var list<string>
    */
   protected $fillable = [
      'name',
      'email',
      'password',
   ];

   /**
    * The attributes that should be hidden for serialization.
    *
    * @var list<string>
    */
   protected $hidden = [
      'password',
      'remember_token',
   ];

   /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
   protected function casts(): array
   {
      return [
         'email_verified_at' => 'datetime',
         'password' => 'hashed',
      ];
   }

   public function getJWTIdentifier()
   {
      return $this->getKey();
   }

   public function getJWTCustomClaims(): array
   {
      return [];
   }
}
