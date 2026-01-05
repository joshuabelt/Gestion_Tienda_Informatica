let iti;

document.addEventListener("DOMContentLoaded", () => {

  const input = document.querySelector("#telefono");
  if (!input) return;

  iti = intlTelInput(input, {
    initialCountry: "sv", // default fijo
    separateDialCode: true,
    nationalMode: false,
    utilsScript:
      "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
  });

  if (typeof OLD !== "undefined" && OLD.telefono) {
    iti.setNumber(OLD.telefono);
  }
});




