## Gestión de estudiantes con mapas y herencia en PHP

## Descripción y objetivo
Aplicación en PHP que registra y consulta estudiantes mediante peticiones HTTP `GET` y `POST`.
Los estudiantes se almacenan en una estructura tipo **mapa** (clave = código del estudiante),
aplicando **herencia** (`Estudiante` extiende `Persona`), **encapsulamiento** (propiedades privadas con
getters/setters) y **tipos estrictos** (`declare(strict_types=1);`).

## Requisitos
- XAMPP con Apache y PHP 8.1 o superior
  Link de descarga de XAMPP: `https://www.apachefriends.org/download.html`
- Navegador web 

## Instalación y ejecución en XAMPP
1. Instalar XAMPP e iniciar **Apache** desde el panel de control.
2. Clonar la carpeta desde nuestro CMD para almacenarlo en la carpeta de XAMPP
```
cd C:\xampp\htdocs
git clone https://github.com/estjuanantoniomoyaob-web/Estudiante-PHP-H4.git estudiantes-php
```
4. Abrir en el navegador: `http://localhost/estudiantes-php/`

## Registro inicial
Al ejecutar la aplicación ya existe un estudiante registrado por defecto 
definido en `MapaEstudiantes::registrarInicial()`.

## Uso de las peticiones

GET: lista de estudiantes registrados
```
http://localhost/estudiantes-php/api.php
```
GET: consultar por el código del estudiante 
```
http://localhost/estudiantes-php/api.php?codigo=10914005
```
Respuesta:
```json
{ "exito": true, "estudiante": { "codigo": "10914005", "nombre": "Juan Antonio", "apellido": "Moya Oblitas", "edad": 20, "carrera": "Ingeniería en Sistemas " } }
```

POST: registrar
Campos requeridos: `codigo`, `nombre`, `apellido`, `edad`, `carrera`.
Ejemplo de registro 1
```
curl -X POST http://localhost/estudiantes-php/api.php -H "Content-Type: application/json" -d "{\"codigo\":\"12402345\",\"nombre\":\"Jessica Dabeyba\",\"apellido\":\"Pérez Chura\",\"edad\":19,\"carrera\":\"Comercio Internacional\"}"
```
GET:consultar por el código del estudiante 
```
http://localhost/estudiantes-php/api.php?codigo=12402345
```
Ejemplo de registro 2
```
curl -X POST http://localhost/estudiantes-php/api.php -H "Content-Type: application/json" -d "{\"codigo\":\"10403242\",\"nombre\":\"Andy Jhulian\",\"apellido\":\"Morales Paredes\",\"edad\":20,\"carrera\":\"Ingenieria Civil\"}"
```
GET: consultar por el código del estudiante 
```
http://localhost/estudiantes-php/api.php?codigo=10403242
```
GET: Para la verificación de los estudiantes agregados
```
http://localhost/estudiantes-php/api.php
```

## Formulario web
Abrir el navegador a `http://localhost/estudiantes-php/` y completar los campos y pulsar **Registrar (POST)**. El registro se guardar y se tendrá una vista de registro recién echo y el botón **Consultar (GET)** actualiza la tabla al buscar un estudiante por su codigo.
