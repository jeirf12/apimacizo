<form class="form-login" action="?c=sesion&a=existeusuario" method="post">
  <h1 class="h1color">Iniciar Sesión</h1>
  <label for="correo">Correo:</label>
  <input type="email" class="frm_input_tbox" name="correo" placeholder="Escriba su correo">
  <label for="contrasenia">Contraseña:</label>
  <input type="password" class="frm_input_tbox" name="contrasenia" placeholder="Escriba su contraseña">
  <a class="lnk_olvidecontrasenia" href="">¿Has olvidado la contraseña?</a>
  <button class="button-admin button-success btn-hover" type="submit">Iniciar Sesión</button>
  <button class="button-admin button-danger btn-hover" type="submit" formaction="?c=sesion&a=registrarUsuario">¿No tienes una cuenta? ¡Créala aquí!</button>
  <p>O Inicie sesión con...</p>
  <button class="button-admin button-google btn-hover" type="submit" formaction="?c=sesion&a=google"><i class="fa-brands fa-google">oogle</i></button>
</form>
