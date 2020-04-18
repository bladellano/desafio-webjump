<?php

namespace Sts\Models\helper;

use PDO;

if (!defined('URL')) {
    header("Location:/");
    exit;
}

class StsRead extends StsConn
{

    private $Select;
    private $Values;
    private $Resultado;
    private $Query;
    private $Conn;

    public function getResultado()
    {
        return $this->Resultado;
    }

    public function exeRead($Tabela, $Termos = null,$ParseString = null)
    {
        if(!empty($ParseString)){
            parse_str($ParseString,$this->Values);
        }
        $this->Select = "SELECT * FROM {$Tabela} {$Termos}";
        $this->exeInstrucao();
    }

    public function fullRead($Query, $ParseString = null){
        $this->Select = (string) $Query;
        if(!empty($ParseString)){
            parse_str($ParseString,$this->Values);
        }
        $this->exeInstrucao();
    }
    private function exeInstrucao()
    {
        $this->conexao();
        try{
            $this->getInstrucao();
            $this->Query->execute();
            $this->Resultado = $this->Query->fetchAll();

        }catch (\Exception $e){
            $this->Resultado = null;
        }

    }

    private function conexao()
    {
        $this->Conn = parent::getConn();
        $this->Query = $this->Conn->prepare($this->Select);
        $this->Query->setFetchMode(PDO::FETCH_ASSOC);
    }
    private function getInstrucao()
    {
        if($this->Values){
            foreach ($this->Values as $link => $valor){
                if($link =='limit' || $link == 'offset') {
                    $valor = (int)$valor;
                }
                $this->Query->bindValue(":{$link}", $valor ,(is_int($valor)? PDO::PARAM_INT : PDO::PARAM_STR));
            }
        }
    }
} 

