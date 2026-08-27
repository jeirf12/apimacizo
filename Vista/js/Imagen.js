import { loadChangeEvent } from "./Events.js";

let element = document.getElementById("imagen-register");
let input = document.getElementById("imagen");

const inputImage = (event) => {
  let name = event.target.value;
  let allowedExtensions = /(.jpeg|.jpg|.png)$/i;

  if(!allowedExtensions.exec(name)) {
    Popup.show("error", "El archivo no es una imagen válida")
    event.target.value = "";
    return;
  } 
  
  if(!element.classList.contains("open-imagen")) {
    element.classList.add("open-imagen");
  }

  element.children[0].src = URL.createObjectURL(event.target.files.item(0));
};

Popup.init();
if(input) loadChangeEvent(input, inputImage);
