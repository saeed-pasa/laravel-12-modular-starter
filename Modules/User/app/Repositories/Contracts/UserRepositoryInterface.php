<?php

namespace Modules\User\Repositories\Contracts;

use Modules\User\Models\User;
use Modules\User\Data\RegisterData;

interface UserRepositoryInterface
{
   public function create(RegisterData $data): User;
}
