const accionProducto = (idproducto, accion) => {
  let element = document.getElementById(`gestion${accion}${idproducto}`);
  if(element) {
    window.location.href = `?c=producto&a=${accion == 'editar' ? `crearEditar&proid=${idproducto}` : `eliminar&id=${idproducto}`}`;
  }
}

const popupEliminar = (mensaje, idProducto, accion) => {
  Popup.init();
  Popup.show('warning', mensaje, true);
  let ok = document.getElementById('popup-ok');
  ok.addEventListener('click', () => {
    accionProducto(idProducto, accion);
  });
}
