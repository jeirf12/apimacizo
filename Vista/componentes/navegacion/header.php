<header class="header">
<div class="logo"><a href="?c=sesion&a=inicio"><img src="Vista/css/logo.png" alt="logo" height="70"></a></div>
  <div class="bar-search">
    <form id="frm-busqueda" class="frm-busqueda" action="?c=producto&a=buscarProducto" method="POST">
        <div class="grupo-busqueda">
          <input class="input-search" type="text" name="word_search" placeholder="Busca tu producto aqui" >
          <span class="barra-busqueda"></span>
        </div>
        <div>
          <button name="btn-search" type="submit"><i class="fa-solid fa-magnifying-glass" ></i></button>
        </div>
    </form>
  </div>
  <div class="header-left">
      <nav class="navigation">
        <ul>
          <li><a class="nav-inicio">Inicio</a></li>
          <li><a class="nav-about">Sobre Nosotros</a></li>
          <li><a class="nav-productos">Productos</a></li>
          <?php if(!$this->existeSesion || $this->usuario->__get('rol') == 'noadmin'): ?>
            <li><a class="nav-contacto">Contacto</a></li>
          <?php endif; ?>
          <?php if($this->existeSesion): ?>
          <li>
          <div class="info-user">
            <div class="dropdown" id="btnOpenDropdown">
            <button title="Cuenta: <?php echo $this->usuario->__get('rol'); ?>" class="button-close button-danger"><i class="fa-solid fa-arrow-right-to-bracket button-admin open-btn"></i></button>
              <div id="myDropdown" class="dropdown-menu">
                <a class="btn-dropmenu">
                  <span  class="lbl-usuario">
                  <?php echo $this->usuario->__get('nombre'); ?>
                  </span>
                </a>
                <a class="btn-dropclose button-red" href="?c=sesion&a=cerrarSesion" type="submit">cerrar sesión</a>
              </div>
            </div>
          </div>
          </li>
          <?php else:?>
          <li>
            <a class="nav-iniciosesion">Iniciar Sesión</a>
          </li>
          <?php endif; ?>
        </ul>
      </nav>
      <div class="menu-icon">
        <i class="fa-solid fa-bars"></i>
      </div>
  </div>
  <script type="module" src="Vista/js/Menu.js"></script>
</header>
