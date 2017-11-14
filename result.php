<?php

/*  connessione al DB
..._...
*/

$query = "SELECT nome_campo FROM nome_tabella";
$res = mysql_query($query);

while ($row= mysql_fetch_assoc($res)) {
    $a[] = $row;    //  array valori
}

/*
header('Content-type: text/javascript');
echo json_encode($a, JSON_PRETTY_PRINT, 2);
*/

$find = isset($_GET["find"]) ? $_GET["find"] : '';

$hint= "";

if ($find!="") {
	$find = strtolower($find);
	$len = strlen($find);
	foreach ($a as $key) {
		$key = json_encode($key);
		$key = json_decode($key);
		$val = $key->nome_campo;
		if (stristr($find, substr($val, 0, $len))) {
			if ($hint == "") {
				$hint = $val;
			} else {
				$hint .= ", $val";
			}	
		}
	}

} 

//	stampa il valore
echo $hint == "" ? "nessun suggerimento trovato" : $hint;

?>
