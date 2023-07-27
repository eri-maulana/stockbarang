<?php
    require 'function.php';
    require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <meta name="description" content="" />
   <meta name="author" content="" />
   <title>Putri Narila - Barang Keluar</title>
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
      width: 100px;
   }

   .zoomable:hover {
      transform: scale(2.5);
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
                  <a class="nav-link text-success " href="logout.php">
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
               <h1 class="mt-4 heading">Barang Keluar</h1>
               <div class="card mb-4">
                  <div class="card-header">
                     <!-- Button trigger modal -->
                     <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">
                        Tambah Barang Keluar
                     </button>
                     <!-- button untuk export data -->
                     <a href="exportkeluar.php" class="btn btn-secondary" target="_blank">Export Data</a>
                  </div>
                  <div class="card-body">
                     <table id="datatablesSimple" class="table table-bordered">
                        <thead>
                           <tr>
                              <th>No</th>
                              <th>Gambar</th>
                              <th>Nama Barang</th>
                              <th>Penerima</th>
                              <th>Tanggal</th>
                              <th>Quantity</th>
                              <th>Aksi</th>
                           </tr>

                        </thead>
                        <tbody>
                           <?php
                           $ambilsemuadatanya = mysqli_query($conn, "SELECT * FROM barangkeluar k, stock s WHERE s.idbarang=k.idbarang");
                           $i = 1;
                           while($data = mysqli_fetch_array($ambilsemuadatanya)){
                              $idb= $data['idbarang'];
                              $idk= $data['idkeluar'];
                              $namabarang= $data['namabarang'];
                              $penerima= $data['penerima'];
                              $tanggal= $data['tanggal'];
                              $qty= $data['qty'];

                              // cek ada gambar atau tidak
                              $gambar = $data['image']; //ambil gambar
                              if($gambar == null){
                                 // jika tidak ada gambar
                                 $img = "Tidak Ada Gambar";
                              } else {
                                 // jika ada gambar
                                 $img = '<img src="images/'.$gambar.'" class="zoomable" '; 
                              }
                           ?>
                           <tr>
                              <td>
                                 <?=$i;?>
                              </td>
                              <td>
                                 <?=$img;?>
                              </td>
                              <td>
                                 <?=$namabarang;?>
                              </td>
                              <td>
                                 <?=$penerima;?>
                              </td>
                              <td>
                                 <?=$tanggal;?>
                              </td>
                              <td>
                                 <?=$qty;?>
                              </td>
                              <td>
                                 <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#edit<?=$idk;?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                 </button>
                                 <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete<?=$idk;?>">
                                    <i class="fa-solid fa-trash"></i>
                              </td>
                           </tr>

                           <!-- Modal Edit Barang-->
                           <div class="modal fade" id="edit<?=$idk;?>" data-bs-backdrop="static"
                              data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                              aria-hidden="true">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h1 class="modal-title fs-5 heading" id="staticBackdropLabel">Ubah Barang Keluar
                                       </h1>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal"
                                          aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post">
                                          <div class=" form-floating">
                                             <input type="number" name="qty" id="floatingInputGroup1"
                                                class="form-control mb-3" value="<?=$qty;?>" required>
                                             <label for="floatingInputGroup1">Quantity</label>
                                          </div>
                                          <div class=" form-floating">
                                             <input type="text" name="penerima" id="floatingInputGroup1"
                                                class="form-control" value="<?=$penerima;?>" required>
                                             <label for="floatingInputGroup1">Penerima</label>
                                          </div>
                                          <input type="hidden" name="idb" value="<?=$idb;?>">
                                          <input type="hidden" name="idk" value="<?=$idk;?>">
                                    </div>
                                    <div class="modal-footer">
                                       <button type="submit" class="btn btn-warning float-start"
                                          name="updatebarangkeluar" id="updatebarangkeluar">Simpan</button>
                                       <button type="button" class="btn btn-secondary float-end"
                                          data-bs-dismiss="modal">Batal</button>
                                    </div>
                                    </form>
                                 </div>
                              </div>
                           </div>

                           <!-- Modal Delete Barang-->
                           <div class="modal fade" id="delete<?=$idk;?>" data-bs-backdrop="static"
                              data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                              aria-hidden="true">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h1 class="modal-title fs-5 heading" id="staticBackdropLabel">Hapus Barang Keluar
                                       </h1>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal"
                                          aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post">
                                          <p>Yakin akan hapus <?=$namabarang;?> ?</p>
                                          <input type="hidden" name="idb" value="<?=$idb;?>">
                                          <input type="hidden" name="kty" value="<?=$qty;?>">
                                          <input type="hidden" name="idk" value="<?=$idk;?>">
                                    </div>
                                    <div class="modal-footer">
                                       <button type="submit" class="btn btn-danger float-start" name="hapusbarangkeluar"
                                          id="hapusbarangkeluar">Hapus</button>
                                       <button type="button" class="btn btn-secondary float-end"
                                          data-bs-dismiss="modal">Batal</button>
                                    </div>
                                    </form>
                                 </div>
                              </div>
                           </div>

                           <?php
                           $i++;
                           }
                           ?>
                        </tbody>
                     </table>
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
            <h1 class="modal-title fs-5 heading" id="staticBackdropLabel">Tambah Barang Keluar</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form method="post">
               <div class=" form-floating">
                  <select name="keluaran" id="floatingInputGroup1" class="form-control mb-3">
                     <?php
                  $ambildatanya = mysqli_query($conn, "SELECT * FROM stock");
                  while($array = mysqli_fetch_array($ambildatanya)){
                     $namabarangnya = $array['namabarang'];
                     $idbarang = $array['idbarang'];
                     $stock = $array['stock'];
                  ?>
                     <option value="<?=$idbarang;?>"><?=$namabarangnya;?></option>
                     <?php
                  }
                  ?>
                  </select>
                  <label for="floatingInputGroup1">Pilih Nama Barang</label>
               </div>

               <div class=" form-floating">
                  <input type="number" name="qty" class="form-control mb-3" id="floatingInputGroup1" required>
                  <label for="floatingInputGroup1">Quantity</label>
               </div>
               <div class=" form-floating">
                  <input type="text" name="penerima" class="form-control mb-3" id="floatingInputGroup1"
                     placeholder="Deskripsi" required>
                  <label for="floatingInputGroup1" class="text-secondary">Penerima</label>
               </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="tambahbarangkeluar">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
         </div>
         </form>
      </div>
   </div>
</div>

</html>