<?php
//definimos la clase biblioteca
class Biblioteca {
    //array para la coleccion de libros y otro para los usuarios
    private string $nombre;
    private array $libros = [];
    private array $usuarios = [];         

    //constructor
    //recibe el nomnbre de la biblioteca y lo asigna al atributo nombre
    public function __construct(string $nombre) {
        $this->nombre = $nombre;
    }

    //metodo para agregar un libro a la biblioteca
    //este metodo obtiene el isbn del libro y lo usa para agregar el libro al array de libros
    public function agregarLibro(Libro $libro): void {
        $isbn = $libro->getIsbn();
        $this->libros[$isbn] = $libro;
    }

    //metodo que devuelve un array con la info de los libros disponibles 
    public function listarLibrosDisponibles():array
    {
        $disponibles = [];
        foreach ($this->libros as $libro) {
            if ($libro->estaDisponible()) {
                $disponibles[] = $libro->getInfo();
            }
        }
        return $disponibles;
    }

    //metodo para registrar un usuario en la biblioteca
    public function registrarUsuario(Usuario $usuario): void {
        $id = $usuario->getId();
        $this->usuarios[$id] = $usuario;
    }

    //metodo que devuelve un libro por su isbn
    public function getLibroPorIsbn(string $isbn): ?Libro {
        return $this->libros[$isbn] ?? null;
    }

    //metodo que presta libro a un usuario
    //verifica primero que el usuario y el libro existan
    public function prestarLibro(int $id, string $isbn): bool
    {
        if (!isset($this->usuarios[$id]) || !isset($this->libros[$isbn])) {
            echo "Libro o usuario no encontrado<br>";
            return false;
        }
        $libro = $this->libros[$isbn];
        $usuario = $this->usuarios[$id];

        //presta el libro usando el metodo pedirLibro del usuario
        //si no existe el usuario o el libro, devuelve que no se pudo prestar
        if (!$usuario->pedirLibro($libro)) {
            echo "No se pudo prestar el libro<br>";
            return false;
        }
        return true;
    }

    //metodo que recibe un libro devuelto por un usuario
    public function recibirLibro(int $idUsuario, string $isbn): bool
    {
        if (!isset($this->usuarios[$idUsuario]) || !isset($this->libros[$isbn])) {
            echo "Libro o usuario no encontrado<br>";
            return false;
        }
        $usuario = $this->usuarios[$idUsuario];
        if ($usuario->devolverLibro($isbn)) {
            //el libro se marca como disponible en devolverLibro()
            return true;
        } else {
            echo "El usuario no tiene este libro prestado<br>";
            return false;
        }
    }
    
    //metodo para devolver el resumen de los prestamos
    //devuelve un array asociativo donde la clave es el nombre del usuario
    public function resumenPrestamos(): array {
        $resumen = [];
        //recore todos los usuarios registrados
        foreach ($this->usuarios as $usuario) {
            //obtiene los libros prestados al usuario
            $libros = $usuario->verLibrosPrestados();
            if (!empty($libros)) {
                //agrega al array resumen el nombre del usuario
                //y un array con los titulos de los libros prestados
                $resumen[$usuario->getNombre()] = array_map(function($libro) {
                    return $libro->getTitulo();
                }, $libros);
            }
        }
        return $resumen;
    }
}
?>