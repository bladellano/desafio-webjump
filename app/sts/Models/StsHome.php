<?php


namespace Sts\Models;

if(!defined('URL')){
    header("Location:/");
    exit;
}

class StsHome
{

    private $Resultado;
    
    public function index(){

        $oProducts = new \Sts\Models\helper\StsRead();
  
        $oProducts->fullRead("SELECT * FROM produto ORDER BY cod_product DESC LIMIT :limit","limit=4");

        $this->Resultado['products'] = $oProducts->getResultado();

        return $this->Resultado;
    }

}