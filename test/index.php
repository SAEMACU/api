<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once '../config/database.php';
include_once '../objects/postmaster.php';

if(!isset($_SESSION['id']))
{
	header('Location: http://www.organicway.co.in/api/api/test/login.php');	
}
$database = new Database();
$db = $database->getConnection();
 
$post_master = new Postmaster($db);
 
$read = $post_master->read();
$num = $read->rowCount();

/*checking if more than 0 records found*/
if($num>0){
 
    $post_arr = array();
    $post_arr["posts"] = array();
    while ($row = $read->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $post_entries = array(
            "user_email" => $user_email,
            "post_image" => $post_image,
            "user_id" => $user_id,
            "post_text" => $post_text,
            "id" => $id,
			"like_diislike" => $like_diislike,
        );
        array_push($post_arr["posts"], $post_entries);
    }
}

?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="CodePixar">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>Blogging</title>

	<link href="https://fonts.googleapis.com/css?family=Poppins:300,500,600" rel="stylesheet">
		<!--
		CSS
		============================================= -->
		<link rel="stylesheet" href="css/linearicons.css">
		<link rel="stylesheet" href="css/owl.carousel.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="css/nice-select.css">
		<link rel="stylesheet" href="css/magnific-popup.css">
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
	
		<div class="main-wrapper-first">
			<header>
				<div class="container">
					<div class="header-wrap">
						<div class="header-top d-flex justify-content-between align-items-center">
							<div class="logo">
								<a href="index.html"><img src="img/logo.png" alt=""></a>
							</div>
							<div class="main-menubar d-flex align-items-center">
								<nav class="hide">
									<a href="http://www.organicway.co.in/api/api/test/index.php">Home</a>
									<a href="http://www.organicway.co.in/api/api/test/upload_posts.php">Upload Post</a>
								</nav>
								<div class="menu-bar"><span class="lnr lnr-menu"></span></div>
							</div>
						</div>
					</div>
				</div>
			</header>
		</div>
		
		<div class="main-wrapper">
			<!-- Start Feature Area -->
			<section class="featured-area">
				<div class="container">
					<div class="row">
					<?php $i = 0;foreach($post_arr['posts'] as $k => $v) { ?>
						<div class="col-md-4">
							<div class="single-feature">
								<div class="icon">
									<img src="<?php echo 'http://www.organicway.co.in/api/api/objects/img/' . $v['post_image']; ?>" alt="no">
								</div>
								<div class="desc text-center">
									<?php if($v['like_diislike']){?>									
									<p>Liked <i class="fa fa-heart" aria-hidden="true"></i></p>	
									<?php } else{ ?>	
									<p id="p<?php echo $v['id'];?>"onclick="onclickchangestatus(<?php echo $v['id']; ?>)">Like <i class="fa fa-heart" aria-hidden="true"></i></p>									
									<?php } ?>
									<h6 class="title text-uppercase"><?php echo $v['post_text']; ?></h6>
								</div>
							</div>
						</div>
					<?php } ?>
						
					</div>
				</div>
			</section>
			<!-- End Feature Area -->
			
			<!-- Start Amazing Works Area -->

			<section class="amazing-works-area">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-8">
							<div class="section-title text-center">
								<h3>Our Amazing Works</h3>
								<span class="text-uppercase">Re-imagining the way</span>
							</div>
						</div>
					</div>
					<div class="active-works-carousel mt-40">
						<div class="item">
							<div class="thumb" style="background: url(img/c1.jpg);"></div>
							<div class="caption text-center">
								<h6 class="text-uppercase">Vector Illustration</h6>
								<p>LCD screens are uniquely modern in style, and the liquid crystals <br> that make them work have allowed humanity to</p>
							</div>
						</div>
						<div class="item">
							<div class="thumb" style="background: url(img/c1.jpg);"></div>
							<div class="caption text-center">
								<h6 class="text-uppercase">Vector Illustration</h6>
								<p>LCD screens are uniquely modern in style, and the liquid crystals <br> that make them work have allowed humanity to</p>
							</div>
						</div>
						<div class="item">
							<div class="thumb" style="background: url(img/c1.jpg);"></div>
							<div class="caption text-center">
								<h6 class="text-uppercase">Vector Illustration</h6>
								<p>LCD screens are uniquely modern in style, and the liquid crystals <br> that make them work have allowed humanity to</p>
							</div>
						</div>
						<div class="item">
							<div class="thumb" style="background: url(img/c1.jpg);"></div>
							<div class="caption text-center">
								<h6 class="text-uppercase">Vector Illustration</h6>
								<p>LCD screens are uniquely modern in style, and the liquid crystals <br> that make them work have allowed humanity to</p>
							</div>
						</div>
						<div class="item">
							<div class="thumb" style="background: url(img/c1.jpg);"></div>
							<div class="caption text-center">
								<h6 class="text-uppercase">Vector Illustration</h6>
								<p>LCD screens are uniquely modern in style, and the liquid crystals <br> that make them work have allowed humanity to</p>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- End Amazing Works Area -->
		
				<footer>
					<div class="container">
						<div class="footer-content d-flex justify-content-between align-items-center flex-wrap">
							<div class="logo">
								<a href="index.html"><img src="img/f-logo.png" alt=""></a>
							</div>
							<div class="copy-right-text">Copyright &copy; 2017  |  All rights reserved. This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></div>
							<div class="footer-social">
								<a href="#"><i class="fa fa-facebook"></i></a>
								<a href="#"><i class="fa fa-twitter"></i></a>
								<a href="#"><i class="fa fa-dribbble"></i></a>
								<a href="#"><i class="fa fa-behance"></i></a>
							</div>
						</div>
					</div>
				</footer>
			</section>
			<!-- End Footer Widget Area -->

		</div>




		<script src="js/vendor/jquery-2.2.4.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="js/vendor/bootstrap.min.js"></script>
		<script src="js/jquery.ajaxchimp.min.js"></script>
		<script src="js/owl.carousel.min.js"></script>
		<script src="js/jquery.nice-select.min.js"></script>
		<script src="js/jquery.magnific-popup.min.js"></script>
		<script src="js/main.js"></script>
		<script src="js/default_js.js"></script>
	</body>
</html>

