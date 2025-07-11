<?php
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
//pedir libro con usuario1 SIMULACION
echo"<br> Joel pide 'El principito': \n". "<br>";
if($usuario1->pedirLibro($libro3))
{
    echo "Libro prestado con exito". "<br>";
    $libro3->prestar(); 
}
else
{
    echo "No se pudo prestar el libro: 'El principito ' a $usuario1.$nombre". "<br>";
}
//pedir libro con usuario2 SIMULACION
echo"<br> Carla pide 'Kick Buttowski': \n". "<br>";
if($usuario2->pedirLibro($libro2))
{
    echo "Libro prestado con exito". "<br>";
    $libro2->prestar(); 
}
else
{
    echo "No se pudo prestar el libro: ". $libro2->getTitulo(). "a". $usuario2->getNombre()."<br>";
}

// usuario1 intenta pedir un libro ya prestado
echo "<br>". $usuario1->getNombre(). " intenta pedir: ". $libro2->getTitulo()."<br>";
if($usuario1->pedirLibro($libro2)) {
    echo "Libro prestado con exito<br>";
} else {
    echo "No se pudo prestar el libro: ". $libro2->getTitulo(). " a " . $usuario1->getNombre() . "<br>";
}

//mostrar libros disponibles después de los préstamos
echo "<br>Libros disponibles después de los préstamos:<br>";
$librosDisponibles = $biblioteca->listarLibrosDisponibles();
foreach ($librosDisponibles as $libro) {
    echo "Titulo: " . $libro['titulo'] . ", Autor: " . $libro['autor'] . ", ISBN: " . $libro['isbn'] . "<br>";
}

//devolver el libro del usuario1
echo "<br>".$usuario1->getNombre
(). " devuelve: " .$libro3->getTitulo()."<br>";
if($usuario1->devolverLibro($libro3->getIsbn())) {
    echo "Libro devuelto con éxito<br>";
} else {
    echo "No se pudo devolver el libro<br>";
}
//devolver el libro del usuario1 usando la biblioteca
//simulamos como reaccionara el sistema si el usuario1 intenta devolver un libro que no tiene prestado (pq ya lo devolvio o nunca lo pidio)
echo "<br> " . $usuario1->getNombre() . " quiere devolver el libro: ". $libro3->getTitulo()."\n". "<br>";
if($biblioteca->recibirLibro($usuario1->getId(), $libro3->getIsbn()))
{
    echo "Libro devuelto con exito". "<br>";
}
else
{
    echo "No se pudo devolver el libro: ". $libro3->getTitulo(). "<br>";
}
//ahora el usuario2 intenta pedir el libro que devolvió el usuario1
echo "<br>Carla pide: ". $libro3->getTitulo().  " (después de la devolución) <br>";
if($usuario2->pedirLibro($libro3)) {
    echo "Libro prestado con exito<br>";
} else {
    echo "No se pudo prestar el libro: ". $libro3->getTitulo()." a " . $usuario2->getNombre() . "<br>";
}

//resumen de préstamos
echo "<br>Resumen de préstamos:<br>";
$resumen = $biblioteca->resumenPrestamos();
foreach ($resumen as $usuario => $libros) {
    echo "$usuario tiene prestado(s): " . implode(", ", $libros) . "<br>";
}
?>