<?php
require_once 'biblioteca.php';
require_once 'libro.php';
require_once 'usuario.php';
$biblioteca= new Biblioteca("Biblioteca");

//crear los libros
$libro1= new Libro("La princesa y el Sapo", "Julio Borges", "1313");
$libro2= new Libro("Kick Buttowski", "Isabel Allende", "1314");
$libro3= new Libro("El Principito", "Antoine de Saint-Exupéry", "1315");

//agregar los libros a la biblioteca
$biblioteca->agregarLibro($libro1);
$biblioteca->agregarLibro($libro2);  
$biblioteca->agregarLibro($libro3);

//crear usuarios
$usuario1= new Usuario(1, "Joel");
$usuario2= new Usuario(2, "Carla");

//registrar los usuarios
$biblioteca->registrarUsuario($usuario1);
$biblioteca->registrarUsuario($usuario2);

//mostrar libros disponibles (antes de prestar)
echo "Libros que estan disponibles:  (antes del prestamo) \n". "<br>";
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
    echo "No se pudo prestar el libro: 'El principito ' a".$usuario1->getNombre()."<br>";
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
    echo "No se pudo prestar el libro: 'Kick Buttowski ' a " .$usuario2->getNombre(). "<br>";
}

// simulacion de la excepcion donde el usuario quiere pedir un libro ya prestado
echo "<br>". $usuario1->getNombre()." intenta pedir 'Kick Buttowski' (ya esta prestado a Carla): \n". "<br>";
if($usuario1->pedirLibro($libro2))
{
    echo "Libro prestado con exito". "<br>";
    $libro2->prestar(); 
}
else
{
    echo "No se pudo prestar el libro: ". $libro2->getTitulo(). " a " . $usuario1->getNombre() . "<br>";
}

//mostrar libros disponibles (despues de prestar)

echo "<br> Libros disponibles (luego del prestamo) <br>";
$librosDisponibles= $biblioteca->listarLibrosDisponibles();
foreach($librosDisponibles as $libro)
{
    echo "Titulo: " . $libro['titulo'] . ", Autor: " . $libro['autor'] . ", ISBN: " . $libro['isbn'] . "\n". "<br>";
}

//devolver el libro del usuario1 
echo "<br> " . $usuario1->getNombre() . " devuelve el libro: ". $libro3->getTitulo()."\n". "<br>";
if($usuario1->devolverLibro($libro3->getIsbn()))
{
    echo "Libro devuelto con exito". "<br>";
}
else
{
    echo "No se pudo devolver el libro: ". $libro3->getTitulo();
}

//ejemplo de la excepcion para devolver el libro del usuario1 usando la biblioteca ()
echo " <br> Devolver usando la biblioteca: <br>";
echo "<br> " . $usuario1->getNombre() . " devuelve el libro: ". $libro3->getTitulo()."\n". "<br>";
if($biblioteca->recibirLibro($usuario1->getId(), $libro3->getIsbn()))
{
    echo "Libro devuelto con exito". "<br>";
}
else
{
    echo "No se pudo devolver el libro: ". $libro3->getTitulo() . "<br>"; 
}

//ahora el usuario2 quiere pedir el libro que ya devolvio el usuario1

echo"<br> Carla pide: ". $libro3->getTitulo(). "\n". "<br>";
if($usuario2->pedirLibro($libro3))
{
    echo "Libro prestado con exito". "<br>";
    $libro3->prestar(); 
}
else
{
    echo "No se pudo prestar el libro: ". $libro3->getTitulo() .
    "a " .$usuario2->getNombre(). "<br>";
}
//resumen de todos los prestamos
echo "<br> Resumen de prestamos: <br>"; 
$resumen= $biblioteca->resumenPrestamos();
foreach($resumen as $usuario=> $libros)
{
    //implode para unir los titulos de los libros prestados en una cadena
    echo "$usuario tiene prestados los siguientes libros: ". implode(", ", $libros) . "<br>";
}
?>