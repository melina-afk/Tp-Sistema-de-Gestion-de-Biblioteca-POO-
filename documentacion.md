<!-- omit in toc -->
# Documentación Sistema de Gestión de Biblioteca
<!-- omit in toc -->
### Alumnas: Beloqui Melina y Jauregui Martina 
<!-- omit in toc -->
# Tabla de Contenidos
- [Introducción](#introducción)
- [Clases del Proyecto](#clases-del-proyecto)
  - [Clase Biblioteca](#clase-biblioteca)
    - [Atributos:](#atributos)
    - [Métodos principales:](#métodos-principales)
  - [Clase Libro](#clase-libro)
    - [Atributos:](#atributos-1)
    - [Métodos destacados:](#métodos-destacados)
  - [Clase Usuario](#clase-usuario)
    - [Atributos:](#atributos-2)
    - [Métodos principales:](#métodos-principales-1)
- [Funcionamiento del Sistema](#funcionamiento-del-sistema)
- [Ejemplo de Uso (index.php)](#ejemplo-de-uso-indexphp)

# Introducción
Este proyecto simula un sistema de gestión de bibliotecas, diseñado para administrar el préstamo y la devolución de libros. Está implementado en PHP e implementa los principios fundamentales de la Programación Orientada a Objetos (POO), basada en cuatro clases principales: Biblioteca, Libro, Usuario, y un main (index.php) donde se simule la interacción entre los usuarios, los libros y la biblioteca.
En este sistema podremos encontrar:

* Gestión de una colección de libros.
* Registrar usuarios con posibilidad de préstamo.
* Controlar el estado de cada libro (si esta disponible o prestado).
* Realizar préstamos y devoluciones.
* Obtener un resumen de los préstamos.

# Clases del Proyecto

## Clase Biblioteca

Es la entidad principal del sistema. Su responsabilidad es gestionar los libros disponibles y los usuarios registrados. También se encarga de las operaciones clave del sistema, como registrar usuarios, prestar libros y generar resumenes de los prestamos.
### Atributos:
* nombre (de la biblioteca)
* libros (array para la coleccion de libros)
* usuarios (array para la coleccion de usuarios)
### Métodos principales:

* `agregarLibro(Libro $libro)`: Añade un libro a la colección.
* `listarLibrosDisponibles()`: Devuelve un array con los libros disponibles.
* `registrarUsuario(Usuario $usuario)`: Registra un nuevo usuario.
* `prestarLibro(int $idUsuario, string $isbn)`: Presta un libro a un usuario si está disponible.
* `recibirLibro(int $idUsuario, string $isbn)`: Procesa la devolución de un libro.
* `resumenPrestamos()`: Genera un resumen de los libros actualmente prestados por usuario.

```
<?php
class Biblioteca {
    private string $nombre;
    private array $libros = [];
    private array $usuarios = [];

    public function __construct(string $nombre) {
        $this->nombre = $nombre;
    }
}
?>
```
## Clase Libro

Modela un libro individual dentro de la biblioteca. Contiene información básica (título, autor, ISBN) y su estado de disponibilidad.

### Atributos:

* titulo
* autor
* isbn
* disponible (booleano que indica si el libro puede ser prestado)

### Métodos destacados:

* `prestar()`: Cambia el estado a no disponible.
* `devolver()`: Marca el libro como disponible.
* `estaDisponible()`: Retorna un booleano indicando si el libro puede prestarse.
* Métodos getters para obtener los datos del libro. (getInfo, getAutor, getTitulo, getIsbn)

```
<?php
class Libro
{
    private string $titulo;
    private string $autor;
    private string $isbn;
    private bool $disponible;

    //constructor para inicializar el libro con un titulo, autor e isbn
    //el libro se inicializa como disponible por defecto
    public function __construct(string $titulo, string $autor, string $isbn) {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->isbn = $isbn;
        $this->disponible = true;
}
?>
```
## Clase Usuario

Representa a una persona registrada en la biblioteca. Un usuario puede solicitar préstamos y devolver libros.

### Atributos:

* id (único por usuario)
* nombre
* librosPrestados (array de objetos Libro)

### Métodos principales:

* `pedirLibro(Libro $libro)`: Intenta tomar un libro en préstamo.
* `devolverLibro(string $isbn)`: Devuelve un libro basado en el ISBN.
* `verLibrosPrestados()`: Devuelve todos los libros actualmente en posesión del usuario.

```
<?php
class Usuario {
   private int $id;
    private string $nombre;
    private array $librosPrestados = [];

    //constructor para inicializar el usuario con un id y un nombre

    public function __construct(int $id, string $nombre) {
        $this->id = $id;
        $this->nombre = $nombre;
    }

}
?>
```
# Funcionamiento del Sistema

1. Inicialización

Se crea una instancia de la biblioteca. Luego, se crean instancias de libros y usuarios. Este paso se realiza en index.php.

 2. Carga de Libros

Los objetos Libro se agregan a la biblioteca mediante agregarLibro(). La biblioteca mantiene todos los libros (prestados y disponibles).

 3. Registro de Usuarios

Cada objeto Usuario se registra con registrarUsuario(), y se almacena según su ID único.

 4. Préstamo de Libros

Cuando un usuario solicita un préstamo, se llama a prestarLibro() en la biblioteca. Este método:

* Verifica si el libro está disponible.
* Si lo está, llama a pedirLibro() del usuario y a prestar() del libro.
* El libro se registra como prestado al usuario.

5. Devolución de Libros

El método recibirLibro() realiza la operación inversa:

* Busca el libro en los préstamos del usuario.
* Llama a devolverLibro() y marca el libro como disponible.

6. Consulta de Disponibilidad

El método listarLibrosDisponibles() muestra únicamente los libros con estado disponible.

7. Resumen de Préstamos

Con resumenPrestamos(), se puede generar un informe con el nombre de cada usuario y la lista de títulos que tiene en préstamo actualmente.

# Ejemplo de Uso (index.php)

```<?php
require_once 'biblioteca.php';
require_once 'libro.php';
require_once 'usuario.php';

$biblioteca= new Biblioteca("Biblioteca ");

//crear los libros
$libro1= new Libro("La princesa y el Sapo", "Julio Borges", "1313");
$libro2= new Libro("Kick Buttowski", "Isabel Allende", "1314");
$libro3= new Libro("El Principito", "Antoine de Saint-Exupéry", "1315");

//agregar los libros a la biblioteca
$biblioteca->agregarLibro($libro1);
$biblioteca->agregarLibro($libro2);  
$biblioteca->agregarLibro($libro3);

//crea usuario
$usuario1= new Usuario(1, "Joel");
$usuario2= new Usuario(2, "Carla");

//registrar los usuarios
$biblioteca->registrarUsuario($usuario1);
$biblioteca->registrarUsuario($usuario2);

//mostrar libros disponibles (antes de prestar)
echo "Libros que estan disponibles: \n". "<br>";
$librosDisponibles = $biblioteca->listarLibrosDisponibles();
foreach ($librosDisponibles as $libro) 
{
    echo "Titulo: " . $libro['titulo'] . ", Autor: " . $libro['autor'] . ", ISBN: " . $libro['isbn'] . "\n". "<br>";
}
?>
```