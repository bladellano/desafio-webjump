const BASE_URL = 'http://localhost/desafio';

$(function () {

  /* Pré-visualiação da imagem do produto */

 $("#btn_upload_product_img").change(function () {
    $('#wase_exchange').val(1);
    uploadImg($(this), $("#product_img_path"), $("#product_img"));
  });


/**
 * Scripts para categoria
*/
$('#form_category').submit(function(e){

  e.preventDefault();

  if (isEmptyForm($(this).attr("id")))
      return Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Fill in all the fields!",
      });

    const data = $(this).serializeArray();

    $.ajax({
      type: "POST",
      url: "addcategory/createcategory/",
      data: data,
      dataType: "json",
      success: (resp) => {

        if (resp.success) {

          $(this)[0].reset();

          return Swal.fire({
            position: "top-center",
            icon: "success",
            title: resp.msg,
            showConfirmButton: false,
            timer: 2500,
          });
        } else {
          return Swal.fire({
            icon: "error",
            title: "Oops...",
            text: resp.msg,
          });
        }
      },
    });

});

/* Edita categoria */
$(".btn_edit_category").click(function () {
  let codigo = $(this).attr("cod_category");
  $.ajax({
    type: "POST",
    url: "categories/editcategory/",
    data: { codigo },
    dataType: "json",
    success: (resp) => {
      $('#cod_category').val(resp.input.cod_category);
      $('#category').val(resp.input.category);
    },
  });
});

/* Deleta categoria */
$('.btn_delete_category').click(function(){

  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      ajaxDeleteCategory();
    } 
  });

 const ajaxDeleteCategory = ()=>{
    
    let cod_category = $(this).attr("cod_category");

    $.ajax({
    type: "POST",
    url: "categories/deletecategory/",
    data: { cod_category },
    dataType: "json",
    success: (resp) => {
      if (resp.success) {

         setTimeout(()=>{
          location.reload(); 
         },2000); 

        return Swal.fire({
          position: "top-center",
          icon: "success",
          title: resp.msg,
          showConfirmButton: false,
          timer: 2500,
        });        

      } else {
        return Swal.fire({
          icon: "error",
          title: "Oops...",
          text: resp.msg,
        });
      }
    },
  });
}

});


/* Fomulário de edição categoria */
$('#form_category_edit').submit(function(e){

  e.preventDefault();

     const data = $(this).serializeArray();

    $.ajax({
      type: "POST",
      url: "categories/updatecategory/",
      data: data,
      dataType: "json",
      success: (resp) => {
        if (resp.success) {

          $(this)[0].reset();

          $('#editModal').modal('hide');

           setTimeout(()=>{
            location.reload(); 
           },2000); 

          return Swal.fire({
            position: "top-center",
            icon: "success",
            title: resp.msg,
            showConfirmButton: false,
            timer: 2500,
          });        

        } else {
          return Swal.fire({
            icon: "error",
            title: "Oops...",
            text: resp.msg,
          });
        }
      }
    });

  });


/**
 * Scripts para produtos
*/

  /* Update do produto */

    $('#form_product_edit').submit(function(e){

    e.preventDefault();

       const data = $(this).serializeArray();

      $.ajax({
        type: "POST",
        url: "products/updateProduct/",
        data: data,
        dataType: "json",
        success: (resp) => {
          if (resp.success) {

            $(this)[0].reset();

            $('#editModal').modal('hide');

             setTimeout(()=>{
              location.reload(); 
             },2000); 

            return Swal.fire({
              position: "top-center",
              icon: "success",
              title: resp.msg,
              showConfirmButton: false,
              timer: 2500,
            });        

          } else {
            return Swal.fire({
              icon: "error",
              title: "Oops...",
              text: resp.msg,
            });
          }
        }
      });

    });

    /* Deleta produto */
    $(".btn_delete_product").click(function () {

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          ajaxDeleteProduct();
        }
      });

     const ajaxDeleteProduct = ()=>{
        
        let cod_product = $(this).attr("cod_product");

        $.ajax({
        type: "POST",
        url: "products/deleteproduct/",
        data: { cod_product },
        dataType: "json",
        success: (resp) => {
          if (resp.success) {

             setTimeout(()=>{
              location.reload(); 
             },2000); 

            return Swal.fire({
              position: "top-center",
              icon: "success",
              title: resp.msg,
              showConfirmButton: false,
              timer: 2500,
            });        

          } else {
            return Swal.fire({
              icon: "error",
              title: "Oops...",
              text: resp.msg,
            });
          }
        },
      });
    }

    });

/* Edita produto */
  $(".btn_edit_product").click(function () {
    let cod_product = $(this).attr("cod_product");
    $.ajax({
      type: "POST",
      url: "products/editproduct/",
      data: { cod_product },
      dataType: "json",
      success: (resp) => {
        $.each(resp.input, (id, value) => {
          $("#" + id).val(value);
        });

        $("#product_img_path").attr("src",BASE_URL+resp.input.product_img);/*Inclui imagem na tag img*/
        $("#product_img").attr("src",BASE_URL+resp.input.product_img);/*Inclui imagem na tag img*/

        var aCategory = resp.input.category.split('|');

        $.each(aCategory,(id,value)=>{
          $('#category option[value="'+value+'"]').attr('selected',true)
          });
      },
    });
  });

  /* Envio do formulário do produto */

  $("#form_product").submit(function (e) {
    e.preventDefault();

    if (isEmptyForm($(this).attr("id")))
      return Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Fill in all the fields!",
      });

    const data = $(this).serializeArray();

    $.ajax({
      type: "POST",
      url: "addproduct/createproduct/",
      data: data,
      dataType: "json",
      success: (resp) => {
        if (resp.success) {
          $("#product_img_path").attr("src", "");
          $(this)[0].reset();

          return Swal.fire({
            position: "top-center",
            icon: "success",
            title: resp.msg,
            showConfirmButton: false,
            timer: 2500,
          });
        } else {
          return Swal.fire({
            icon: "error",
            title: "Oops...",
            text: resp.msg,
          });
        }
      },
    });
  });
}); //Fim


/* Verifica se o formulário possui algum campo vazio. */
function isEmptyForm(form) {
  let dados = $("#" + form).serialize();
  let d = dados.split("&");
  let empty = 0;
  for (i = 0; i < d.length; i++) {
    let input = d[i].split("=");
    if (input[1] == "") {
      empty++;
    }
  }
  return empty;
}

/* Função que trata a pré-visualização das imagens. */
function uploadImg(input_file, img, input_path) {
  src_before = img.attr("src");
  img_file = input_file[0].files[0];

  form_data = new FormData();
  form_data.append("image_file", img_file);

  $.ajax({
    url: "products/ajaximportimage/",
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    type: "POST",
    success: function (resp) {
      if (resp["status"]) {
        img.attr("src", resp["img_path"]);
        input_path.val(resp["img_path"]);
      } else {
        alert(resp["error"]);
        img.attr("src", src_before);
      }
    },
    error: function () {
      img.attr("src", src_before);
    },
  });
}
