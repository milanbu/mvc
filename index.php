<?php
require_once 'sys/Controller.php';

/* print_r($_GET);  */
if(!isset($_GET['Controller']) or !preg_match('/^([A-Z][a-z]+)*$/', $_GET['Controller']) or !$_GET['Controller']) {  
	/*Ako nije setovana vrednost za kontroler, mi podesavamo vrednost*/
	/* i ako je razlicit od sablona /^[A-Z][a-z]+$/ */
	$_GET['Controller'] = "Products";
}
if (!isset($_GET['Method']) or !preg_match('/^[a-z]+([A-Z][a-z]*)*$/', $_GET['Method']) or !$_GET['Method']) {
	/*Ako nije setovana vrednost za Methods, mi podesavamo vrednost na index */
	$_GET['Method'] = "index";  /*index je osnovni metod*/
}

//print_r($_GET);


/*

Da li trenutno trazeni kontroler kroz url kad se na njega doda string  Controller.php postoji u lokaciji
app/controllers/

*/
$controllerPath = 'app/controllers/'.$_GET['Controller'].'Controller.php';
//echo $controllerPath;
/*Pitamo se funkcijom da li takav fajl postoji*/
if (!file_exists($controllerPath)) {
	/*Ako fajl ne postoji ono sto mi moramo da uradimo 
	je da redirektujemo na neku 404 error stranicu*/
	/*Mi cemo sa naredbom die() prekinuti izvrsavanje programa*/
	die('Klasa tog kontroler ne postoji.(Kontroler ne postoji)');
}

require_once $controllerPath;
$imeKlase = $_GET['Controller'].'Controller';
$worker = new $imeKlase;


if(!method_exists($worker, $_GET['Method'])){
	die('Ovaj kontroler nema zahtevani metod!');
}
$imeMetode = $_GET['Method'];
//echo $imeMetode;
$worker->$imeMetode();

/*  views */
require 'app/views/'.$_GET['Controller'].'/'.$imeMetode.'.php';/*prikazivanje rezultata na ekran*/



?>