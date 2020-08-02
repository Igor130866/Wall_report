// $(document).ready(function() {
//  alert(jQuery.fn.jquery);
//});  
function showErrorMessageMail(message) {
  let messageEmail = form.querySelector('.error-email');
  messageEmail.classList.remove("d-none");
  messageEmail.innerHTML = message;
}

function showErrorMessageName(message) {
  let messageName = form.querySelector('.error-name');
  messageName.classList.remove("d-none");
  messageName.innerHTML = message;
}

function showErrorMessagePass(message) {
  let messagePass = form.querySelector('.error-pass');
  messagePass.classList.remove("d-none");
  messagePass.innerHTML = message;
}

function showErrorMessagePassrepeat(message) {
  let messagePassrepeat = form.querySelector('.error-passrepeat');
  messagePassrepeat.classList.remove("d-none");
  messagePassrepeat.innerHTML = message;
}

function showErrorMessageLogin(message) {
  let messageLogin = form.querySelector('.error-message');
  messageLogin.classList.remove("d-none");
  messageLogin.innerHTML = message;
  messageLogin.style.fontSize = "1.5rem";
}
//# sourceMappingURL=../maps/main.js.map
