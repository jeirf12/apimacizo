<!DOCTYPE html>
<html lang="en">
  <?php require_once "Vista/header.php"; ?>
  <div class="container">
    <?php require_once "Vista/botonVolver.php"; ?>
    <h1>Carrito de compras</h1>
    <?php if(isset($compras) && !empty($compras)): ?>
      <?php foreach($compras as $compra): ?>
      <div class="card">
        <img src="<?php echo "data:image/jpeg; base64,".base64_encode($compra->__get('imagen')).'"'; ?>" alt="">
        <div class="card-content">
          <h4><?php echo $compra->__get('nombre'); ?></h4>
          <p>cantidad: <span contenteditable="true"><?php echo $compra->__get('cantidad'); ?></span></p>
          <p>Precio total: <?php echo $compra->__get('precio') * $compra->__get('cantidad'); ?></p>
          <div>
            <?php if(isset($editarCarrito) && $editarCarrito): ?>
              <a class="button-google" type="submit" href="?c=Carrito&a=CrearEditar&carid=<?php echo $compra->__get('carid'); ?>&proid=<?php echo $compra->__get('id'); ?>">Editar Compra</a>
            <?php endif; ?>
          </div>
          <div>
            <a class="button-danger" type="submit" href="?c=Carrito&a=Eliminar&carid=<?php echo $compra->__get('carid'); ?>&proid=<?php echo $compra->__get('id'); ?>">Quitar Compra</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="content-messages">
        <p class="messages">No existe compras registradas</p>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
