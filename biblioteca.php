<?php
class Biblioteca {
    //array para la coleccion de libros y otro para los usuarios
    private string $nombre;
    private array $libros = [];
    private array $usuarios = [];         

    //constructor
    public function __construct(string $nombre) {
        $this->nombre = $nombre;
    }

    //funcion para agregar un libro a la biblioteca
    //este metodo recibe un objeto de tipo Libro y lo agrega al array de libros
    public function agregarLibro(Libro $libro): void {
        $isbn = $libro->getIsbn();
        $this->libros[$isbn] = $libro;

    }
    //muestra los libros disponibles
    public function listarLibrosDisponibles():array
    {
        $disponibles = [];
        //foreach para reccorer el array de libros
        //si esta disponible lo agrega al array disponibles
        foreach ($this->libros as $libro) {
            if ($libro->estaDisponible()) {
                $disponibles[] = $libro->getInfo();
            }
        }
        //devuelve el array de los disponibles
        return $disponibles;
    }

    //funcion para registrar un usuario en la biblioteca
    //este metodo recibe un objeto de tipo Usuario y lo agrega al array de usuarios
    public function registrarUsuario(Usuario $usuario): void {
        $id = $usuario->getId();
        $this->usuarios[$id] = $usuario;
    }

    
    public function getLibroPorIsbn(string $isbn): Libro {
        if (!isset($this->libros[$isbn])) {
            echo "El libro con isnb $isbno no existe";
        }
        return $this->libros[$isbn];
    }

    //presta libro a un usuario
    public function prestarLibro(int $id, string $isbn):bool
    {
        if(!isset($this->usuarios[$id])|| !isset($this->libros[$isbn]))
        {
            echo"Libro o usuario no encontrado";
            return false;
        }
    }


    public function resumenPrestamos(): array {
        $resumen = [];
        foreach ($this->usuarios as $usuario) {
            $libros = $usuario->verLibrosPrestados();
            if (!empty($libros)) {
                $resumen[$usuario->getNombre()] = array_map(function($libro) {
                    return $libro->getTitulo();
                }, $libros);
            }
        }

        return $resumen;
    }
}
?>