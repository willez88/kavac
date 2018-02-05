<?php

use Illuminate\Database\Seeder;

use App\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function() {
        	/** @var [boolean] Crea el usuario por defecto de la aplicación */
    		$db_user = User::updateOrCreate(
                ['username' => 'admin'],
                [
                    'name' => 'Admin',
                    'email' => 'admin@admin.com',
                    'password' => bcrypt('123456'),
                    'is_admin' => true,
                    'created_at' => Carbon::now()
                ]
            );
	        if (!$db_user)
            {
                throw new Exception(trans('messages.msg_create_default_user'));
            }
    	});
    }
}
