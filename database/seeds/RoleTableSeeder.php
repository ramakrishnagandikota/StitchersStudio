<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = new Role;
        $role1->role_name = 'Admin';
        $role1->save();

        $role2 = new Role;
        $role2->role_name = 'Knitter';
        $role2->save();

        $role3 = new Role;
        $role3->role_name = 'Wholesaler';
        $role3->save();

        $role4 = new Role;
        $role4->role_name = 'Designer';
        $role4->save();

        $role5 = new Role;
        $role5->role_name = 'Advertaiser';
        $role5->save();

        $role6 = new Role;
        $role6->role_name = 'Retailer';
        $role6->save();
    }
}
