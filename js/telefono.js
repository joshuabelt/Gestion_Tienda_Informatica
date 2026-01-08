window.iti = null;

document.addEventListener("DOMContentLoaded", () => {

  const input = document.querySelector("#telefono");
  const isoInput = document.querySelector("#pais_iso");
  const form = input.closest("form");
  
  window.iti = intlTelInput(input, {
    initialCountry: "sv",
    separateDialCode: true,
    nationalMode: false,
    utilsScript:
      "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
  });

  // ISO inicial
  isoInput.value = iti.getSelectedCountryData().iso2.toUpperCase();

  // Cambio de país
  input.addEventListener("countrychange", () => {
    isoInput.value = iti.getSelectedCountryData().iso2.toUpperCase();
  });

  // Validación antes de enviar
  form.addEventListener("submit", (e) => {
    if (!iti.isValidNumber()) {
      e.preventDefault();
      alert("Número de teléfono inválido para el país seleccionado");
      return;
    }
    input.value = iti.getNumber();
  });
});




