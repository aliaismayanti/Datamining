<?php
    include('../../connection.php');

    include('../partisi_data');

    session_start();

    if(isset($_POST['add'])) {
        
        $total = $_POST['total'];
        for ($i=1; $i<=$total; $i++) {
            $nim = $_POST['nim'.$i];
			$nama = strtoupper($_POST['nama_mahasiswa'.$i]);
			$nilai = $_POST['nilai_ipk'.$i];
			$kompensasi = $_POST['kompensasi'.$i];
            $class = strtoupper($_POST['class'.$i]);
            
            $sql = mysqli_query($connection, "INSERT INTO data_mahasiswa VALUES ('$nim', '$nama', '$nilai', '$kompensasi', '$class')") or die (mysqli_error($connection));
        }

        if($sql) {
            $_SESSION['message'] = "<b>$total Data Berhasil di Tambahkan</b>";
            $_SESSION['msg_type'] = "success";

            header("location: index.php");
        } else {
            echo "<script>alert('".$total." Gagal Tambah Data, Coba Lagi!'); window.location='generate.php';</script>";
        }
    } else if(isset($_POST['edit'])) {
        $nim = $_POST['nim'];
        $nama = $_POST['nama_mahasiswa'];
        $nilai = $_POST['nilai_ipk'];
        $kompensasi = $_POST['kompensasi'];
        $class = $_POST['class'];
        $status = $_POST['status'];

        $db = mysqli_query($connection, "UPDATE data_mahasiswa SET nama_mahasiswa='$nama', nilai_ipk='$nilai', kompensasi='$kompensasi', class='$class', status='$status' WHERE nim='$nim'") or die (mysqli_error($connection));
      
        if($db) {
            $_SESSION['message'] = "<b>Data Berhasil di Update</b>";
            $_SESSION['msg_type'] = "success";

            header("location: index.php");
        } else {
            echo "<script>alert('Gagal Update Data, Coba Lagi!'); window.location='edit.php';</script>";
        }
    } else if(isset($_POST['hapus'])) {
        if(empty($_POST['checked_id'])) {
            echo "<script>alert('Tidak Ada Data Yang Dipilih!'); window.location='index.php';</script>";
        } else {
            $nim = $_POST['checked_id'];
            $jml_check = count($nim);

            for($x=0; $x < $jml_check; $x++) {
                $hapus = mysqli_query($connection, "DELETE FROM data_mahasiswa WHERE nim='$nim[$x]'") or die (mysqli_error($connection));
            }
            if($hapus) {
                $_SESSION['message'] = "<b>$total Data Berhasil di Hapus</b>";
                $_SESSION['msg_type'] = "success";

                header("location: index.php");
            } else {
                echo "<script>alert('Gagal Hapus Data, Coba Lagi!'); window.location='index.php';</script>";
            }
        }
    } else if(isset($_POST['import'])) {
        $handle = fopen($_FILES['file']['tmp_name'], "r");
        while($data = fgetcsv($handle)){
            $nim = mysqli_real_escape_string($connection, $data[1]);
            $nama = mysqli_real_escape_string($connection, $data[2]);
            $nilai = mysqli_real_escape_string($connection, $data[3]);
            $kompensasi = mysqli_real_escape_string($connection, $data[4]);
            $class = mysqli_real_escape_string($connection, $data[5]);

            $sql = "INSERT INTO data_mahasiswa (nim, nama_mahasiswa, nilai_ipk, kompensasi, class)
                        VALUES ('$nim', '$nama', '$nilai', '$kompensasi', '$class')";
            mysqli_query($connection, $sql);
        }

        // if ($query) {
        //     $qstring = '?status=succ';
        // } else {
        //     $qstring = '?status=err';
        // }
    }
    header("location: index.php".$qstring);
?>
