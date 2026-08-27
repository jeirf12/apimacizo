<form class="form-register" action="?c=sesion&a=registroUsuario" method="post">
  <h1 class="h1color">Registro Usuario</h1>
  <label for="name">Nombre:</label>
  <input type="text"  class="frm_input_tbox"  name="nombre" placeholder="Escriba su nombre" required>
  <label for="email">Correo:</label>
  <input type="email"  class="frm_input_tbox"  name="correo" placeholder="Escriba su correo" required>
  <label for="password">Contraseña:</label>
  <input type="password"  class="frm_input_tbox"  name="contrasenia" placeholder="Escriba su contraseña" required>
  <?php require_once "Vista/componentes/navegacion/botonVolver.php"; ?>
  <button class="button-user button-success btn-hover" type="submit">Registrarse</button>
</form>
