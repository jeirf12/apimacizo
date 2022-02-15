<!DOCTYPE html>
<html lang="en">
  <?php require_once "Vista/header.php"; ?>
  <div class="container">
    <div class="content-button">
    <a class="button-success" type="submit" href="?c=Producto&a=CrearEditar">Agregar</a>
    </div>
    <?php if(isset($this->productos)): ?>
    <table>
      <thead>
        <tr>
          <th>Imagen</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Cantidad</th>
          <th>descripcion</th>
          <th>Categoria</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($this->productos as $producto): ?>
        <tr>
          <td><img src="<?php echo "data:image/jpeg; base64,".base64_encode($producto->__get('imagen')).'"'; ?>" alt="Avatar-product" width="20%"></td>
          <td><?php echo $producto->__get('nombre'); ?></td>
          <td><?php echo $producto->__get('precio'); ?></td>
          <td><?php echo $producto->__get('cantidad'); ?></td>
          <td><?php echo $producto->__get('descripcion'); ?></td>
          <td><?php echo $producto->__get('categoria'); ?></td>
          <div class="button-admin">
            <td><a class="button-google" type="submit" href="?c=Producto&a=CrearEditar&proid=<?php echo $producto->__get('id'); ?>">editar</a></td>
            <td><a id="#miModal" class="button-danger">eliminar</a></td>
          </div>
          <div id="miModal" class="modal">
            <div class="modal-content">
              <a href="#" id="close" class="close">X</a>
              <p>Desea eliminar el producto?</p>
              <a href="?c=Sesion&a=VolverPrincipal">no</a>
              <a href="?c=Producto&a=Eliminar&id=<?php echo $producto->__get('id'); ?>">si</a>
            </div>  
          </div>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
      <div class="content-messages">
        <p class="messages">No hay productos registrados todavia</p>
      </div>
    <?php endif; ?>
  </div>
  <script src="js/modal.js"></script>
</body>
</html>
