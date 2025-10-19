<?php

namespace Modules\User\Repositories\Eloquent;

use Modules\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\User\Data\RegisterData;
use Modules\User\Repositories\Contracts\UserRepositoryInterface;

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
