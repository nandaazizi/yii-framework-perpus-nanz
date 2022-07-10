<?php 
		include_once('lib/config.php');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Perpustakaan-Studyzie</title>

    <!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet" >

<meta name="theme-color" content="#563d7c">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <link href="css/blog.css" rel="stylesheet">
  </head>
  <body>
    
<div class="container">
<header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
      <div class="col-4 pt-1">
      <img class="d-none d-lg-inline text-gray-600 small" width="40" src="gambar/logos.jpg" />
      <span class=" d-none d-lg-inline text-gray-600 small">Hallo <?= (Helper::session('nama')); ?></span>
      </div>
      <div class="col-4 text-center">
        <a class="blog-header-logo text-dark">Studyzie</a>
      </div>
      <div class="col-4 d-flex justify-content-end align-items-center">
      <span class="btn btn-info" class=" d-none d-lg-inline text-gray-600 small">Level <?= (Helper::session('group')); ?></span>
      </div>
    </div>
  </header>

  <div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-between">
      <a class="btn btn-info" class="p-2 text-muted" href="?">Home</a>
      <?php 
	  if(isset($_SESSION['group']) && 
		($_SESSION['group']=='admin'||$_SESSION['group']=='super_user')
	  ){ 
		  ?>
		  <a class="p-2 text-muted" href="?modul=user">User</a>
      <a class="p-2 text-muted" href="?modul=buku">Buku</a>
		  <a class="p-2 text-muted" href="?modul=pegawai">Pegawai Perpustakaan</a>
		  <a class="p-2 text-muted" href="?modul=pinjam">Pinjam Buku</a>
		  <?php 
	  }
	  else if(isset($_SESSION['group']) && $_SESSION['group']=='member'){
		  ?>
		  <a class="p-2 text-muted" href="?modul=buku1">Buku</a>
      <a class="p-2 text-muted" href="?modul=pegawai1">Pegawai Perpustakaan</a>
		  <?php 
	  }
		if(isset($_SESSION['user']) && $_SESSION['user']!=''){ ?>
		<a class="btn btn-danger"class="p-2 text-muted" href="?modul=login&act=logout">Logout</a>
	  <?php } 
		else { ?>
		<a class="btn btn-primary" class="p-2 text-muted" href="?modul=login">Login</a>
	  <?php } ?>
    </nav>
  </div>
  <?php 
  if(!isset($_GET['modul']) ){ ?>
  <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
    <div class="col-md-6 px-0">
      <h1 class="display-4 font-italic">Profiel Studyzie</h1>
      <p class="lead my-3">Misi perpustakaan Studyzie adalah Menciptakan dan memantapkan kebiasaan membaca masyarakat sesuai dengan jenis perpustakaan dan pemakainya. Mendukung pendidikan perorangan secara mandiri maupun pendidikan formal pada semua jenjang.</p>
      <img class="d-none d-lg-inline text-gray-600 small" width="1000" height="280" src="gambar/perpus.jpg" />
    </div>
  </div>
  </div>
  <?php } ?>
</div>

<main role="main" class="container">
  <div class="row">
    <div class="col-md-8 blog-main">
    <?php 
		if(isset($_GET['modul']) && $_GET['modul']!=''){
			include_once('controller/'.$_GET['modul'].'.php');	
		}
		
	?>

    </div><!-- /.blog-main -->

  </div><!-- /.row -->

</main><!-- /.container -->




    
  </body>
</html>
