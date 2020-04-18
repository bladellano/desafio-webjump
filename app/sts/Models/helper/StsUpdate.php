<?php

namespace Sts\Models\helper;

use PDO;

if (!defined('URL')) {
    header("Location:/");
    exit;
}

class StsUpdate extends StsConn
{
    private $Tabela;
    private $Dados;
    private $Resultado;
    private $Query;
    private $Conn;

    public function exeUpdate($Tabela, array $Dados)
    {
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;

        $this->getInstrucao();
        $this->executarInstrucao();
    }

    private function getInstrucao()
    {
        $name_cod = array_keys($this->Dados);
        $value_cod = array_values($this->Dados);

        $data = [];
        foreach ( $this->Dados as $name_input => $value) :
            $data[] = $name_input . " = :" . $name_input;
        endforeach;
        
        $columnParseString = implode(', ', $data);
        $this->Query = "UPDATE {$this->Tabela} SET {$columnParseString} WHERE {$name_cod[0]} = {$value_cod[0]}";
    }

    private function executarInstrucao()
    {
        $this->conexao();
        try {
            $this->Query->execute($this->Dados);
            $this->Resultado = $this->Query->rowCount();
        } catch (\Exception $e) {
            $this->Resultado = null;
        }
    }
    private function conexao()
    {
        $this->Conn = parent::getConn();
        $this->Query = $this->Conn->prepare($this->Query);
    }
    public function getResultado()
    {
        if ($this->Resultado)
            return $this->Resultado;
    }
}
