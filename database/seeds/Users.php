<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enum\Roles;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
           'first_name' => 'Олег',
           'last_name' => 'Дмитроченко',
           'last_name_print' => 'Дмитроченко',
           'patronymic' => 'Сергеевич',
           'email' => 'dmitrochenkooleg@gmail.com',
           'address' => 'Витебск',
           'role' => Roles::EMPLOYEE,
           'position_id' => '3',
           'password' => bcrypt('123456'),
        ]);

        User::create([
           'first_name' => 'Павел',
           'last_name' => 'Жуков',
           'last_name_print' => 'Жукова',
           'patronymic' => 'Владимирович',
           'email' => 'jukov@gmail.com',
           'address' => 'Витебск',
           'role' => Roles::LEADER,
           'position_id' => '2',
           'password' => bcrypt('123456'),
        ]);

        factory(App\Models\User::class, 3)->create([
            'role' => Roles::LEADER,
        ]);

        factory(App\Models\User::class, 50)->create();
    }
}
