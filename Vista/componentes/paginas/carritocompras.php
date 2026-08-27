<?php require_once 'Vista/componentes/navegacion/botonVolver.php'; ?>
<h1 class="h1secondary">Carrito de compras</h1>
<?php if(isset($compras) && !empty($compras)): ?>
<div class="row">
  <?php foreach($compras as $compra): ?>
  <article class="card-article">
    <div class="card">
        <?php
          $src = "";
          if(isset($compra)) {
            $imagen = $compra->__get('imagen');
            $infoImage = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $infoImage->buffer($imagen);
            $src = "data:".$mime_type."; base64,".base64_encode($imagen).'"';
          } 
        ?>
      <img src="<?php echo $src; ?>" alt="">
      <div class="card-content">
        <h4><?php echo $compra->__get('nombre'); ?></h4>
        <details class="description">
          <summary>Descripción:</summary>
          <p><?php echo $compra->__get('descripcion'); ?></p>
        </details>
        <p>categoria: <span><?php echo $compra->__get('categoria'); ?></span></p>
        <p>cantidad: <span><?php echo $compra->__get('cantidad'); ?></span></p>
        <p>Precio total: <?php echo $compra->__get('precio') * $compra->__get('cantidad'); ?></p>
      </div>
      <div>
        <?php if(isset($editarCarrito) && $editarCarrito): ?>
        <a id="editarCompra<?php echo $compra->__get("id");?>" class="button-google btn-hover" onclick="accionCarroCompra(<?php echo $this->usuario->__get('id');?>, <?php echo $compra->__get('id'); ?>, 'editar')">Editar Compra</a>
        <?php endif; ?>
      </div>
      <div>
      <a id="eliminarCompra<?php echo $compra->__get("id"); ?>" class="button-user button-danger btn-hover" onclick="popupQuitarCompra('¿Desea quitar la compra <?php echo $compra->__get("nombre"); ?>?', <?php echo $this->usuario->__get("id"); ?>, <?php echo $compra->__get("id"); ?>, 'eliminar')">Quitar Compra</a>
      </div>
    </div>
  </article>
  <?php endforeach; ?>
</div>
<?php else: ?>
  <div class="content-messages">
    <p class="messages">No existe compras registradas</p>
  </div>
<?php endif; ?>
