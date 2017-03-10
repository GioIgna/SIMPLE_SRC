<?php
/*
* 	questo file serve ad elaborare i dati ricevuti dal form
*	effettua la registrazione dell'utente
*/
session_start();
//connetto il controller al db
include ('connect_db.php');
$query_insert='';
//eseguo il controllo sui dati, successivamente salvo i dati nelle variabili locali
if (validazione_nome_cognome($_POST["nome"])) {
	if (validazione_nome_cognome($_POST["cognome"])) {
		if (validazione_email($_POST["email"])) {
			if (validazione_username($_POST["username"] , 5 , 10)) {
				if (validazione_password($_POST["password"], $_POST["conferma_password"] , 5 , 10)) {
					#salvo i dati nelle variabili
					#effettuo l'inserimento
					$nome 		= $_POST["nome"];	$_SESSION["nome"]     = $nome;
					$cognome 	= $_POST["cognome"];	$_SESSION["cognome"]  = $cognome;
					$email 		= $_POST["email"];	$_SESSION["email"]    = $email;
					$username 	= $_POST["username"];	$_SESSION["username"] = $username;
					$password 	= $_POST["password"];	$_SESSION["password"] = $password;
					//include ('connect_db.php');
					$query_insert= "INSERT INTO utenti (Nome_utente, Cognome_utente, Email, Username, Password_utente) VALUES ('".$nome."', '".$cognome."' , '".$email."' , '".$username."' , '".sha1($password)."' )";
					echo "<p>".$query_insert."</p><br>";
					$result= mysqli_query($query_insert);
					if ($result) {
						$esito_registrazione= "Utente registrato con successo";
						$_SESSION["esito_registrazione"]=$esito_registrazione;
						#ritorno alla prima pagina dove avrò memorizzato i dati per eseguire il login
						header("Location:input1.php");
					} else {
						echo "ERRORE: si è verificato un errore , controlla la query o i dati di accesso al DB";
					}
					#
				} else {}
			} else {}
		} else {}
	} else {}
} else {}


//1.funzione validazione nome/cognome
function validazione_nome_cognome($data){
	//verifico che sia settata
	if (isset($data)) {
		# code...
		$esito_nc="";
		//i dati immessi devono essere solo lettere
		if (ctype_alpha($data)) {
			# code...
			$esito_nc= "CORRETTO";
			return true;
		} else {
			echo "ERRORE (nome/cognome): in questo campo sono ammesse solo lettere";
			return false;
		}
	}
}

//2.funzione validazione email
function validazione_email($data){
	//verifico che sia settata
	if (isset($data)) {
		# code...
		$esito_e="";
		//il dato inserito deve avere un formato email valido
		$data=filter_var($data, FILTER_VALIDATE_EMAIL);
		if (filter_var($data, FILTER_SANITIZE_EMAIL)) {
			# code...
			//connetto il db
			include ('connect_db.php');
			$query_verifica_email= "SELECT Email FROM utenti WHERE Email='".$data."'"; //genero la query
			$result=mysqli_query($db_conn , $query_verifica_email);
			if (mysqli_num_rows($result)== 0) {
				# code...
				$esito_e = "CORRETTO";
				return true;
			} else{
			echo "ERRORE (email): esiste già un utente registrato con questa email. Inserire una nuova email";
			return true;
			}
		} else {
			echo "ERRORE (email): devi inserire una email corretta";
			return false;
		}
	}
}
//3.funzione validazione username
function validazione_username($data,$min,$max){
	if (isset($data)) {
		# code...
		
		$esito_u="";
		$datalen=strlen($data);
		if ($datalen!=0 && $datalen>=$min && $datalen<=$max) {
			# code...
			//connetto il DB
			include ('connect_db.php');
			$query_username="SELECT Username FROM utenti WHERE Username='".$data."'";
			$result=mysqli_query($db_conn , $query_username);
			if (mysqli_num_rows($result) == 0) {
				# code...
				$esuto_u="CORRETTO";
				return true;
			} else {
				echo "ERRORE (username): esiste già un utente registrato con questo Username. Inserire un nuovo Username";
			}
			
		} else {
			echo "ERRORE (username): la lunghezza della username deve essere compresa tra i ".$min. " ed i ".$max." caratteri";
		}
	}
}
//4.funzione validazione password 
function validazione_password($data, $dataconf, $min, $max){
	if (isset($data)) {
		# code...
		$esito_p="";
		$datalen=strlen($data);
		if ($datalen!=0 && $datalen>=$min && $datalen<=$max) {
			# code...
			if (ctype_alnum($data)) {
				# code...
				if (strcmp($data, $dataconf) == 0) {
					# code...
					$esito_p= "CORRETTO";
					return true;
				} else {
					echo "ERRORE (password): le password devono corrispondere";
					return false;
				}

			} else {
				echo "ERRORE (password): il campo password ammette solo caratteri alfanumerici";
				return false;
			}
		} else {
			echo "ERRORE (password): la password deve essere compresa tra i ".$min." ed i ".$max." caratteri";
			return false;
		}
	} else {
		echo "ERRORE (password): il campo non è settato correttamente";
		return false;
	}
}

//5.funzione validazione immagine di profilo
function validazione_immagine(){

}
