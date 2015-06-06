<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

        $this->call('TypesTableSeeder');
        $this->call('GroupesTableSeeder');
		$this->call('GroupeTypeTableSeeder');
        $this->call('UserTypesGroupesTableSeeder');
        $this->call('UserTypesTableSeeder');
        $this->call('CountryTableSeeder');

        if (app()->environment('local'))
        {
           // $this->call('UsersTableSeeder');
           // $this->call('LabelsTableSeeder');
           // $this->call('RiiinglinksTableSeeder');
           // $this->call('MetasTableSeeder');
        }
	}

}
