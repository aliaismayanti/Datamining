<?php
    require_once "../../connection.php";

    session_start();

    if(isset($_POST['add'])) {
        $tot = $_POST['tot'];
        for ($j=1; $j<=$tot; $j++) {
            $nim = $_POST['nim'.$j];
            $nama = $_POST['nama_mahasiswa'.$j];
            $semester = $_POST['semester'.$j];
            $nilai = $_POST['nilai_ips'.$j];
            $kompensasi = $_POST['kompensasi'.$j];
            $class = $_POST['class'.$j];
            $status = $_POST['status'.$j];

            $cek = mysqli_query($connection,"SELECT * FROM data_mahasiswa WHERE nim='$nim'") or die (mysqli_error($connection));
            if (mysqli_num_rows($cek) > 0){
                echo "<script>alert('Dilarang Duplikat NIM!'); window.location='add.php';</script>";
            } else {
                // $total = $_POST['total'];
                // for ($i=1; $i<=$total; $i++) {
                //     $nim = $_POST['nim'.$i];
                //     $nama = $_POST['nama_mahasiswa'.$i];
                //     $semester = $_POST['semester'.$i];
                //     $nilai = $_POST['nilai_ips'.$i];
                //     $kompensasi = $_POST['kompensasi'.$i];
                //     $class = $_POST['class'.$i];
                //     $status = $_POST['status'.$i];
    
                    $sql = mysqli_query($connection, "INSERT INTO data_mahasiswa VALUES ('', '$nim', '$nama', '$semester', '$nilai', '$kompensasi', '$class', '$status')") or die (mysqli_error($connection));
    
                if($sql) {
                    // echo "<script>alert('".$total." Data Berhasil di Tambahkan'); window.location='index.php';</script>";
                    $_SESSION['message'] = "<b>$tot Data Berhasil di Tambahkan</b>";
                    $_SESSION['msg_type'] = "success";
    
                    header("location: index.php");
                } else {
                    echo "<script>alert('".$tot." Gagal Tambah Data, Coba Lagi!'); window.location='generate.php';</script>";
                }
            }
        }
    } else if(isset($_POST['edit'])) {
        $id = $_POST['id'];
        $nim = $_POST['nim'];
        $nama = $_POST['nama_mahasiswa'];
        $semester = $_POST['semester'];
        $nilai = $_POST['nilai_ips'];
        $kompensasi = $_POST['kompensasi'];
        $class = $_POST['class'];
        $status = $_POST['status'];

        $db = mysqli_query($connection, "UPDATE data_mahasiswa SET nim='$nim', nama_mahasiswa='$nama', semester='$semester', nilai_ips='$nilai', kompensasi='$kompensasi', class='$class', status='$status' WHERE id='$id'") or die (mysqli_error($connection));
      
        if($db) {
            echo "<script>alert('Data Berhasil di Update.'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal Update Data, Coba Lagi!'); window.location='edit.php';</script>";
        }
    } else if(isset($_POST['hapus'])) {
        if(empty($_POST['checked_id'])) {
            echo "<script>alert('Tidak Ada Data Yang Dipilih!'); window.location='index.php';</script>";
        } else {
            $id = $_POST['checked_id'];
            $jml_check = count($id);

            for($x=0; $x < $jml_check; $x++) {
                $hapus = mysqli_query($connection, "DELETE FROM data_mahasiswa WHERE id='$id[$x]'") or die (mysqli_error($connection));
            }
            if($hapus) {
                echo "<script>alert('Data Berhasil di Hapus.'); window.location='index.php';</script>";
            } else {
                echo "<script>alert('Gagal Hapus Data, Coba Lagi!'); window.location='index.php';</script>";
            }
        }
    } else if(isset($_POST['upload'])) {
        $file = $_FILES['file']['tmp_name'];
        $handle = fopen($file, "r");

        $r = 0;

        while (($csvdata = fgetcsv($handle,1000,",")) !== FALSE) {
            $id = $csvdata[0];
            $nim = $csvdata[1];
            $nama = $csvdata[2];
            $semester = $csvdata[3];
            $nilai = $csvdata[4];
            $kompensasi = $csvdata[5];
            $class = $csvdata[6];
            $status = $csvdata[7];

            $sql = "INSERT INTO data_mahasiswa (id, nim, nama_mahasiswa, semester, nilai_ips, kompensasi, class, status)
                        VALUES ('$id', '$nim', '$nama', '$semester', '$nilai', '$kompensasi', '$class', '$status')";
            $query = mysqli_query($connection, $sql);

            $r = $r+1;
        }

        if ($query) {
            $qstring = '?status=succ';
        } else {
            $qstring = '?status=err';
        }
    }
    header("location: index.php".$qstring);
?>
