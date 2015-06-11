<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\NewUserRequest;
use App\Http\Controllers\Controller;

use Kivi\Repositories\UserRepository;

use Illuminate\Http\Request;

class UserController extends Controller {
    /** @var UserRepository */
    protected $userRepository;

    function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function checkEmail($email)
    {
        if($this->userRepository->checkEmail($email)) {
            return response()->jsend('fail', [
                'reason' => 'EmailAlreadyExists'
            ]);
        }
        return response()->jsend('success');
    }
}
