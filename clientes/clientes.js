// Validar formato de email más estricto
    /*const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Ingrese un email válido');
        return false;
    }
    
    return true;*/

const form = document.getElementById("clienteForm");
const tbody = document.querySelector("#tablaClientes tbody");
const cancelar = document.getElementById("cancelar");

function cargarClientes(){
fetch("api/get_clientes.php")
.then(res=>res.json())
.then(data=>{
 tbody.innerHTML="";
 data.forEach(c=>{
  tbody.innerHTML += `
   <tr>
    <td>${c.nombre} ${c.apellido}</td>
    <td>${c.tipo_cliente}</td>
    <td>${c.telefono}</td>
    <td>${c.email}</td>
    <td>${c.pais}</td>
    <td>
     <button onclick="editar(${c.id})">✏</button>
     <button onclick="eliminar(${c.id})">🗑</button>
    </td>
   </tr>`;
 });
});
}

form.onsubmit = e =>{
 e.preventDefault();

 if(!telefonoValido()){
  alert("Teléfono inválido");
  return;
 }

 const datos = {
  id: cliente_id.value,
  nombre: nombre.value,
  apellido: apellido.value,
  tipo_cliente: document.querySelector("input[name='tipo_cliente']:checked").value,
  telefono: telefonoFormateado(),
  email: email.value,
  pais: pais.value,
  departamento: departamento.value,
  municipio: municipio.value
 };

 fetch(
 cliente_id.value ? "update_clientes.php" : "insert_cliente.php",
 {
  method:"POST",
  body:JSON.stringify(datos)
 }
).then(()=>{
 form.reset();
 cliente_id.value="";
 cargarClientes();
});

};

function editar(id){
 fetch("editclientes.php",{
  method:"POST",
  body:JSON.stringify({id})
 })
 .then(res=>res.json())
 .then(c=>{
  cliente_id.value = c.id;
  nombre.value = c.nombre;
  apellido.value = c.apellido;
  email.value = c.email;
  pais.value = c.pais;
  telefono.value = c.telefono;

  document.querySelector(
   `input[name="tipo_cliente"][value="${c.tipo_cliente}"]`
  ).checked = true;
 });
}

function eliminar(id){
 if(confirm("¿Eliminar cliente?")){
  fetch("delete_cliente.php",{
   method:"POST",
   body:JSON.stringify({id})
  }).then(cargarClientes);
 }
}

cargarClientes();
