<?php

//clase Usuario con atributos privados id, nombre y un array de libros prestados
class Usuario 
{
    private int $id;
    private string $nombre;
    private array $librosPrestados = [];

    //constructor para inicializar el usuario con un id y un nombre
    public function __construct(int $id, string $nombre) {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    //metodo get devuelve el id del usuario
    public function getId(): int {
        return $this->id;
    }

    //metodo get devuelve el nombre del usuario
    public function getNombre(): string {
        return $this->nombre;
    }

    //metodo para pedir un libro prestado
    //recibe un objeto de tipo Libro y devuelve true si el libro se pudo prestar, false en caso contrario
    //es llamado solo por la biblioteca
    public function pedirLibro(Libro $libro): bool {
        $isbn = $libro->getIsbn();

        if (!$libro->estaDisponible()) {
            return false;
        }

        if (isset($this->librosPrestados[$isbn])) {
            return false;
        }

        $libro->prestar();
        $this->librosPrestados[$isbn] = $libro;
        return true;
    }

    //metodo para devolver un libro prestado
    // si se pudo devolver devuelve true, false si no se pudo
    // recibe el isbn del libro a devolver
    //es llamado solo por la biblioteca
    public function devolverLibro(string $isbn): bool {
        if (!isset($this->librosPrestados[$isbn])) {
            return false;
        }

        $this->librosPrestados[$isbn]->devolver();
        unset($this->librosPrestados[$isbn]);
        return true;
    }

    //metodo que devuelve un array con los libros prestados por el usuario
    //cada libro es un objeto de tipo Libro
    public function verLibrosPrestados(): array {
        return $this->librosPrestados;
    }
}

?>