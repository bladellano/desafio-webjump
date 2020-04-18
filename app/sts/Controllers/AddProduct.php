<?php

namespace Sts\Controllers;

if (!defined('URL')) {
    header("Location:/");
    exit;
}

class AddProduct
{

    public function index()
    {
        $oCategory = new \Sts\Models\StsCategory();
        $this->Dados['category'] = $oCategory->getCategories();

        $showView = new \Core\ConfigView("sts/Views/shop/addproduct", $this->Dados);
        $showView->renderizar();
    }

    public function createProduct()
    {
        $data = $_POST;

        if (!empty($data["product_img"])) {

            $file_name = basename($data["product_img"]);
            $old_path = getcwd() . "/tmp/" . $file_name;
            $new_path = getcwd() . "/assets/images/product/" . $file_name;
            rename($old_path, $new_path);
            $data["product_img"] = "/assets/images/product/" . $file_name;
        }

        foreach ($data as &$values) {
            if (isset($data['category']) && is_array($data['category']))
                $data['category'] = implode('|', $data['category']);
        }

        $data['price'] = floatval($data['price']); /*Força ser um valor float*/

        $oProduct = new \Sts\Models\StsProduct();
        $result = $oProduct->insert($data);

        if ($result) {
            $json["success"] = true;
            $json["msg"] = "Product successfully inserted";
        } else {
            $json["success"] = false;
            $json["msg"] = "Product not registered!";
        }

        $oProduct->deleteFilesTmp();

        echo json_encode($json);
    }

}
