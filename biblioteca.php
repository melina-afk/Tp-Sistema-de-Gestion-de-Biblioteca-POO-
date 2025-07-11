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
    //este metodo obtiene el isbn del libro y lo usa para agregar el objeto libro al array de libros
    public function agregarLibro(Libro $libro): void {
        $isbn = $libro->getIsbn();
        $this->libros[$isbn] = $libro;

    }

    //metodo que devuelve un array con la info de los libros
    //disponibles 
    public function listarLibrosDisponibles():array
    {
        $disponibles = [];
        //foreach para recorrer el array de libros
        //si esta disponible agrega la info al array disponibles
        foreach ($this->libros as $libro) {
            if ($libro->estaDisponible()) {
                $disponibles[] = $libro->getInfo();
            }
        }
        //devuelve el array de los disponibles
        return $disponibles;
    }

    //metodo para registrar un usuario en la biblioteca
    //este metodo obtiene el id del usuario y lo usa para agregar
    //el objeto usuario al array de usuarios
    public function registrarUsuario(Usuario $usuario): void {
        $id = $usuario->getId();
        $this->usuarios[$id] = $usuario;
    }

    //metodo que devuelve un libro por su isbn
    //si el libro no existe, muestra un mensaje
    public function getLibroPorIsbn(string $isbn): Libro {
        if (!isset($this->libros[$isbn])) {
            echo "El libro con isnb $isbn no existe";
        }
        return $this->libros[$isbn];
    }

    //metodo que presta libro a un usuario
    //verifica primero que el usuario y el libro existan

    public function prestarLibro(int $id, string $isbn): bool
    {
        if (!isset($this->usuarios[$id]) || !isset($this->libros[$isbn])) {
            echo "Libro o usuario no encontrado";
            return false;
        }
        //obtiene el libro y el usuario por su isbn e id
        $libro = $this->libros[$isbn];
        $usuario = $this->usuarios[$id];

        //presta el libro usando el metodo pedirLibro del usuario
        if (!$usuario->pedirLibro($libro)) {
            echo "No se pudo prestar el libro";
            return false;
        }

        //retorna true si el libro se pudo prestar
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
        //el usuario intenta devolver el libro
        if ($usuario->devolverLibro($isbn)) {
            //el libro se marca como disponible en devolverLibro()
            return true;
        } else {
            echo "El usuario no tiene este libro prestado<br>";
            return false;
        }
    }
    
    //metodo para devolver el resumen de todos los prestamos
    //devuelve un array con el nombre del usuario y los titulos de los libros prestados
    public function resumenPrestamos(): array {
        $resumen = [];
        //recore todos los usuarios registrados
        foreach ($this->usuarios as $usuario) {
            //obtiene los libros prestados al usuario
            $libros = $usuario->verLibrosPrestados();
            //si el array de libros no esta vacio
            //agrega al array resumen el nombre del usuario y los titulos de los libros prestados
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