let dataPaises = [];
let dataDepartamentos = [];
let dataMunicipios = [];

/**
 * Cargar archivos JSON
 */
async function loadLocationData() {
    try {
        const [paisesRes, deptosRes, municipiosRes] = await Promise.all([
            fetch("../data/countries(1).json"),
            fetch("../data/states.json"),
            fetch("../data/citiesjson/cities.json")
        ]);

        dataPaises = await paisesRes.json();
        dataDepartamentos = await deptosRes.json();
        dataMunicipios = await municipiosRes.json();

        loadPaises();
    } catch (error) {
        console.error("Error cargando datos de ubicación:", error);
    }
}

/**
 * Llenar select de países
 */
function loadPaises(selected = "") {
    const selectPais = document.getElementById("pais");
    selectPais.innerHTML = `<option value="">Seleccione un país</option>`;

    dataPaises.forEach(p => {
        const option = document.createElement("option");
        option.value = p.codigo;
        option.textContent = p.nombre;

        if (selected && selected === p.codigo) option.selected = true;

        selectPais.appendChild(option);
    });

    if (selected) loadDepartamentos(selected);
}

/**
 * Llenar departamentos por país
 */
function loadDepartamentos(codigoPais, selected = "") {
    const selectDepto = document.getElementById("departamento");
    const selectMuni = document.getElementById("municipio");

    selectDepto.innerHTML = `<option value="">Seleccione un departamento</option>`;
    selectMuni.innerHTML = `<option value="">Seleccione un municipio</option>`;

    const filtered = dataDepartamentos.filter(d => d.pais === codigoPais);

    filtered.forEach(dep => {
        const option = document.createElement("option");
        option.value = dep.codigo;
        option.textContent = dep.nombre;

        if (selected && selected === dep.codigo) option.selected = true;

        selectDepto.appendChild(option);
    });

    if (selected) loadMunicipios(selected);
}

/**
 * Llenar municipios por departamento
 */
function loadMunicipios(codigoDepto, selected = "") {
    const selectMuni = document.getElementById("municipio");
    selectMuni.innerHTML = `<option value="">Seleccione un municipio</option>`;

    const filtered = dataMunicipios.filter(m => m.departamento === codigoDepto);

    filtered.forEach(m => {
        const option = document.createElement("option");
        option.value = m.codigo;
        option.textContent = m.nombre;

        if (selected && selected === m.codigo) option.selected = true;

        selectMuni.appendChild(option);
    });
}

/**
 * Eventos de cambio
 */
document.addEventListener("DOMContentLoaded", () => {
    loadLocationData();

    document.getElementById("pais").addEventListener("change", (e) => {
        loadDepartamentos(e.target.value);
    });

    document.getElementById("departamento").addEventListener("change", (e) => {
        loadMunicipios(e.target.value);
    });
});

/**
 * Función para edición de clientes
 * Se mandan los valores actuales guardados en la BD
 */
function preloadLocation(pais, departamento, municipio) {
    // Cargar países y seleccionar el correcto
    loadPaises(pais);

    // Cargar departamentos del país y seleccionar el correcto
    loadDepartamentos(pais, departamento);

    // Cargar municipios del departamento y seleccionar el correcto
    loadMunicipios(departamento, municipio);
}
