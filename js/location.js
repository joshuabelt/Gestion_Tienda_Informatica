document.addEventListener("DOMContentLoaded", () => {

  const paisSelect = document.getElementById("pais");
  const deptoSelect = document.getElementById("departamento");
  const muniSelect = document.getElementById("municipio");

  if (!paisSelect || !deptoSelect || !muniSelect) return;

  const API_KEY = "Q3NLa2JUOVhKTTFWYlQ0c3hjWHBubHFZR2hPeUtFTnJGZG5lcDJPcw==";
  const BASE_URL = "https://api.countrystatecity.in/v1";

  const headers = {
    "X-CSCAPI-KEY": API_KEY
  };

  // 🔹 Cargar países
  fetch(`${BASE_URL}/countries`, { headers })
    .then(res => res.json())
    .then(countries => {

      paisSelect.innerHTML = `<option value="">Seleccione un país</option>`;

      countries.forEach(c => {
        const selected = (OLD?.pais === c.iso2) ? 'selected' : '';
        paisSelect.innerHTML += `
          <option value="${c.iso2}" ${selected}>${c.name}</option>`;
      });

      if (OLD?.pais) paisSelect.dispatchEvent(new Event('change'));
    });

  paisSelect.addEventListener("change", () => {

    deptoSelect.innerHTML = `<option value="">Seleccione un departamento</option>`;
    muniSelect.innerHTML = `<option value="">Seleccione un municipio</option>`;

    if (!paisSelect.value) return;

    fetch(`${BASE_URL}/countries/${paisSelect.value}/states`, { headers })
      .then(res => res.json())
      .then(states => {

        states.forEach(s => {
          const selected = (OLD?.departamento === s.iso2) ? 'selected' : '';
          deptoSelect.innerHTML += `
            <option value="${s.iso2}" ${selected}>${s.name}</option>`;
        });

        if (OLD?.departamento) deptoSelect.dispatchEvent(new Event('change'));
      });
  });

  deptoSelect.addEventListener("change", () => {

    muniSelect.innerHTML = `<option value="">Seleccione un municipio</option>`;

    if (!paisSelect.value || !deptoSelect.value) return;

    fetch(`${BASE_URL}/countries/${paisSelect.value}/states/${deptoSelect.value}/cities`, { headers })
      .then(res => res.json())
      .then(cities => {

        cities.forEach(city => {
          const selected = (OLD?.municipio === city.name) ? 'selected' : '';
          muniSelect.innerHTML += `
            <option value="${city.name}" ${selected}>${city.name}</option>`;
        });
      });
  });

});




