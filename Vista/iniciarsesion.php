<!DOCTYPE html>
<html lang="en">
  <?php require_once "Vista/header.php"; ?>
  <div class="container">
   
    <h1>Iniciar Sesión</h1>
    <form class="form-login" action="?c=Sesion&a=existeusuario" method="post">
      <label for="correo">Correo</label>
      <input type="email" class="frm_input_tbox" name="correo" placeholder="Escriba su correo">
      <label for="contrasenia">Contraseña</label>
      <input type="password" class="frm_input_tbox" name="contrasenia" placeholder="Escriba su contraseña">
      <a  class="lnk_olvidecontrasenia" href="">¿Has olvidado la contraseña</a>
      <button class="button-success" type="submit">Iniciar Sesión</button>
      <button class="button-danger" type="submit" formaction="?c=Sesion&a=RegistrarUsuario">¿No tienes Cuenta? ¡Cree una ahora!</button>
      <span>O Inicie sesión con...</span>
      <button class="button-google" type="submit" formaction="?c=Sesion&a=ApiGoogle"><i class="fa-brands fa-google">oogle</i></button>
    </form>
  </div>
</body>
</html>
