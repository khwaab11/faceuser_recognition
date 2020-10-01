<?php 
$conn = mysqli_connect("localhost", 'root', '', 'face_recognition');

$q = "SELECT * from student where status=1";
$res = mysqli_query($conn, $q);

echo "<table class='table table-striped'>
<thead>
  <tr>
    <th>Roll Number</th>
    <th>Name</th>
    
  </tr>
</thead>
<tbody>";
?>
<?php
    while ($row = mysqli_fetch_assoc($res)) {
        echo "<tr>
        <td>".$row['roll_no']."</td><td>".$row['name']."</td><tr>";
    }
    
echo"
</tbody>
</table>";

?>