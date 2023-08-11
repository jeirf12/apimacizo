const Popup = {
  init() {
    this.hideTimeout = null;
    this.element = document.getElementById("myPopup");
    this.content = document.getElementById("myPopupContent");
  },
  show(state) {
    clearTimeout(this.hideTimeout);
    this.element.classList.remove("popup-invisible");
    if (state) {
      this.content.classList.add("popup-"+state);
    }

    this.hideTimeout = setTimeout(() => {
      this.element.classList.add("popup-invisible");
    }, 5000);
  }
};

document.addEventListener('DOMContentLoaded', () => Popup.init());