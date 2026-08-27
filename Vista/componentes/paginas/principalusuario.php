<?php if(isset($this->existeSesion) && $this->existeSesion && isset($_SESSION['rol']) && ($_SESSION['rol'])=='noadmin'): ?>
<div class="content-btncar">
  <a id="verCompra<?php echo $this->usuario->__get('id');?>" class="button-admin button-car button-google btn-hover" onclick="accionCarroCompra(<?php echo $this->usuario->__get('id'); ?>, 0, 'ver')">Ver carrito</a>
</div>
<?php endif;?>
<?php if(isset($this->productos) && !empty($this->productos)): ?>
<div class="row">
  <?php foreach($this->productos as $producto): ?>
  <article class="card-article">
  <div id="card<?php echo $producto->__get('id'); ?>" class="card">
        <?php
          $src = "";
          if(isset($producto)) {
            $imagen = $producto->__get('imagen');
            $infoImage = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $infoImage->buffer($imagen);
            $src = "data:".$mime_type."; base64,".base64_encode($imagen).'"';
          } 
        ?>
      <img src="<?php echo $src; ?>" alt="Avatar-Product">
      <div class="card-content">
        <h4><?php echo $producto->__get('nombre'); ?></h4>
        <details class="description">
          <summary>Descripción:</summary>
          <p><?php echo $producto->__get('descripcion'); ?></p>
        </details>
        <p>Categoria: <?php echo $producto->__get('categoria'); ?></p>
        <p>Precio: <?php echo $producto->__get('precio'); ?></p>
        <p>Cantidad: <?php echo $producto->__get('cantidad'); ?></p>
      </div>
      <a id="crearCompra<?php echo $producto->__get('id'); ?>" onclick="accionCarroCompra(<?php echo isset($this->usuario) ? $this->usuario->__get('id') : 0; ?>, <?php echo $producto->__get('id'); ?>, 'crear')" class="button-user button-success btn-hover">Agregar a carrito</a>
    </div>
  </article>
  <?php endforeach; ?>
</div>
<?php else: ?>
  <div>
    <p class="messages">Lo sentimos! 
      No se encontraron productos</p>
  </div>
<?php endif; ?>
