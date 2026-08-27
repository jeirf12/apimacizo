<!DOCTYPE html>
<html lang="es">
  <?php require_once "Vista/componentes/navegacion/head.php" ?>
  <body>
    <?php require_once "Vista/componentes/navegacion/popup.php"; ?>
    <?php require_once "Vista/componentes/navegacion/header.php"; ?>
    <div class="container">
      <?php require_once $this->vistaEnvoltura; ?>
    </div>
    <?php require_once "Vista/componentes/navegacion/footer.php"; ?>
    <?php if(isset($this->message)): ?>
    <script>
      Popup.init();
      <?php if(isset($this->isDelete) && $this->isDelete == true): ?>
        <?php echo "Popup.show('".$this->action."', '".$this->message."', true);"; ?>
      <?php else: ?>
        <?php echo "Popup.show('".$this->action."', '".$this->message."');"; ?>
      <?php endif; ?>
    </script>
    <?php endif; ?>
  </body>
</html>
