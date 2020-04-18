 <?php

  if (!defined('URL')) {
    header("Location:/");
    exit;
  }

  $products = $this->Dados['products'];
  $categories = $this->Dados['category'];

  ?>
 <!-- Main Content -->
 <main class="content">
   <div class="header-list-page">
     <h1 class="title">Products</h1>
     <a href="addproduct" class="btn-action">Add new Product</a>
   </div>

   <table class="data-grid">
     <tr class="data-row">
       <th class="data-grid-th" style="width:20%">
         <span class="data-grid-cell-content">Name</span>
       </th>
       <th class="data-grid-th" style="width:20%">
         <span class="data-grid-cell-content">SKU</span>
       </th>
       <th class="data-grid-th" style="width:20%">
         <span class="data-grid-cell-content">Price</span>
       </th>
       <th class="data-grid-th" style="width:10%">
         <span class="data-grid-cell-content">Quantity</span>
       </th>
       <th class="data-grid-th" style="width:10%">
         <span class="data-grid-cell-content">Categories</span>
       </th>

       <th class="data-grid-th" style="width:20%">
         <span class="data-grid-cell-content">Actions</span>
       </th>
     </tr>
     <?php

      if (empty($this->Dados['products'])) {
        echo "<div class='alert alert-danger'>Error: no results found</div>";
      }

      foreach ($products as $product) :

      ?>

       <tr class="data-row">
         <td class="data-grid-td">
           <span class="data-grid-cell-content"><?= $product['name'] ?></span>
         </td>

         <td class="data-grid-td">
           <span class="data-grid-cell-content"><?= $product['sku'] ?></span>
         </td>

         <td class="data-grid-td">
           <span class="data-grid-cell-content">R$ <?= $product['price'] ?></span>
         </td>

         <td class="data-grid-td">
           <span class="data-grid-cell-content"><?= $product['quantity'] ?></span>
         </td>

         <td class="data-grid-td">
           <span class="data-grid-cell-content"><?= str_replace("|", "<br/>", $product['category']) ?></span>
         </td>

         <td class="data-grid-td">
           <div class="actions">

             <div class="action">
               
               <button cod_product="<?= $product['cod_product'] ?>" type="button" class="btn btn-primary btn_edit_product" data-toggle="modal" data-target="#editModal" data-whatever="@mdo"><i class="fa fa-edit"></i></button>

               <button cod_product="<?= $product['cod_product'] ?>" class="btn btn-danger btn_delete_product"><i class="fa fa-trash"></i></button>

             </div>
           </div>
         </td>
       </tr>

     <?php
      endforeach;
      ?>

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
         <h5 class="modal-title" id="ModalLabel">Edit Product</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">

         <form id="form_product_edit">

           <input type="hidden" name="cod_product" id="cod_product">
           <input type="hidden" name="was_exchange" id="wase_exchange" value=0>

           <div class="input-field">
             <label for="sku" class="label">Product SKU</label>
             <input type="text" id="sku" name="sku" class="input-text" />
           </div>

           <div class="input-field">
  
             <label for="name" class="label">Photo Product</label>

             <img src="" alt="" id="product_img_path" style="max-height:286px;" />

             <label class="btn btn-info">
               <i class="fa fa-upload"></i>&nbsp;&nbsp;Carregar
               <input type="file" id="btn_upload_product_img" accept="image/*" style="display:none">
             </label>

             <input id="product_img" name="product_img" hidden>

           </div>

           <div class="input-field">
             <label for="name" class="label">Product Name</label>
             <input type="text" name="name" id="name" class="input-text" />
           </div>


           <div class="input-field">
             <label for="price" class="label">Price</label>
             <input type="text" name="price" id="price" class="input-text" />
           </div>
           <div class="input-field">
             <label for="quantity" class="label">Quantity</label>
             <input type="text" name="quantity" id="quantity" class="input-text" />
           </div>
           <div class="input-field">
             <label for="category" class="label">Categories</label>
             <select multiple name="category[]" id="category" class="input-text">
               <?php
                foreach ($categories as $cat) :
                ?>
                 <option value="<?= $cat['category'] ?>"><?= $cat['category'] ?></option>
               <?php
                endforeach;
                ?>
             </select>
           </div>
           <div class="input-field">
             <label for="description" class="label">Description</label>
             <textarea id="description" name="description" class="input-text"></textarea>
           </div>
           <div class="actions-form">
             <a href="./" class="action back">Back</a>
             <input class="btn-submit btn-action" type="submit" value="Update Product" />
           </div>

         </form>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <!-- <button type="button" class="btn btn-primary">Send message</button> -->
       </div>
     </div>
   </div>
 </div>