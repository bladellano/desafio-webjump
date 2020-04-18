<?php

namespace Sts\Models\helper;

use PDO;

if (!defined('URL')) {
    header("Location:/");
    exit;
}

class StsDelete extends StsConn
{
    private $Tabela;
    private $chaveValor;
    private $Resultado;
    private $Query;
    private $Conn;

    public function exeDelete($Tabela, array $chaveValor)
    {
        $this->Tabela = (string) $Tabela;
        $this->chaveValor = $chaveValor;
        $this->getInstrucao();
        $this->executarInstrucao();
    }

    private function getInstrucao()
    {
        $name_column = array_keys($this->chaveValor);
        $this->Query = "DELETE FROM {$this->Tabela} WHERE {$name_column[0]} = :{$name_column[0]}";
    }

    private function executarInstrucao()
    {
        $this->conexao();
        try {
            $this->Query->execute($this->chaveValor);
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
