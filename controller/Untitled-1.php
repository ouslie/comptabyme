<?php
$mysqli = new mysqli('localhost', 'root', '', 'test');
$sql = 'SELECT quantite, id_client, id_produit FROM Achat';
$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) {
	$tblAchat[$row['name']][$row['month']] = $row['amountbycategory'];
}
?>
 
<table>
	<tr>
		<th></th>
<?php
$sql = 'SELECT id, nom FROM Client';
$req_client = $mysqli->query($sql);
while ($row = $req_client->fetch_assoc()) {
	$tblClient[$row['id']] = $row['nom'];
	echo '<th>' . $row['nom'] . '</th>';
}
?>
	</tr>
<?php
$sql = 'SELECT id, nom FROM Produit';
$req_produit = $mysqli->query($sql);
while ($row = $req_produit->fetch_assoc()) {
			echo '<tr>
					<td>' . $row['nom'] . '</td>';
            foreach ($tblClient as $id_client=>$nom_client) {
				$achat = isset($tblAchat[$row['id']][$id_client]) ? $tblAchat[$row['id']][$id_client] : 0;
				echo '<td>' . $achat . '</td>';
			}
			echo '<tr>';
}
?>
</table>