<?php

use App\TypeExtension;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(PermissionsTableSeeder::class);
        $this->call(CollegeTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
       // $this->call(SemesterTableSeeder::class);
        //$this->call(StudentTableSeeder::class);
       // $this->call(ProfessorTableSeeder::class);
        //$this->call(TdgTableSeeder::class);
        $this->call(TypeExtensionSeeder::class);
      
        
    }
}
