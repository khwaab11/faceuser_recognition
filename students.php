<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<form action="students.php" method="post">
    Period: <input type="text" name="dvr" id="dvr">
    <input type="submit" name="down" value="Download Attendance">
    <input type="submit" name="clear" value="reset" >
    
</form>


<?php
$conn = mysqli_connect("localhost", 'root', '', 'face_recognition');

$q = "SELECT * from student where status=1";
$res = mysqli_query($conn, $q);
?>
<h4 style="color: green">
    <?php if(isset($_GET['reset'])){
        echo "ATTENDANCE RESET";
    }
    ?>
</h4>
<table border=1>
    <thead>
        <th>Roll Number</th>
        <th>Name</th>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>
            <td>".$row['roll_no']."</td><td>".$row['name']."</td><tr>";
        }
        ?>
    </tbody>
</table>
<?php
if (isset($_POST['down'])) {
?>
    <div style="text-align:center">
        <a type="button" class="btn btn-primary" href="<?php echo $_POST['dvr'] . '.csv'; ?>" target='_blank'>Download</a>
    </div>
<?php
    $q = "SELECT * from student where status=1";
    $res = mysqli_query($conn, $q);

    $fp = fopen($_POST['dvr'] . ".csv", 'w');
    fwrite($fp, 'Roll Number,' . 'Name' . "\n");
    while ($row = mysqli_fetch_assoc($res)) {
        echo $row['name'];
        echo $row['roll_no'];
        fwrite($fp, $row['roll_no'] . ',');
        fwrite($fp, $row['name'] . ',');
        fwrite($fp, "\n");
    }
}
?>


<?php  
if (isset($_POST['clear'])){
    $u="UPDATE student set status=0";
    $t=mysqli_query($conn,$u);
    if($t){
        header('Location: students.php?reset');
    }
}
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>