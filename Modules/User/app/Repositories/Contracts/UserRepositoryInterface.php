<?php

namespace Modules\User\app\Repositories\Contracts;

use App\Models\User;
use Modules\User\app\Data\RegisterData;

interface UserRepositoryInterface
{
   public function create(RegisterData $data): User;
}
