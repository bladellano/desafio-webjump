 <?php

  if (!defined('URL')) {
    header("Location:/");
    exit;
  }

  $categories = $this->Dados['categories'];

  ?>

<!-- Main Content -->
<main class="content">
    <div class="header-list-page">
      <h1 class="title">Categories</h1>
      <a href="addcategory" class="btn-action">Add new Category</a>
    </div>
    <table class="data-grid">
      <tr class="data-row">
        <th class="data-grid-th">
            <span class="data-grid-cell-content">Name</span>
        </th>
        <th class="data-grid-th">
            <span class="data-grid-cell-content">Code</span>
        </th>
        <th class="data-grid-th">
            <span class="data-grid-cell-content">Actions</span>
        </th>
      </tr>

<?php foreach ($categories as $category) : ?>
      <tr class="data-row">
        <td class="data-grid-td">
           <span class="data-grid-cell-content"><?=$category['category']?></span>
        </td>
      
        <td class="data-grid-td">
           <span class="data-grid-cell-content"><?=$category['cod_category']?></span>
        </td>
      
        <td class="data-grid-td">
          <div class="actions">

            <button cod_category="<?=$category['cod_category']?>" data-toggle="modal" data-target="#editModal" data-whatever="@mdo" class="btn btn-primary btn_edit_category">
              <i class="fa fa-edit"></i></button>

            <button cod_category="<?=$category['cod_category']?>" class="btn btn-danger btn_delete_category">
            <i class="fa fa-trash"></i></button>
          
          </div>
        </td>
      </tr>

<?php endforeach; ?>   
     
    </table>
    <div class="pagination">
     <?php echo $this->Dados['paginacao'] ?>
   </div>
  </main>
  <!-- Main Content -->

 <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="ModalLabel">Edit Category</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">

         <form id="form_category_edit">

           <input type="hidden" name="cod_category" id="cod_category">

           <div class="input-field">
             <label for="sku" class="label">Category Name</label>
             <input type="text" id="category" name="category" class="input-text" />
           </div>
        
           <div class="actions-form">
             <a href="./" class="action back">Back</a>
             <input class="btn-submit btn-action" type="submit" value="Update Category" />
           </div>

         </form>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       </div>
     </div>
   </div>
 </div>