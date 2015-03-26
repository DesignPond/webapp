<?php namespace App\Riiingme\Country\Repo;

use App\Riiingme\Country\Repo\CountryInterface;
use App\Riiingme\Country\Entities\Country as M;

class CountryEloquent implements CountryInterface {

    public function __construct(M $country){

        $this->country = $country;
    }

    public function getAll(){

        return $this->country->all();
    }

    public function find($id){

        return $this->country->find($id);
    }

    public function create(array $data){

        $country = $this->country->create([
            'iso'       => $data['iso'],
            'name'      => $data['name'],
            'nicename'  => $data['nicename'],
            'iso3'      => $data['iso3'],
            'numcode'   => $data['numcode'],
            'phonecode' => $data['phonecode']
        ]);

        if(!$country){
            return false;
        }

        return $country;
    }

    public function update(array $data){

        $country = $this->country->findOrFail($data['id']);

        if( ! $country )
        {
            return false;
        }

        $country->fill($data);
        $country->save();

        return $country;
    }

    public function delete($id){

        $country = $this->country->find($id);

        if( ! $country )
        {
            return false;
        }

        return $country->delete($id);
    }

}
