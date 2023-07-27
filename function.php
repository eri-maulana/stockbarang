<?php
// sesi wajib login
session_start();

// koneksi to database
$conn = mysqli_connect("localhost","root","","stockbarang");
   

// Menambah Data Barang Baru
if(isset($_POST['tambahbarangbaru'])){
   $namabarang = $_POST['namabarang'];
   $deskripsi = $_POST['deskripsi'];

   // gambar
   $allowed_extension = array('png','jpg');  
   $nama = $_FILES['file']['name']; //ngambil nama file
   $dot = explode('.', $nama);
   $ekstensi = strtolower(end($dot)); //ngambil ekstensi
   $ukuran = $_FILES['file']['size']; //ngambil size filenya
   $file_tmp = $_FILES['file']['tmp_name'] ; //ngambil lokasi filenya
   
   // penamaan file -> enskripsi
   $image = md5(uniqid($nama,true).time()).'.'.$ekstensi; //menggabungkan nama file yang di enkripsi dengan ekstensi nya
   

   // validasi udah ada atau belum
   $cek = mysqli_query($conn, "SELECT * FROM stock WHERE namabarang='$namabarang'");
   $hitung =mysqli_num_rows($cek) ;
   

   if($hitung < 1){
      // jika belum ada
      
      // proses upload gambar
      if(in_array($ekstensi, $allowed_extension) === true){
         // validasi ukuran file nya 
         if($ukuran < 15000000){
            move_uploaded_file($file_tmp, 'images/'.$image);

            $addToTableStok = mysqli_query($conn, "INSERT INTO  stock (namabarang,deskripsi,image) values('$namabarang','$deskripsi','$image')");
            if($addToTableStok){
               header('location:index.php');
            } else{
               echo "Gagal";
               header('location:index.php');
            }
         }else{
            // kalau file nya lebih dari 15 mb
            echo '
            <script>
               alert("Ukuran Terlalu Besar >= 15MB");
               window.location.href="index.php";
            </script>
            ' ;
         }
      } else{
         // kalau file nya bukan png atau jpg
         echo '
      <script>
         alert("Hanya boleh menggunakan ekstensi PNG atau JPG");
         window.location.href="index.php";
      </script>
      ' ;
      }
   } else {
      echo '
      <script>
         alert("Nama Barang Sudah Terdaftar");
         window.location.href="index.php";
      </script>
      ' ;
   }
}


// Menambah Data Barang Masuk
if(isset($_POST['tambahbarangmasuk'])){
   $barangnya = $_POST['barangnya'];
   $keterangan = $_POST['keterangan'];
   $jumlahmasuk = $_POST['qty'];
   

   $cekstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
   $ambildatanya = mysqli_fetch_array($cekstock);
   
   $stocksekarang = $ambildatanya['stock'];
   $tambahkanstock = $stocksekarang + $jumlahmasuk;

   $updatestock = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstock' WHERE idbarang='$barangnya'");

   $addToTableMasuk = mysqli_query($conn, "INSERT INTO barangmasuk(idbarang,keterangan,qty) VALUES('$barangnya','$keterangan','$jumlahmasuk')");
   
   if($addToTableMasuk&&$updatestock){
      header('location:masuk.php');
   } else {
      echo "Gagal";
      header('location:keluar.php');
   }
}

// Menambah Data Barang Keluar
if(isset($_POST['tambahbarangkeluar'])){
   $keluaran = $_POST['keluaran'];
   $penerima = $_POST['penerima'];
   $jumlahkeluar = $_POST['qty'];

   $cekstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$keluaran'");
   $ambildatanya = mysqli_fetch_array($cekstock);
   
   $stocksekarang = $ambildatanya['stock'];

   if ($stocksekarang >= $jumlahkeluar) {
      //jika stocknya cukup
      $tambahkanstock = $stocksekarang - $jumlahkeluar;

      $updatestock = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstock' WHERE idbarang='$keluaran'");

      $addToTableKeluar = mysqli_query($conn, "INSERT INTO barangkeluar(idbarang,penerima,qty) VALUES('$keluaran','$penerima','$jumlahkeluar')");
      
      if($addToTableKeluar&&$updatestock){
         header('location:keluar.php');
      } else {
         echo "Gagal";
         header('location:keluar.php');
      }
   } else{
      // jika stocknya tidak cukup
      echo '
      <script>
         alert("Stok yang tersedia tidak cukup");
         window.location.href="keluar.php";
      </script>
      ' ;
   } 
}



// Ubah barang index.php
if(isset($_POST['updatebarang'])){
   $idb = $_POST['idb'];$idb = $_POST['idb'];
   $namabarang = $_POST['namabarang'];
   $deskripsi = $_POST['deskripsi'];

    // gambar
    $allowed_extension = array('png','jpg');  
    $nama = $_FILES['file']['name']; //ngambil nama file
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot)); //ngambil ekstensi
    $ukuran = $_FILES['file']['size']; //ngambil size filenya
    $file_tmp = $_FILES['file']['tmp_name'] ; //ngambil lokasi filenya
    
    // penamaan file -> enskripsi
    $image = md5(uniqid($nama,true).time()).'.'.$ekstensi; //menggabungkan nama file yang di enkripsi dengan ekstensi nya
    
 

    
    if($ukuran == 0){
       // jika tidak ingin upload
       $update = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi' WHERE idbarang='$idb'");
       if($update){
         header('location:index.php');
      } else {
         echo "Gagal";
         header('location:index.php');
      }
      } else {
         // jika ingin
         move_uploaded_file($file_tmp, 'images/'.$image);
         $update = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi', image='$image' WHERE idbarang='$idb'");
         if($update){
            header('location:index.php');
         } else {
            echo "Gagal";
            header('location:index.php');
         }
      }
   
}


// Hapus Barang index.php
if(isset($_POST['hapusbarang'])){
   $idb = $_POST['idb']; //id barang
   
   $gambar = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
   $get = mysqli_fetch_array($gambar); 
   $img = 'images/'.$get['image'];
   unlink($img);

   $hapus = mysqli_query($conn, "DELETE FROM stock WHERE idbarang='$idb'");

   if($hapus){
      header('location:index.php');
   } else {
      echo "Gagal";
      header('location:index.php');
   }
}


// Ubah Barang masuk.php
if(isset($_POST['updatebarangmasuk'])){
   $idb = $_POST['idb'];
   $idm = $_POST['idm'];
   $qty = $_POST['qty'];
   $keterangan = $_POST['keterangan'];

   $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
   $stocknya = mysqli_fetch_array($lihatstock);
   $stockskrg = $stocknya['stock'];

   $qtyskrg = mysqli_query($conn, "SELECT * FROM barangmasuk WHERE idmasuk='$idm'");
   $qtynya = mysqli_fetch_array($qtyskrg);
   $qtysekarang = $qtynya['qty'];

   if($qty > $qtysekarang){
      $selisih = $qty - $qtysekarang ;
      $kurangin = $stockskrg + $selisih;
      $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
      $updatenya = mysqli_query($conn, "UPDATE barangmasuk SET qty='$qty', keterangan='$keterangan' WHERE idmasuk='$idm'");

      if($kurangistocknya&&$updatenya){
         header('location:masuk.php');
       } else {
         echo "Gagal";
         header('location:masuk.php');
         }
   } else {
      $selisih = $qtysekarang - $qty ;
      $kurangin = $stockskrg - $selisih;
      $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
      $updatenya = mysqli_query($conn, "UPDATE barangmasuk SET qty='$qty', keterangan='$keterangan' WHERE idmasuk='$idm'");

      if($kurangistocknya&&$updatenya){
         header('location:masuk.php');
       } else {
         echo "Gagal";
         header('location:masuk.php');
         }
   }
}


// Hapus Barang masuk.php
if(isset($_POST['hapusbarangmasuk'])){
   $idb = $_POST['idb'];
   $idm = $_POST['idm'];
   $qty = $_POST['kty'];
   $keterangan = $_POST['keterangan'];

   $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE  idbarang='$idb'");
   $data = mysqli_fetch_array($getdatastock);
   $stok = $data['stock'];

   $selisih = $stok - $qty;

   $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'"); 
   $hapusdata = mysqli_query($conn, "DELETE FROM barangmasuk WHERE idmasuk='$idm'");

   if($update&&$hapusdata){
      header('location:masuk.php');
    } else {
      echo "Gagal";
      header('location:masuk.php');
      }
}

// Ubah Barang keluar.php
if(isset($_POST['updatebarangkeluar'])){
   $idb = $_POST['idb'];
   $idk = $_POST['idk'];
   $qty = $_POST['qty'];
   $penerima = $_POST['penerima'];

   $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
   $stocknya = mysqli_fetch_array($lihatstock);
   $stockskrg = $stocknya['stock'];

   $qtyskrg = mysqli_query($conn, "SELECT * FROM barangkeluar WHERE idkeluar='$idk'");
   $qtynya = mysqli_fetch_array($qtyskrg);
   $qtysekarang = $qtynya['qty'];

   if($qty > $qtysekarang){
      $selisih = $qty - $qtysekarang ;
      $kurangin = $stockskrg - $selisih;
      $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
      $updatenya = mysqli_query($conn, "UPDATE barangkeluar SET qty='$qty', penerima='$penerima' WHERE idkeluar='$idk'");

      if($kurangistocknya&&$updatenya){
         header('location:keluar.php');
       } else {
         echo "Gagal";
         header('location:keluar.php');
         }
   } else {
      $selisih = $qtysekarang - $qty ;
      $kurangin = $stockskrg + $selisih;
      $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
      $updatenya = mysqli_query($conn, "UPDATE barangkeluar SET qty='$qty', penerima='$penerima' WHERE idkeluar='$idk'");

      if($kurangistocknya&&$updatenya){
         header('location:keluar.php');
       } else {
         echo "Gagal";
         header('location:keluar.php');
         }
   }
}


// Hapus Barang keluar.php
if(isset($_POST['hapusbarangkeluar'])){
   $idb = $_POST['idb'];
   $idk = $_POST['idk'];
   $qty = $_POST['kty'];
   $penerima = $_POST['penerima'];

   $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE  idbarang='$idb'");
   $data = mysqli_fetch_array($getdatastock);
   $stok = $data['stock'];

   $selisih = $stok + $qty;

   $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'"); 
   $hapusdata = mysqli_query($conn, "DELETE FROM barangkeluar WHERE idkeluar='$idk'");

   if($update&&$hapusdata){
      header('location:keluar.php');
    } else {
      echo "Gagal";
      header('location:keluar.php');
      }
}



// menambah akun admin baru
if(isset($_POST['addadmin'])){
   $email = $_POST['email'];
   $password = $_POST['password'];

   $queryinsert = mysqli_query($conn, "INSERT INTO login(email,password) values('$email','$password')");

   if($queryinsert){
      header('location:admin.php');
    } else {
      echo "Gagal";
      header('location:admin.php');
   }
}

// edit akun admin
if(isset($_POST['updateadmin'])){
   $emailbaru = $_POST['emailadmin'];
   $passwordbaru = $_POST['passwordbaru'];
   $idnya = $_POST['id'];

   $queryupdate = mysqli_query($conn, "UPDATE login SET email='$emailbaru',password='$passwordbaru' WHERE iduser='$idnya'");

   if($queryupdate){
      header('location:admin.php');
    } else {
      echo "Gagal";
      header('location:admin.php');
   }

}

// hapus akun admin
if(isset($_POST['hapusadmin'])){
   $id = $_POST['id'];

   $querydelete = mysqli_query($conn, "DELETE FROM login WHERE iduser='$id'");
   
   if($querydelete){
      header('location:admin.php');
    } else {
      echo "Gagal";
      header('location:admin.php');
   }
}

// membuat akun baru di register.php
if(isset($_POST['buatakun'])){
   $email = $_POST['email'];
   $password = $_POST['password'];

   $queryinsert = mysqli_query($conn, "INSERT INTO login(email,password) values('$email','$password')");

   if($queryinsert){
      echo '
      <script>
         alert("Akun Berhasil Dibuat.... Silahkan Login");
         window.location.href="login.php";
      </script>
      ' ;
    } else {
      echo "Akun Gagal Dibuat";
      header('location:register.php');
   }
}

?>