<?php

namespace Sts\Models;

if (!defined('URL')) {
    header("Location:/");
    exit;
}

class StsCategory
{
    private $Result;
    private $PageId;
    private $ResultPg;
    private $LimitResult = 5;
    private $keyValue;

    public function getResultPg()
    {
        return $this->ResultPg;
    }

    public function getCategories()
    {
        $oCategories = new \Sts\Models\helper\StsRead();
        $oCategories->fullRead('SELECT * FROM categoria ORDER BY category ASC');
        return $oCategories->getResultado();
    }

    public function index($PageId = null)
    {

        $this->PageId = $PageId;
        $paginacao = new \Sts\Models\helper\StsPagination(URL . 'categories');/* Passa a url e a controller */
        $paginacao->condicao($this->PageId, $this->LimitResult);

        $paginacao->paginacao('SELECT COUNT(cod_category) AS num_result 
                                FROM categoria');

        $this->ResultPg = $paginacao->getResultado();
        $listProducts = new \Sts\Models\helper\StsRead();
        $listProducts->fullRead(
            "SELECT * FROM categoria ORDER BY cod_category 
                                DESC LIMIT :limit OFFSET :offset",
            "limit=" . $this->LimitResult . "&offset=" . $paginacao->getOffset()
        );
        $this->Result = $listProducts->getResultado();
        return $this->Result;
    }

    public function getCategory($Codigo)
    {
        $oCategory = new \Sts\Models\helper\StsRead();
        $oCategory->fullRead("SELECT * FROM categoria WHERE cod_category = :cod_category", "cod_category=" . $Codigo);

        return $oCategory->getResultado();
    }
    public function insert(array $Dados)
    {
        $this->Dados = $Dados;
        $oProduct = new \Sts\Models\helper\StsCreate();
        $oProduct->exeCreate('categoria', $this->Dados);
        return $oProduct->getResultado();
    }

    public function delete(array $keyValue)
    {

        $this->keyValue = ($keyValue);
        $oProduct = new \Sts\Models\helper\StsDelete();
        $oProduct->exeDelete('categoria', $this->keyValue);
        return $oProduct->getResultado();
    }

    public function update(array $Dados)
    {
        $this->Dados = $Dados;
        $oProduct = new \Sts\Models\helper\StsUpdate();
        $oProduct->exeUpdate('categoria', $this->Dados);
        return $oProduct->getResultado();
    }

}
