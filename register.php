<?php
session_start();
include 'db_conn.php';
//CONTROLLO SUI DATI D'ACCESSO
if(empty($_POST["username_reg"]) || empty($_POST["password_reg"]) || empty($_POST["email_reg"])){
	$nameErr="INSERT TEST";
	header('Location:index.php');
//BISOGNA FARE IL CONTROLLO PER VERIFICARE CHE NON CI SIA GIÀ UN UTENTE CON QUESTI DATI
	
} else {
	$query= "INSERT INTO Utenti (Username, Password, Email) VALUES ('".$_POST["username_reg"]."', '".$_POST["password_reg"]."', '".$_POST["email_reg"]."')";
	if (mysqli_query($conn_db, $query)){
		echo "TI SEI REGISTRATO CON SUCCESSO";	
	} else {
		echo "ERRORE: " .$query. "<br />" .mysqli_error($conn_db);
	}
	if (isset($query)){
		$_SESSION["logged"]=true;
		header('location:test_file.php');
	} else {
		
		header("location:pagina_errore.php");
	}
}
?>
