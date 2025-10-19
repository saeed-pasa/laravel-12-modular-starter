<?php

namespace Modules\User\app\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\User\app\Data\RegisterData;
use Modules\User\app\Repositories\Contracts\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
   
   public function create(RegisterData $data): User
   {
      return User::create([
         'name' => $data->name,
         'email' => $data->email,
         'password' => Hash::make($data->password),
      ]);
   }
}
