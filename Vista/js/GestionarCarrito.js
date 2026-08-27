const accionCarroCompra = (idUsuario, idProducto, accion) => {
  let element = document.getElementById(`${accion}Compra${accion === 'ver' ? idUsuario : idProducto}`);
  if(element && accion !== 'ver') {
    window.location.href = `?c=carrito&a=${accion === 'editar' || accion === 'crear' ? `crearEditar` : `eliminar`}&proid=${idProducto}&usuid=${idUsuario}`;
  } else if(element && accion === 'ver') {
    window.location.href = `?c=carrito&a=listar&codUsu=${idUsuario}`;  
  }
}

const popupQuitarCompra = (mensaje, idUsuario, idProducto, accion) => {
  Popup.init();
  Popup.show('warning', mensaje, true);
  let ok = document.getElementById('popup-ok');
  ok.addEventListener('click', () => {
    accionCarroCompra(idUsuario, idProducto, accion);
  });
}
