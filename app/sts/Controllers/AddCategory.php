<?php

namespace Sts\Controllers;

if (!defined('URL')) {
    header("Location:/");
    exit;
}

class AddCategory
{

    public function index()
    {
        $this->Dados = [];
        $showView = new \Core\ConfigView("sts/Views/shop/addcategory", $this->Dados);
        $showView->renderizar();
    }

    public function createcategory()
    {
        $data = $_POST;
        $oProduct = new \Sts\Models\StsCategory();
        $result = $oProduct->insert($data);

        if ($result) {
            $json["success"] = true;
            $json["msg"] = "Category successfully inserted";
        } else {
            $json["success"] = false;
            $json["msg"] = "Category not registered!";
        }

        echo json_encode($json);
    }

}
