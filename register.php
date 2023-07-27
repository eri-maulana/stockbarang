<?php
// menghubungkan database melalui function.php
    require 'function.php';

    // mengecek data login terdaftar atau tidak
    if(isset($_POST['buatakun'])){
      $email = $_POST['email'];
      $password = $_POST['password'];
      
      // cek database 
          $cekdatabase = mysqli_query($conn, "SELECT * FROM login WHERE email='$email' AND password='$password'");
      
      // hitung data dari database
          $hitung = mysqli_num_rows($cekdatabase);
          if($hitung>0){
              $_SESSION['register'] = 'true';
              echo '
                  <script>
                     alert("Akun Berhasil Dibuat.... Silahkan Login");
                     window.location.href="login.php";
                  </script>
                  ' ;
          } else {
              echo "Data Tidak Tersedia";
              header('location:login.php');
          }
              if(!isset($_POST['register'])){
                  
              } else {
                  header('location: login.php');
              }
          
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
   <title>Putri Narila - Register</title>
   <link href="css/styles.css" rel="stylesheet" />
   <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<style>
body {
   background-image: url(assets/img/4.jpg);
   background-size: 100%;
   background-repeat: no-repeat;
}
</style>

<body class="bg-primary">
   <div id="layoutAuthentication">
      <div id="layoutAuthentication_content">
         <main>
            <div class="container">
               <div class="row justify-content-center">
                  <div class="col-lg-5">
                     <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                           <h3 class="text-center font-weight-light my-4">Buat Akun Baru</h3>
                        </div>
                        <div class="card-body">
                           <form method="post">
                              <div class="form-floating mb-3">
                                 <input class="form-control" id="inputEmail" type="email" name="email" " placeholder="
                                    Email" />
                                 <label for="inputEmail">Email</label>
                              </div>
                              <div class="row mb-3">
                                 <div class="col-12">
                                    <div class="form-floating mb-3 mb-md-0">
                                       <input class="form-control" id="inputPassword" type="password" name="password"
                                          placeholder=" Create a password" />
                                       <label for="inputPassword">Password</label>
                                    </div>
                                 </div>
                              </div>
                              <div class="mt-4 mb-0">
                                 <div class="d-grid"><button type="submit" name="buatakun"
                                       class="btn btn-primary btn-block">Simpan</button></div>
                              </div>
                           </form>
                        </div>
                        <div class="card-footer text-center py-3">
                           <div class="small"><a href="login.php">Sudah Punya Akun? Silahkan Pergi Halaman Login</a>
                           </div>
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
</body>

</html>