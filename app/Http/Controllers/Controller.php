<?php

namespace App\Http\Controllers;

class Controller
{
    protected function viewAdmin($url,$data){
        $data["sideBar"]="sideBarAdmin";
        return view($url,$data);
    }

    protected function viewUtilisateur($url,$data){
        $data["sideBar"]="sideBarUtilisateur";
        return view($url,$data);
    }
}
