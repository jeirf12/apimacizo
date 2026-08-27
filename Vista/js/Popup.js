const Popup = {
  init() {
    this.hideTimeout = null;
    this.action = { "success": "check", "warning": "exclamation", "error": "xmark" };
    this.element = document.getElementById("myPopup");
    this.buttons = document.getElementById("popup-buttons")
    this.content = document.getElementById("myPopupContent");
  },
  show(state, message, withButton) {
    clearTimeout(this.hideTimeout);
    this.element.classList.remove("popup-invisible");
    if (state) {
      this.content.classList.add("popup-"+state);
      document.getElementById("message-icon-popup").textContent = message;
      document.getElementById("icon-popup").classList.add(`fa-circle-${this.action[state]}`);
    }

    if(withButton) {
      this.content.style.animationDuration = "2s";
      this.content.style.transform = "translateY(10px)";
      this.content.style.margin = "20% auto";
      this.buttons.classList.remove("popup-buttons-invisible");
      document.getElementById('popup-cancel').onclick = () => {
        this.element.classList.add("popup-invisible");
        this.buttons.classList.add("popup-buttons-invisible");
      };
      document.getElementById('popup-ok').onclick = () => {
        this.element.classList.add("popup-invisible");
        this.buttons.classList.add("popup-buttons-invisible");
      };
    } else {
      this.hideTimeout = setTimeout(() => {
        this.element.classList.add("popup-invisible");
      }, 5000);
    }
  }
};
