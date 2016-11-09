<?php
require 'conn_db.php';

$query_table="CREATE TABLE IF NOT EXISTS Utenti
					(
					ID_User INT(15) NOT NULL AUTO_INCREMENT,
						Username VARCHAR(255) NOT NULL,
						Password VARCHAR(255) NOT NULL,
						Email VARCHAR(255) NOT NULL,
						reg_date TIMESTAMP,
					PRIMARY KEY (ID_User)
					)";
if(mysqli_query($db_conn, $query_table)){
	echo "TABELLA CREATA CON SUCCESSO<br>";
}	else {
	echo "ERRORE:".mysqli_error($db_server). "<br>";
}

mysqli_close($db_server);

?>
