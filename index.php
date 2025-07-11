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
    echo "No se pudo prestar el libro: 'El principito ' a $usuario2.$nombre". "<br>";
}
//devolver el libro
?>