<?php

namespace Sts\Controllers;

if (!defined('URL')) {
    header("Location:/");
    exit;
}

class Products
{

    private $PageId;

    public function index()
    {
        $this->PageId = filter_input(INPUT_GET, 'pg', FILTER_SANITIZE_NUMBER_INT);
        $this->PageId = $this->PageId ? $this->PageId : 1;

        $oProducts = new \Sts\Models\StsProduct();

        $oCategories = new \Sts\Models\StsCategory();

        $this->Dados['category'] = $oCategories->getCategories();

        $this->Dados['products'] = $oProducts->index($this->PageId);
        $this->Dados['paginacao'] = $oProducts->getResultadoPg();

        $showView = new \Core\ConfigView("sts/Views/shop/products", $this->Dados);
        $showView->renderizar();
    }

    public function deleteProduct()
    {
        $cod_product = $_POST['cod_product'];

        $oProduct = new \Sts\Models\StsProduct();
        $result = $oProduct->delete(['cod_product'=> $cod_product]);        

        if ($result) {
            $json["success"] = true;
            $json["msg"] = "Product successfully deleted";
        } else {
            $json["success"] = false;
            $json["msg"] = "Product has not been deleted!";
        }

        echo json_encode($json);
      
    }

    public function editProduct()
    {

        $cod_product = $_POST['cod_product'];
        $oProduct = new \Sts\Models\StsProduct();
        $result = $oProduct->getProduct($cod_product);

        $json['input']['cod_product'] = $result[0]['cod_product'];
        $json['input']['name'] = $result[0]['name'];
        $json['input']['sku'] = $result[0]['sku'];
        $json['input']['description'] = $result[0]['description'];
        $json['input']['quantity'] =  $result[0]['quantity'];
        $json['input']['price'] =  $result[0]['price'];
        $json['input']['category'] = $result[0]['category'];
        $json['input']['product_img'] =  $result[0]['product_img'];

        echo json_encode($json);
    }

    public function updateProduct()
    {

        $data = $_POST;
        $oProduct = new \Sts\Models\StsProduct();

        foreach ($data as &$values) {
            if (isset($data['category']) && is_array($data['category']))
                $data['category'] = implode('|', $data['category']);
        }

        if (!empty($data["product_img"]) && $data['was_exchange'] == 1) /*Move imagem para pasta correta*/ {
            $file_name = basename($data["product_img"]);
            $old_path = getcwd() . "/tmp/" . $file_name;
            $new_path = getcwd() . "/assets/images/product/" . $file_name;
            rename($old_path, $new_path);
            $data["product_img"] = "/assets/images/product/" . $file_name;
        }

        unset($data['was_exchange']);

        $data['dt_update'] = date('Y-m-d H:m:s');

        $oProduct->deleteFilesTmp();

        $result = $oProduct->update($data);

        if ($result) {
            $json["success"] = true;
            $json["msg"] = "Product updated successfully";
        } else {
            $json["success"] = false;
            $json["msg"] = "Product has not been updated!";
        }

        echo json_encode($json);
    }
    
    public function ajaxImportImage()
    {
        $name_file =  basename($_FILES['image_file']['name']);
        $uploaddir = 'tmp/';

        $ext = explode(".", $name_file);
        $new_name = uniqid(rand()) . "." . end($ext);
        $uploadfile = $uploaddir . $new_name;

        $json = array();
        $json["status"] = 1;

        if (!in_array(strtolower(end($ext)), ['jpg', 'png', 'jpeg'])) {
            $json["status"] = 0;
            $json["error"] = "Only image files will be accepted!";
        }

        if ($_FILES['image_file']['size'] >= 1000000) {
            $json["status"] = 0;
            $json["error"] = "File size cannot exceed 1MB.";
        } else {

            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadfile)) {
                $json["img_path"] = $uploaddir . $new_name;
            } else {
                $json["status"] = 0;
                $json["error"] = "File upload issues!";
            }
        }

        echo json_encode($json);
    }
}
