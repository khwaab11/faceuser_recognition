<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<body>
<div class="container-fluid">
    <div class="jumbotron">
        <h1 class="text-center">Smart  Attendance  System</h1>
    </div>
</div>

    <form action="student_test.php" method="post">
        <div class="form-group row">
        <div class="col-4"></div>
        <div class="col-5">
            <label for="dvr">Period:</label>
            
            <input type="text" name="dvr" id="dvr" class="form-control">
            </div>
        </div>
        <div class="row">
        <div class="col-5"></div>
        <div class="col-6">
        
        <button type="submit" name="down" class="btn btn-primary">Download Attendance</button>
        <button type="submit" name="clear" class="btn btn-danger">Reset</button>
        </div>
        </div>
    </form>

<!-- <form action="students.php" method="post">
    Period: <input type="text" name="dvr" id="dvr">
    <input type="submit" name="down" value="Download Attendance">
    <input type="submit" name="clear" value="reset" >
    
    </form> -->


<?php
$conn = mysqli_connect("localhost", 'root', '', 'face_recognition');

$q = "SELECT * from student where status=1";
$res = mysqli_query($conn, $q);
?>
<br>
<br>
<div class='container'>
<h4 style="color: green" class="text-center">
    <?php if(isset($_GET['reset'])){
        echo "ATTENDANCE RESET";
    }
    ?>
</h4>
</div>
<br>
<br>

<div class="container" id="pt"> </div>
<!-- <div class="container">
  
    <table class="table table-striped">
    <thead>
      <tr>
        <th>Roll Number</th>
        <th>Name</th>
        
      </tr>
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
</div> -->

<!-- <table border=1>
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
</table> -->
<br>
<br>






<?php
if (isset($_POST['down'])) {
?>
     <div style="text-align:center" class="container row">
    <div class="col-4">
     </div>
     <div class="col-4">
<?php
    $q = "SELECT * from student where status=1";
    $res = mysqli_query($conn, $q);

    $fp = fopen($_POST['dvr'] . ".csv", 'w');
    fwrite($fp, 'Roll Number,' . 'Name' . "\n");
    while ($row = mysqli_fetch_assoc($res)) {
        // echo $row['name'];
        // echo $row['roll_no'];
        fwrite($fp, $row['roll_no'] . ',');
        fwrite($fp, $row['name'] . ',');
        fwrite($fp, "\n");
    }
    echo "<p>";
        echo $_POST['dvr'].".csv";
        echo "</p>";
        
?>
</div>
<div class="col-4">
    <a type="button" class="btn btn-primary" href="<?php echo $_POST['dvr'] . '.csv'; ?>" target='_blank'>Download</a>
    </div>
</div>
<?php }?>
<?php  
if (isset($_POST['clear'])){
    $u="UPDATE student set status=0";
    $t=mysqli_query($conn,$u);
    if($t){
        header('Location: student_test.php?reset');
    }
}
?>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    setInterval(function(){
        $.ajax({
            url:'part_sql.php',
            type:'post',
            datatype:'html',
            async: false,
            success: function(d){
                $("#pt").html(d);
            }
        });
    },1000);


</script>
<!-- 
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> -->

</html>