<form id="registerProducts" class="form-save" action="?c=producto&a=crear" method="POST" enctype="multipart/form-data">
<h1 class="h1color"><?php echo isset($producto) ? 'Editar' : 'Registrar Nuevo' ?> Producto</h1>
  <input type="hidden" name="id" value="<?php echo (isset($producto)) ? $producto->__get('id') : " " ; ?>">
  <div class="box-imagen">
    <div id="imagen-register" class="show-imagen <?php echo isset($producto) ? 'open-imagen' : ''; ?>">
      <?php 
        $src = "";
        if(isset($producto)) {
          $imagen = $producto->__get('imagen');
          $infoImage = new finfo(FILEINFO_MIME_TYPE);
          $mime_type = $infoImage->buffer($imagen);
          $src = "data:".$mime_type."; base64,".base64_encode($imagen).'"';
        } 
      ?> 
      <img src="<?php echo $src ?>" alt="">
    </div>
    <input class="box-file" type="file" id="imagen" name="imagen" accept=".jpg, .jpeg, .png" required>
    <label for="imagen">
      <strong>Escoga</strong>
      <span class="box-dragdrop">o arrastre la imagen del producto a <?php echo (isset($producto)) ? 'editar' : 'crear' ?></span>
    </label>  
  </div>
  <label for="nombre">Nombre</label>
  <input type="text" name="nombre" value="<?php echo (isset($producto)) ? $producto->__get('nombre') : ""; ?>" required>
  <label for="descripcion">Descripción</label>
  <input type="text" name="descripcion" value="<?php echo (isset($producto)) ? $producto->__get('descripcion') : ""; ?>">
  <label for="cantidad">Cantidad</label>
  <input type="number" name="cantidad" min='1' value="<?php echo (isset($producto)) ? $producto->__get('cantidad') : ""; ?>" required>
  <label for="categoria">Categoria</label>
  <select name="categoria" required>
    <option value="">Seleccione</option>
    <?php foreach($this->categorias as $categoria): ?>
      <?php if(isset($producto) && $producto->__get('categoria') == $categoria['CATPRO_NOMBRE']): ?>
        <?php echo '<option value="'.$categoria['CATPRO_ID'].'" selected>'.$categoria['CATPRO_NOMBRE'].'</option>'; ?>
      <?php else: ?>
        <?php echo '<option value="'.$categoria['CATPRO_ID'].'">'.$categoria['CATPRO_NOMBRE'].'</option>'; ?>
      <?php endif;?>
    <?php endforeach;?>
  </select>
  <label for="precio">Precio/Unidad</label>
  <input type="number" name="precio" min='1' value="<?php echo (isset($producto)) ? $producto->__get('precio') : "" ; ?>" required>
  <?php require_once "Vista/componentes/navegacion/botonVolver.php"; ?>
  <button id="save-product" class="button-user button-success btn-hover" type="submit">Guardar</button>
</form>
