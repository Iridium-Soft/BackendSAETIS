<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
       //permisos para socios
        $permission = Permission::create(['name' => '/documents']);
        $permission1 = Permission::create(['name' => '/apply_to_announcement']);
        $permission2 = Permission::create(['name' => ' /my_work_calendar']);
        $permission3 = Permission::create(['name' => ' /inbox_postulation']);
        // permisos para consultor
        $permission4 = Permission::create(['name' => '/my_announcements']);
        $permission5= Permission::create(['name' => '/announcement_form']);
        $permission6= Permission::create(['name' => '/petis_form']);
        $permission7= Permission::create(['name' => '/my_applications']);
        $permission8= Permission::create(['name' => '/change_order']);
        $permission9= Permission::create(['name' => '/compliance_notification']);
        $permission10= Permission::create(['name' => ' /addendum']);
        $permission11= Permission::create(['name' => '/provision_contract']);
        $permission12= Permission::create(['name' => ' /application_review']);
        $permission13= Permission::create(['name' => '/observations_review']);






        //ROLES
        $role = Role::create(['name' => 'Socio'])->syncPermissions([$permission,$permission1,$permission2,$permission3]);
        $role1 = Role::create(['name' => 'Consultor'])->syncPermissions([$permission4,$permission5,$permission6,$permission7,$permission8,$permission9,$permission10,$permission11,$permission12,$permission13]);





    }
}
