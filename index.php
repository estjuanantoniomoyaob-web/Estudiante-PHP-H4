<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro de estudiantes</title>
</head>
<body>
<h1>Registro de estudiantes</h1>

<form id="formulario">
  <input name="codigo" placeholder="Código" required><br>
  <input name="nombre" placeholder="Nombre" required><br>
  <input name="apellido" placeholder="Apellido" required><br>
  <input name="edad" type="number" placeholder="Edad" required><br>
  <input name="carrera" placeholder="Carrera" required><br>
  <button type="submit">Registrar</button>
</form>

<p id="resultado"></p>

<h2>Estudiantes</h2>
<input id="buscar" placeholder="Código Estudiante">
<button id="recargar">Consultar</button>
<p id="mensajeGet"></p>
<table border="1" cellpadding="5">
  <thead><tr><th>Código</th><th>Nombre</th><th>Apellido</th><th>Edad</th><th>Carrera</th></tr></thead>
  <tbody id="lista"></tbody>
</table>

<script>
async function cargar() {
  const codigo = document.getElementById('buscar').value.trim();
  const r = await fetch('api.php' + (codigo ? '?codigo=' + encodeURIComponent(codigo) : ''));
  const data = await r.json();
  const filas = data.estudiantes ? Object.values(data.estudiantes) : (data.estudiante ? [data.estudiante] : []);
  document.getElementById('mensajeGet').textContent = `[${r.status}] ` + (data.mensaje ?? 'Consulta exitosa');
  document.getElementById('lista').innerHTML = filas.map(e =>
    `<tr><td>${e.codigo}</td><td>${e.nombre}</td><td>${e.apellido}</td><td>${e.edad}</td><td>${e.carrera}</td></tr>`
  ).join('');
}

document.getElementById('formulario').addEventListener('submit', async (ev) => {
  ev.preventDefault();
  const r = await fetch('api.php', { method: 'POST', body: new FormData(ev.target) });
  const data = await r.json();
  document.getElementById('resultado').textContent = `[${r.status}] ${data.mensaje}`;
  if (data.exito) { ev.target.reset(); cargar(); }
});

document.getElementById('recargar').addEventListener('click', cargar);
cargar();
</script>
</body>
</html>