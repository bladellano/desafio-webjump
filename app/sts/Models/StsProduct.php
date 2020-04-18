<?php


namespace Sts\Models;

if (!defined('URL')) {
    header("Location:/");
    exit;
}

class StsProduct
{
    private $Result;
    private $Dados;
    private $PageId;
    private $ResultadoPg;
    private $chaveValor;
    private $LimiteResultado = 5; /* Registro por página. */

    public function getResultadoPg()
    {
        return $this->ResultadoPg;
    }

    public function index($PageId = null)
    {

        $this->PageId = $PageId;
        $paginacao = new \Sts\Models\helper\StsPagination(URL . 'products');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao('SELECT COUNT(cod_product) AS num_result 
                                FROM produto');

        $this->ResultadoPg = $paginacao->getResultado();

        $listProducts = new \Sts\Models\helper\StsRead();

        $listProducts->fullRead(
            "SELECT * FROM produto ORDER BY cod_product 
                                DESC LIMIT :limit OFFSET :offset",
            "limit=" . $this->LimiteResultado . "&offset=" . $paginacao->getOffset()
        );

        $this->Result = $listProducts->getResultado();

        return $this->Result;
    }

    public function insert(array $Dados)
    {
        $this->Dados = $Dados;
        $oProduct = new \Sts\Models\helper\StsCreate();
        $oProduct->exeCreate('produto', $this->Dados);
        return $oProduct->getResultado();
    }

    public function update(array $Dados)
    {
        $this->Dados = $Dados;
        $oProduct = new \Sts\Models\helper\StsUpdate();
        $oProduct->exeUpdate('produto', $this->Dados);
        return $oProduct->getResultado();
    }

    public function delete(array $chaveValor)
    {

        $this->chaveValor = ($chaveValor);
        $oProduct = new \Sts\Models\helper\StsDelete();
        $oProduct->exeDelete('produto', $this->chaveValor);
        return $oProduct->getResultado();
    }

    public function getProduct($cod_product)
    {
        $oProduct = new \Sts\Models\helper\StsRead();
        $oProduct->fullRead("SELECT * FROM produto WHERE cod_product = :cod_product", "cod_product=" . $cod_product);

        return $oProduct->getResultado();
    }

    public function deleteFilesTmp()
    {
        $path = getcwd() . DIRECTORY_SEPARATOR . "tmp".DIRECTORY_SEPARATOR;
        chmod($path, 0777);
        $dir = dir($path);
        while ($file = $dir->read()) {
            if (file_exists($path . $file))
                @unlink($path . $file);
        }
        $dir->close();
    }

}
