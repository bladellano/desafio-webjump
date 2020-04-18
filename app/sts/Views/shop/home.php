<?php

if (!defined('URL')) {
    header("Location:/");
    exit;
}

 $products = $this->Dados["products"];
?>

 <!-- Main Content -->
 <main class="content">
    <div class="header-list-page">
      <h1 class="title">Dashboard</h1>
    </div>
    <div class="infor">
      <!-- You have 4 products added on this store: <a href="addProduct.html" class="btn-action">Add new Product</a> -->
      You have 4 products added on this store: <a href="addproduct" class="btn-action">Add new Product</a>
    </div>
    <ul class="product-list">

<?php
    foreach($products as $product){
     ?> 
      <li>
        <div class="product-image">
          <img src="<?=URL.$product['product_img']?>" layout="responsive" width="164"  alt="Tênis Runner Bolt" />
        </div>
        <div class="product-info">
          <div class="product-name"><span><?=$product['name']?></span></div>
          <div class="product-price"><span class="special-price"><?=rand(1,20)?> available</span> 
          <span>R$<?=number_format($product['price'], 2,",",".")?></span></div>
        </div>
      </li>
<?php
    }
    ?>

  


      <!-- <li>
        <div class="product-image">
          <a href="tenis-basket-light.html" title="Tênis Basket Light">
            <img src="<?=URL?>assets/images/product/tenis-basket-light.png" layout="responsive" width="164" height="145" alt="Tênis Basket Light" />
          </a>
        </div>
        <div class="product-info">
          <div class="product-name"><span>Tênis Basket Light</span></div>
          <div class="product-price"><span class="special-price">1 available</span> <span>R$459,99</span></div>
        </div>
      </li>
      <li>
        <div class="product-image">
          <a href="tenis-basket-light.html" title="Tênis Basket Light">
           <img src="<?=URL?>assets/images/product/tenis-2d-shoes.png" layout="responsive" width="164" height="145" alt="Tênis 2D Shoes" />
          </a>
        </div>
        <div class="product-info">
          <div class="product-name"><span>Tênis 2D Shoes</span></div>
          <div class="product-price"><span class="special-price">2 Available</span> <span>R$459,99</span></div>
        </div>
      </li>
      <li>
        <div class="product-image">
          <img src="<?=URL?>assets/images/product/tenis-sneakers-43n.png" layout="responsive" width="164" height="145" alt="Tênis Sneakers 43N" />
        </div>
        <div class="product-info">
          <div class="product-name"><span>Tênis Sneakers 43N</span></div>
          <div class="product-price"><span class="special-price">Out of stock</span> <span>R$459,99</span></div>
        </div>
      </li> -->


    </ul>
  </main>
  <!-- Main Content -->