<?php

class User{

    protected $users;
    protected $products;
    protected $names_arr = array();


    public function __construct($users){

        $this->users = $users;

    }

    public function getNames(){

        while($row = mysqli_fetch_array($this->users)){
            array_push($this->names_arr, $row['name']); 
        }

        return $this->names_arr;

    }

}