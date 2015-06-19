<?php  namespace Kivi\Repositories;

use App\User;
class UserRepository {
    public function checkEmail($email)
    {
        return count(User::select(['email'])->where('email', $email)->get());
    }
} 