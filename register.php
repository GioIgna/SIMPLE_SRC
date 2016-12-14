<?php
/*
* 	questo file serve ad elaborare i dati ricevuti dal form
*	effettua la registrazione dell'utente
*/
session_start();
//connetto il controller al db
include ('connect.php');

//definisco le variabili che mi serviranno per passare i dati
$avviso="";
$avviso_user="";
$nome="";
$cognome="";
$email="";
$username="";
$password="";
//ricevo i dati dal form e verifico che siano settati e non vuoti
if ($_POST["nome"]!='' || $_POST["cognome"]!='' || $_POST["email"]!='' || $_POST["username"]!='' || $_POST["password"]!='' /*|| empty($_POST["nome"]) || empty($_POST["cognome"]) || empty($_POST["email"]) || empty($_POST["username"]) || empty($_POST["password"])*/) {

	//se i campi sono stati compilati salvo i dati nelle variabili
	$nome=$_POST["nome"];				$_SESSION["nome"]=$nome;
	$cognome=$_POST["cognome"];			$_SESSION["cognome"]=$cognome;
	$email=$_POST["email"];				$_SESSION["email"]=$email;
	$username=$_POST["username"];		$_SESSION["username"]=$username;
	$password=md5($_POST["password"]);	$_SESSION["password"]=$password; //la password è criptata md5
	$_SESSION["reg_ko"]=" ";
	/*$query_username_unique= "SELECT Username FROM utenti WHERE Username = '".$username."'";
	$result=msql_query($query_username_unique);*/
	
	//verifico se la username è già esistente
	if(verifica_username($username)){
		if (verifica_email($email)) {
			# code...
			//inserisco l'utente registrato
			$query_registrazione= "INSERT INTO utenti (U_Nome, U_Cognome, Email, Username, U_Password ) VALUES('".$nome."', '".$cognome."', '".$email."', '".$username."', '".$password."')";
			//posso inserire l'utente
			$insert_user=mysql_query($query_registrazione);
			if($insert_user){
				$esito = "utente registrato con successo";
				$_SESSION["reg_ok"]=$esito;
				header("Location:output.php");

			} else {
				echo "Query invalidante: ". mysql_error();
			}	
		} else {
			//$_SESSION["reg_ko"]= "esiste già un utente registrato con questa Email";
			header("Location:input1.php");
		}

	} else {
		//$_SESSION["reg_ko"]= "username non valida: un altro utente utilizza questa username";
		header("Location:input1.php");
	}
	
} else {
	$avviso= "tutti i campi devono essere compilati";
	header("Location:input1.php");

	//verifico che la email e la username siano già registrati

}

//funzione per verificare l'esistenza della username
//FUNZIONANTE :)
function verifica_username($user){
	$query_verifica= "SELECT Username FROM utenti WHERE Username='".$user."'";
	$result= mysql_query($query_verifica);
	if (mysql_num_rows($result)!=0) {
		# code...
		$reg_ko="esiste già un utente registrato con questa Username";
		$_SESSION["reg_ko"]=$reg_ko;
		return false;
	} else {
		return true;
	}
}

//funzione per verificare l'esistenza della email

function verifica_email($mail){
	$query_verifica_email= "SELECT Email FROM utenti WHERE Email='".$mail."'";
	$result= mysql_query($query_verifica_email);
	if(mysql_num_rows($result)!=0){
		#code
		$reg_ko_mail="esiste già un utente registrato con questa Email";
		$_SESSION["reg_ko_mail"]=$reg_ko_mail;
		return false;
	} else {
		return true;
	}
}
