import { loadClickEvent, addResizeEvent, loadEvent } from "./Events.js";

let menu = document.querySelector(".navigation ul");
let container = document.querySelector(".container");
let bodycontact = document.querySelector(".bodyContact");
let containerAbout = document.querySelector(".container-about");
let menuBtn = document.querySelector(".menu-icon");
let inicioBtn = document.querySelector(".nav-inicio");
let aboutBtn = document.querySelector(".nav-about");
let productosBtn = document.querySelector(".nav-productos");
let contactoBtn = document.querySelector(".nav-contacto");
let header = document.getElementsByTagName("header");
let headerLeft = document.querySelector(".header-left");
let navigation = document.getElementsByTagName("nav");

const addClass = () => {
  if (!menu.classList.contains("show")) {
    menu.classList.add("show");
    header[0].classList.add("showResponsiveNavbar");
    headerLeft.classList.add("showResponsiveNavbar");
    navigation[0].style.width = "490px";
  } else removeClass();
};

const removeClass = () => {
  if(menu.classList.contains("show")) {
    menu.classList.remove("show");
    header[0].classList.remove("showResponsiveNavbar");
    headerLeft.classList.remove("showResponsiveNavbar");
    navigation[0].style.width = "0px";
  }
};

const openModal = () => {
  let element = document.getElementById("myDropdown");
  element.classList.toggle("show");
};

const resizeMode = () => {
  if (window.matchMedia("(max-width: 1070px)").matches) {
    navigation[0].style.width = "0px";
  } else {
    navigation[0].style.width = "490px";
    header[0].classList.remove("showResponsiveNavbar");
    headerLeft.classList.remove("showResponsiveNavbar");
  }
};

const openLink = (url) => window.location.href = url;

let i = 0;
let links = [
  '?c=sesion&a=inicio',
  '?c=sesion&a=sobreNosotros',
  '?c=producto&a=listar',
  '?c=sesion&a=contacto',
  '?c=sesion&a=iniciarSesion',
];
for (let ele of menu.children) {
  if(ele.children[0].localName === 'a') loadClickEvent(ele, openLink, links[i++]);
}

let iconBtn = document.getElementById("btnOpenDropdown");
if (iconBtn !== null) iconBtn.addEventListener("click", openModal);
let element = document.getElementsByClassName("popup-close")[0];
let popup = document.getElementById("myPopup");
if (element !== undefined)
  loadClickEvent(element, () => {
    popup.classList.add("popup-invisible");
  });

loadClickEvent(menuBtn, addClass);
loadClickEvent(inicioBtn, removeClass);
loadClickEvent(aboutBtn, removeClass);
loadClickEvent(productosBtn, removeClass);
addResizeEvent(window, resizeMode);
loadEvent(window, resizeMode);
if (contactoBtn !== null) loadClickEvent(contactoBtn, removeClass);
if (container !== null) loadClickEvent(container, removeClass);
if (containerAbout !== null) loadClickEvent(containerAbout, removeClass);
if (bodycontact !== null) loadClickEvent(bodycontact, removeClass);
