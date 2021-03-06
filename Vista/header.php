<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="Vista/css/style.css">
  <link rel="stylesheet" type="text/css" href="Vista/css/card.css">
  <link rel="stylesheet" type="text/css" href="Vista/css/popup.css">
  <link rel="stylesheet" type="text/css" href="Vista/css/contacto.css">
  <link rel="stylesheet" type="text/css" href="Vista/css/dropdown.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="Vista/js/popup.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 
  <title><?php echo isset($this->nombrePagina) ? $this->nombrePagina : " "; ?></title>
</head>
<body>
  <header class="header">
    <div class="logo" ><img src="Vista/css/logo.png" alt="logo" height="70"></div>
    <div class="bar-search">
      <form id="frm-busqueda" action="?c=Producto&a=BuscarProducto" method="POST">
          <input type="text" name="word_search" placeholder="Busca tu producto aqui" >
          <button name= "btn-search" type="submit"><i class="fa-solid fa-magnifying-glass" ></i></button>
      </form>
    </div>
    <div class="header-left">
      <div class="center-header">
        <nav class="navigation">
          <ul>
            <li><a href="?c=Sesion&a=Inicio" class="nav-inicio">Inicio</a></li>
            <li><a href="?c=Sesion&a=About" class="nav-about">Sobre Nosotros</a></li>
            <li><a href="?c=Producto&a=Listar" class="nav-productos">Productos</a></li>
            <?php if((isset($this->existeSesion) && !$this->existeSesion) || $this->usuario->__get('rol') == 'noadmin'): ?>
            <li><a href="?c=Sesion&a=Contacto" class="nav-contacto">Contacto</a></li>
            <?php endif; ?>
          </ul>
        </nav>
      </div>
      <?php if(isset($this->existeSesion) && $this->existeSesion): ?>
      <div class="info-user">
        <div class="dropdown">
        <button title="Cuenta: <?php echo $this->usuario->__get('rol'); ?>" class="button-close button-danger"><i onclick="openModal();" class="fa-solid fa-arrow-right-to-bracket button-admin open-btn"></i></button>
          <div id="myDropdown" class="dropdown-menu">
            <a class="btn-dropmenu">
              <span  class="lbl-usuario">
              <?php echo $this->usuario->__get('nombre'); ?>
              </span>
            </a>
            <a class="btn-dropclose button-red" href="?c=Sesion&a=CerrarSesion" type="submit">cerrar sesi??n</a>
          </div>
        </div>
      </div>
      <?php else:?>
        <div class="inicio-button"><a href="?c=Sesion&a=iniciarSesion">Iniciar Sesion</a></div>
      <?php endif; ?>
      <div class="menu-icon">
        <i class="fa-solid fa-bars"></i>
      </div>
    </div>
    <script src="Vista/js/menu.js"></script>
  </header>
  <?php if(isset($this->message) && !empty($this->message)) { require_once "Vista/popup.php"; } ?>
