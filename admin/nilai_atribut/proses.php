<?php
    require_once "../../connection.php";

    session_start();

    if(isset($_POST['insert'])) {
        $cek = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM nilai_atribut WHERE nilai='$_POST[nilai]'"));
        if ($cek > 0){
            echo "<script>window.alert('Nilai Atribut Yang Anda Masukkan Sudah Ada.'); window.location='index.php';</script>";
        } else {
            $sql = mysqli_query($connection, "SELECT id_atribut AS id_atribut2 FROM atribut LIMIT 1");
            $row = mysqli_fetch_array($sql);
            $id = $row['id_atribut2'];
            $query = mysqli_query($connection, "INSERT INTO nilai_atribut (id_atribut2, nilai) VALUES ('$id', '{$_POST['nilai']}')") or die (mysqli_error($connection));
                
            if($query) {
                $_SESSION['message'] = "<b>Data Berhasil di Tambahkan</b>";
                $_SESSION['msg_type'] = "success";

                header("location: index.php");
            } else {
                echo "<script>alert('Gagal Tambah Data, Coba Lagi!'); window.location='index.php';</script>";
            }
        }
    } else if(isset($_POST['edit'])) {
        if(isset($_POST['prdId2'])) {
            
            $id = $_POST['prdId2'];
            $id_atr = $_POST['prdId'];
            $nilai = $_POST['nilai'];

            $db = mysqli_query($connection, "UPDATE nilai_atribut SET id_atribut2='$id_atr', nilai='$nilai' WHERE id_data_atribut='$id'") or die (mysqli_error($connection));
        
            if($db) {
                echo "<script>alert('Data Berhasil di Update.'); window.location='index.php';</script>";
            } else {
                echo "<script>alert('Gagal Update Data, Coba Lagi!'); window.location='index.php';</script>";
            }
        }
    }
?>
