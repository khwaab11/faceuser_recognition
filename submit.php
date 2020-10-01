<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
$conn = mysqli_connect('localhost','root','','face_recognition');
    $img = $_POST['image'];
    $folderPath = "./";
  
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("./", $image_parts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = "test" . '.jpg';
  
    $file = $folderPath . $fileName;
    file_put_contents($file, $image_base64);

    $python = 'C:\ProgramData\Anaconda3\python.exe face_rec.py';
    $c = exec("$python");
    $c = json_decode($c);
    foreach($c as $face){
        if($face != "Unknown"){
            $query = "UPDATE student set status=1 where id= $face";
            $res = mysqli_query($conn,$query);
            // echo $query;
            if($res){
                $que= "SELECT * from student where id=$face";
                $r = mysqli_query($conn, $que);
                $row = mysqli_fetch_assoc($r);
                echo "<p>";
                echo $row['roll_no'] ;
                echo   " has attended.";
                echo "<br>";
                echo "</p>";
            }
        }
        
    }
     

    // $img = exec("python one.py");
    // echo $img;

?>