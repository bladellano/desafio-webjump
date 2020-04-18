<?php

if (!defined('URL')) {
  header("Location:/");
  exit;
}

$categories = $this->Dados['category'];

?>
<!-- Main Content -->
<main class="content">
  <h1 class="title new-item">New Product</h1>

  <form id="form_product">
    <div class="input-field">
      <label for="sku" class="label">Product SKU</label>
      <input type="text" id="sku" name="sku" class="input-text" />
    </div>

    <div class="input-field">
      <!-- <label for="name" class="label">Product Name</label>
      <input type="text" name ="name" id="name" class="input-text" /> -->
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
          <option><?= $cat['category'] ?></option>
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
      <!-- <a href="products.html" class="action back">Back</a> -->
      <a href="./" class="action back">Back</a>
      <input class="btn-submit btn-action" type="submit" value="Save Product" />
    </div>

  </form>
</main>
<!-- Main Content -->