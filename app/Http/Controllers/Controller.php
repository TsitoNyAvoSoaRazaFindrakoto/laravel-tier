<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Controller
{
    private function viewAdmin($url,$data){
        $data["sideBar"]="sideBarAdmin";
        return view($url,$data);
    }

    private function viewUtilisateur($url,$data){
        $data["sideBar"]="sideBarUtilisateur";
        return view($url,$data);
    }

    protected function getView($url,Request $request,$data=[]){
        if($request->session()->get('role')=="Admin"){
            return $this->viewAdmin($url,$data);
        }
        return $this->viewUtilisateur($url,$data);
    }
}
