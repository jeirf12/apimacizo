const addParemeterIfneeded = (method, parameter) => {
  return parameter !== "" 
    ? () => method(parameter)
    : method;
};

const loadClickEvent = (element, method, parameter = "") => {
  element.addEventListener("click", addParemeterIfneeded(method, parameter));
};

const loadChangeEvent = (element, method, parameter = "") => {
  element.addEventListener("change", parameter !== "" ? (event) => method(event, parameter) : method);
};

const loadEvent = (element, method, parameter = "") => {
  element.addEventListener(
    "load",
    addParemeterIfneeded(method, parameter),
    true
  );
};
const addResizeEvent = (element, methodResize, parameter = "") => {
  element.addEventListener(
    "resize",
    addParemeterIfneeded(methodResize, parameter)
  );
};

export { loadClickEvent, loadChangeEvent, loadEvent, addResizeEvent };
