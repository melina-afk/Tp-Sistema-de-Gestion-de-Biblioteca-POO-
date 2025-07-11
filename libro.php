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

//marca al libro como prestado
public function prestar(): void {
        $this->disponible= false;
    }

    //esta funcion va a marcar el libro como devuelto/disponible
    public function devolver(): void {
        $this->disponible = true;
    }

    //esta funcion va a devolver si el libro 
    //esta disponible o no
    public function estaDisponible(): bool {
        return $this->disponible;
    }

    //funcion que devuelve la informacion completa de un libro
    //devuelve en un array con el titulo, autor, isbn y si esta disponible o no
    public function getInfo(): array {
        return [
            'titulo' => $this->titulo,
            'autor' => $this->autor,
            'isbn' => $this->isbn,
            'disponible' => $this->disponible
        ];
    }
    //devuelve el titulo de un libro
    public function getTitulo(): string {
        return $this->titulo;
    }

    //devuelve el autor de un libro
    public function getAutor(): string {
        return $this->autor;
    }

    //devuelve el isbn de un libro
    public function getIsbn(): string {
        return $this->isbn;
    }
}
?>