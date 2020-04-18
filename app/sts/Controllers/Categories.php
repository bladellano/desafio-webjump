<?php

namespace Sts\Controllers;

if (!defined('URL')) {
    header("Location:/");
    exit;
}

class Categories
{

    private $PageId;

    public function index()
    {

        $this->PageId = filter_input(INPUT_GET, 'pg', FILTER_SANITIZE_NUMBER_INT);
        $this->PageId = $this->PageId ? $this->PageId : 1;

        $oCategories = new \Sts\Models\StsCategory();

        $this->Dados['categories'] = $oCategories->index($this->PageId);
        $this->Dados['paginacao'] = $oCategories->getResultPg();

        $showView = new \Core\ConfigView("sts/Views/shop/categories", $this->Dados);
        $showView->renderizar();
    }

    public function deleteCategory()
    {
        $Codigo = $_POST['cod_category'];

        $oCategory = new \Sts\Models\StsCategory();
        $result = $oCategory->delete(['cod_category'=> $Codigo]);        

        if ($result) {
            $json["success"] = true;
            $json["msg"] = "Category successfully deleted";
        } else {
            $json["success"] = false;
            $json["msg"] = "Category has not been deleted!";
        }

        echo json_encode($json);
      
    }

    public function editCategory()
    {
        $Codigo = $_POST['codigo'];
        $oCaregory = new \Sts\Models\StsCategory();
        $result = $oCaregory->getCategory($Codigo);

        $json['input']['cod_category'] = $result[0]['cod_category'];
        $json['input']['category'] = $result[0]['category'];
    
        echo json_encode($json);
    }


    public function updateCategory()
    {

        $data = $_POST;
        $oCategory = new \Sts\Models\StsCategory();
     
        $data['dt_update'] = date('Y-m-d H:m:s');

        $result = $oCategory->update($data);

        if ($result) {
            $json["success"] = true;
            $json["msg"] = "Category updated successfully";
        } else {
            $json["success"] = false;
            $json["msg"] = "Category has not been updated!";
        }

        echo json_encode($json);
    }

}
