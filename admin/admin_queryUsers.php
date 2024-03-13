<?php
global $host, $user, $pass, $db;
require_once ("../secrets.settings.php");


function getAllUsers(){

}
$con = mysqli_connect($host, $user, $pass, $db);


if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}else{
    echo 'CONNECTED to : ' . $db   ;
}

$sql = "SELECT * FROM user WHERE id = '" . "5" . "'" ;
$result = mysqli_query($con,$sql);

echo "<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Age</th>
<th>Hometown</th>
<th>Job</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['FirstName'] . "</td>";
    echo "<td>" . $row['LastName'] . "</td>";
    echo "<td>" . $row['Age'] . "</td>";
    echo "<td>" . $row['Hometown'] . "</td>";
    echo "<td>" . $row['Job'] . "</td>";
    echo "</tr>";
}
echo "</table>";

mysqli_close($con);
?>