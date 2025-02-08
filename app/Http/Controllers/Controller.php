<?php

namespace App\Http\Controllers;

use App\Models\FondUtilisateur;
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
        $data["solde"]=FondUtilisateur::where('idUtilisateur',$request->session()->get('idUtilisateur'))
            ->selectRaw('sum(entree-sortie) as solde')
            ->first()['solde'];
        if($request->session()->get('role')=="Admin"){
            return $this->viewAdmin($url,$data);
        }
        return $this->viewUtilisateur($url,$data);
    }
}
