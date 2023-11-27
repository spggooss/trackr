<?php

namespace App\Http\Controllers\Api;

use App\Models\User\UsersRepository;
use Illuminate\Support\Facades\Auth;

class ApiUsersController
{
    public function __construct(private UsersRepository $usersRepository)
    {}
    public function allUsers(){
        return $this->usersRepository->all();
    }

}
