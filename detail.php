<?php
    require 'function.php';
    require 'cek.php';

   //  dapetin id barang yang di passing dari halaman sebelumnya 
   $idbarang = $_GET['id'];
   // get informasi barang berdasarkan database
   $get = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idbarang' ");
   $fetch = mysqli_fetch_assoc($get);
   // set variable 
   $namabarang = $fetch['namabarang'];
   $deskripsi = $fetch['deskripsi'];
   $stock = $fetch['stock'];

   // cek ada gambar atau tidak
   $gambar = $fetch['image']; //ambil gambar
   if($gambar == null){
      // jika tidak ada gambar
      $img = "Tidak Ada Gambar";
   } else {
      // jika ada gambar
      $img = '<img src="images/'.$gambar.'" class="zoomable" '; 
   }
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <meta name="description" content="" />
   <meta name="author" content="" />
   <title>Putri Narila - Detail Barang</title>
   <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Lobster&display=swap" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
   <link href="css/styles.css" rel="stylesheet" />
   <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
   <style>
   .putri {
      font-family: 'Lobster', cursive;
   }

   .heading {
      font-family: 'Lilita', cursive;
   }

   .zoomable {
      width: 200px;
      height: 250px;
   }

   .zoomable:hover {
      transform: scale(1.5);
      transition: 0.3s ease;
   }
   </style>
</head>

<body class="sb-nav-fixed">
   <nav class="sb-topnav navbar navbar-expand navbar-dark bg-success">
      <!-- Navbar Brand-->
      <a class="putri navbar-brand ps-3 fs-3 " href="index.php">Putri Narila</a>
      <!-- Sidebar Toggle-->
      <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>

   </nav>
   <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
         <nav class="sb-sidenav accordion sb-sidenav-success bg-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
               <div class="nav ">
                  <a class="nav-link text-success" href="index.php">
                     <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                     Stok Barang
                  </a>
                  <a class="nav-link text-success" href="masuk.php">
                     <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                     Barang Masuk
                  </a>
                  <a class="nav-link text-success" href="keluar.php">
                     <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                     Barang Keluar
                  </a>
                  <a class="nav-link text-success mb-5" href="admin.php">
                     <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                     Kelola Admin
                  </a>
                  <a class="nav-link text-success" href="logout.php">
                     <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                     Logout
                  </a>


               </div>
            </div>
            <div class="sb-sidenav-footer">
               <div class="small">Modify By:</div>
               <p class="putri">Putri Narila</p>
            </div>
         </nav>
      </div>
      <div id="layoutSidenav_content">
         <main>
            <div class="container-fluid px-4">
               <h1 class="mt-4 heading ">Detail Barang</h1>
               <div class="card mb-4">
                  <div class="card-header">
                     <h3 class="mb-1 text-center"> <?=$namabarang;?> </h3>
                     <span class="d-flex justify-content-center align-items-baseline"> <?=$img;?> </span>
                  </div>
                  <div class="card-body">
                     <div class="row mt-3">
                        <div class="col-md-3 ">
                           <p class="fw-bold"> Deskripsi </p>
                        </div>
                        <div class="col-md-9">
                           : <?=$deskripsi;?>
                        </div>
                     </div>

                     <div class="row mb-3">
                        <div class="col-md-3">
                           <p class="fw-bold"> Stock </p>
                        </div>
                        <div class="col-md-9">
                           : <?=$stock;?>
                        </div>
                     </div>
                     <hr>

                     <h3 class="mb-2">Barang masuk</h3>
                     <div class="table-responsive">
                        <table id="datatablesSimple" id="barangmasuk" class="table table-bordered table-responsive">
                           <thead>
                              <tr>
                                 <th>No</th>
                                 <th>Tanggal </th>
                                 <th>Keterangan</th>
                                 <th>Quantity</th>
                              </tr>

                           </thead>
                           <tbody>
                              <?php
                              $i = 1;
                              $ambildatamasuk = mysqli_query($conn, "SELECT * FROM barangmasuk WHERE idbarang='$idbarang' ");
                              while($fetch = mysqli_fetch_array($ambildatamasuk)){
                                 $tanggal = $fetch['tanggal'];
                                 $keterangan = $fetch['keterangan'];
                                 $quantity = $fetch['qty'];
                                 ?>


                              <tr>

                                 <td>
                                    <?=$i;?>
                                 </td>
                                 <td>
                                    <?=$tanggal;?>
                                 </td>
                                 <td>
                                    <?=$keterangan;?>
                                 </td>
                                 <td>
                                    <?=$quantity;?>
                                 </td>
                              </tr>


                              <?php
                           $i++;
                           }
                           ?>
                           </tbody>
                        </table>
                     </div>
                     <hr>

                     <h3 class="mb-2">Barang keluar</h3>
                     <div class="table-responsive">
                        <table id="datatablesSimple" id="barangkeluar" class="table table-bordered table-responsive">
                           <thead>
                              <tr>
                                 <th>No</th>
                                 <th>Tanggal </th>
                                 <th>Penerima</th>
                                 <th>Quantity</th>
                              </tr>

                           </thead>
                           <tbody>
                              <?php
                              $i = 1;
                              $ambildatakeluar = mysqli_query($conn, "SELECT * FROM barangkeluar WHERE idbarang='$idbarang' ");
                              while($fetch = mysqli_fetch_array($ambildatakeluar)){
                                 $tanggal = $fetch['tanggal'];
                                 $penerima = $fetch['penerima'];
                                 $quantity = $fetch['qty'];
                                 ?>


                              <tr>

                                 <td>
                                    <?=$i;?>
                                 </td>
                                 <td>
                                    <?=$tanggal;?>
                                 </td>
                                 <td>
                                    <?=$penerima;?>
                                 </td>
                                 <td>
                                    <?=$quantity;?>
                                 </td>
                              </tr>


                              <?php
                           $i++;
                           }
                           ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
      </div>
      </main>

   </div>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
   </script>
   <script src="js/scripts.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
   <script src="assets/demo/chart-area-demo.js"></script>
   <script src="assets/demo/chart-bar-demo.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
      crossorigin="anonymous"></script>
   <script src="js/datatables-simple-demo.js"></script>
</body>



<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h1 class="modal-title fs-5 heading" id="staticBackdropLabel">Tambah Barang</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form method="post" enctype="multipart/form-data">
               <div class=" form-floating">
                  <input type="text" name="namabarang" id="floatingInputGroup1" placeholder="Username"
                     class="form-control mb-2" required>
                  <label for="floatingInputGroup1" class="text-secondary">Nama Barang</label>
               </div>
               <div class=" form-floating">
                  <input type="text" name="deskripsi" id="floatingInputGroup1" placeholder="Deskripsi"
                     class="form-control mb-2" required>
                  <label for="floatingInputGroup1" class="text-secondary">Deskripsi</label>
               </div>
               <input type="file" name="file" id="floatingInputGroup1" class="form-control">
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success float-start" name="tambahbarangbaru"
               id="tambahbarangbaru">Simpan</button>
         </div>
         </form>
      </div>
   </div>
</div>

</html>