<?php

if(isset($_POST["upload"]))
{
 if($_FILES['product_file']['name'])
 {
  $filename = explode(".", $_FILES['product_file']['name']);
  if(end($filename) == "csv")
  {
   $handle = fopen($_FILES['product_file']['tmp_name'], "r");
   while($data = fgetcsv($handle))
   {
               
                $nim = mysqli_real_escape_string($connection, $data[0]);
                $nama_mahasiswa = mysqli_real_escape_string($connection, $data[1]);
                $semester = mysqli_real_escape_string($connection, $data[2]);
                $nilai_ips = mysqli_real_escape_string($connection, $data[3]);
                $kompensasi = mysqli_real_escape_string($connection, $data[4]);
                $class = mysqli_real_escape_string($connection, $data[5]);
                $status = mysqli_real_escape_string($connection, $data[6]);
            
            $query = "INSERT INTO data_mahasiswa(nim,nama_mahasiswa,semester,nilai_ips,kompensasi,class,status) VALUES ('$nim','$nama_mahasiswa','$semester','$nilai_ips','$kompensasi','$class','$status') ";
            mysqli_query($connection, $query);
            }
            fclose($handle);
        }
        else{
            $message = '<label class="text-danger">file csv ae ya mamang</label>';
        }
    }
    else{
        $message = '<label class="text-danger">Please Select File</label>';
    }

}

if(isset($_POST["delete"])){
    $query = "DELETE FROM data_mahasiswa";
    mysqli_query($connection, $query);
}


?>