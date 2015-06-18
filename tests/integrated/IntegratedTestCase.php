<?php

use App\User;
use App\Role;
use Laracasts\Integrated\Extensions\Laravel as Test;

class IntegratedTestCase extends Test {
	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__.'/../../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		return $app;
	}

    protected function mockUser()
    {
        $role = new Role();
        $role->role = "User";

        $user = new User();
        $user->role = $role;

        return $user;
    }

    protected function mockModerator()
    {
        $role = new Role();
        $role->role = "Mod";

        $user = new User();
        $user->role = $role;

        return $user;
    }

    protected function mockAdmin()
    {
        $role = new Role();
        $role->role = "Admin";

        $user = new User();
        $user->role = $role;

        return $user;
    }
}