<?php
require 'conn_db.php';
//verifica l'esistenza della tabella
$query_verify="SELECT * FROM Utenti";
if(mysqli_query($db_conn, $query_verify)){
	
	echo "TABELLA 'Utenti' GIA' ESISTENTE<br>";
	
}	else{
		
		//query creazione tabella
		$query_table="
			CREATE TABLE IF NOT EXISTS Utenti
				(
				ID_User INT(15) NOT NULL AUTO_INCREMENT,
				Username VARCHAR(255) NOT NULL,
				Password VARCHAR(255) NOT NULL,
				Email VARCHAR(255) NOT NULL,
				reg_date TIMESTAMP,
				PRIMARY KEY (ID_User)
				)";
		if(mysqli_query($db_conn, $query_table)){
			echo "TABELLA 'Utenti' CREATA CON SUCCESSO<br>";
		}	else {
			echo "TABELLA 'Utenti': ERRORE".mysqli_error($db_server). "<br>";
		}
}
$query_verify_work="SELECT * FROM Societa";
if(mysqli_query($db_conn, $query_verify_work)){
	echo "TABELLA 'Societa' GIA' ESISTENTE<br>";
	
} else {
	$query_table_work="
			CREATE TABLE IF NOT EXISTS Societa
				(
				ID_Societa INT(15) NOT NULL AUTO_INCREMENT,
				Nome VARCHAR(255) NOT NULL,
				Indirizzo VARCHAR(255) NOT NULL,
				ID_User VARCHAR(255) REFERENCES Utenti (ID_User),
				reg_date TIMESTAMP,
				PRIMARY KEY (ID_Societa)
				)
			";
	
		if(mysqli_query($db_conn, $query_table_work)){
			echo "TABELLA 'Società' CREATA CON SUCCESSO<br>";
		} else {
			echo "TABELLA 'Società': ERRORE".mysqli_error($db_server). "<br>";
		}
}
mysqli_close($db_server);
//query alternativa per creare la chiave esterna (FOREIGN KEY)
//$query_add="ALTER TABLE Societa ADD FOREIGN KEY (ID_User) REFERENCES Utenti (ID_User)";
?>
