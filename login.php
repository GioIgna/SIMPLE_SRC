<?php 

session_start();
include 'db_conn.php';
//assegno i nomi di login alle variabili di sessione
$_SESSION["username_log"]=$_POST["username_log"];
$_SESSION["password_log"]=$_POST["password_log"];
if(empty($_POST["username_log"]) || empty($_POST["password_log"])){
	$nameErr="INSERT TEST";
	header('Location:index.php');
} else{
	
	$query="SELECT * FROM Utenti WHERE Username='".$_POST["username_log"]."' AND password='".$_POST["password_log"]."'";
	$result_query= mysqli_query($conn_db, $query); //mi sono selezionato i dati
	//restituisci i dati
	if(mysqli_num_rows($result_query)==0 || mysqli_num_rows($result_query)>1){
		echo "NON SEI REGISTRATO";
	} else {
		while($row=mysqli_fetch_assoc($result_query)){
			//echo "<br />". $row["Username"]. " AND ".$row["Password"];
		}
		$_SESSION["logged"]=true;
		header('Location:test_file.php');
	}
}
?>
