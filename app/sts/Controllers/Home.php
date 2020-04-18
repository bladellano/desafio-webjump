<?php

namespace Sts\Controllers;

if(!defined('URL')){
    header("Location:/");
    exit;
}

class Home
{
    private $Dados;

    public function index()
    {
        $home = new \Sts\Models\StsHome();
        $this->Dados = $home->index();

        $showView = new \Core\ConfigView("sts/Views/shop/home",$this->Dados);
        $showView->renderizar();
    }
} 

