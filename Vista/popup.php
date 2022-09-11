<div id="myPopup" class="popup popup-invisible">
  <div id="myPopupContent" class="popup-content">
    <span class="popup-close">&times;</span>
    <?php if($this->action == "success"): ?>
    <i class="fa-solid fa-circle-check"></i>
    <?php elseif($this->action == "warning"): ?>
    <i class="fa-solid fa-circle-exclamation"></i>
    <?php elseif($this->action == "error"): ?>
    <i class="fa-solid fa-circle-xmark"></i>
    <?php endif; ?>
    <p class="icon-message"><?php echo $this->message; ?></p>
  </div>
</div>
<?php
 echo '<script type="text/javascript">';
 echo 'document.addEventListener("DOMContentLoaded", () => Popup.show("'.$this->action.'"));';
 echo '</script>';
?>
