$(document).ready(function () {

  $("#deletemodal").on("show.bs.modal", function (event) {

    var button = $(event.relatedTarget);

    var id = button.data("id");
    var pedido = button.data("pedido");

    var modal = $(this);
    modal.find(".modal-title").text("Excluir Registro #" + id);

     if(pedido == 1) {
       modal.find("#confirm").attr("href", "delPedido.php?id=" + id);
     } else {
       modal.find("#confirm").attr("href", "delProduto.php?id=" + id);
     }

  });


});