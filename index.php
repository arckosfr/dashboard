<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex">
	<title>Dashboard - DOMAIN.TLDyz</title> <!-- a modifier selon votre configuration -->
        <!--<link rel="icon" type="img" href="favicon.png">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/normalize/3.0.3/normalize.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> -->

	<link rel="stylesheet" href="css/normalize.min.css">
    	<link rel="stylesheet" href="css/bootstrap.min.css">
    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/css.min.css">
</head>

<body>

<nav class="navbar navbar-inverse">
    <?php
		function get_server_cpu_usage(){
			$loads = sys_getloadavg();
			$core_nums = trim(shell_exec("grep -P '^processor' /proc/cpuinfo|wc -l"));
			$load = round($loads[0]/($core_nums + 1)*100, 2);
			return $load;
		}
		function get_server_mem_usage(){
			$total = shell_exec("awk '/MemTotal/ { print $2 }' /proc/meminfo");
			$available = shell_exec("awk '/MemAvailable/ { print $2 }' /proc/meminfo");
			$used = $total-$available;
			$memory_usage = round($used/$total*100);
			return $memory_usage;
		}
		function get_server_uptime(){
			$data = shell_exec('uptime');
			$uptime = explode(' up ', $data);
			$uptime = explode(',', $uptime[1]);
			$uptime = $uptime[0].', '.$uptime[1];
			return $uptime;
		}
		function get_torrent() {
			$user = $_SERVER['PHP_AUTH_USER'];
			$torrent = shell_exec("ls /home/".$user."/.session/*.torrent|wc -l");
			return $torrent;
		}
		function get_torrent_name() {
			$user = $_SERVER['PHP_AUTH_USER'];
			$lastitem = shell_exec("ls -rt /home/".$user."/torrents/ | tail -1");
			return $lastitem;
		}
		function get_disk() {
			$user = $_SERVER['PHP_AUTH_USER'];
			$df = round(disk_free_space("/home/".$user."/") /1024 /1024 /1024);
			$dt = round(disk_total_space("/home/".$user."/") /1024 /1024 /1024);
			$dp = round($df/$dt*100);
			return $dp;
		}
		?>
		
		
	<a class="navbar-brand" href="#box">Lemark.xyz</a>
		<ul class="nav navbar-nav">
			<li><a></a>
			<li><a></a>
		    <li><a>CPU : <?= get_server_cpu_usage() ?>%</a>
		    <li><a>RAM : <?= get_server_mem_usage() ?>%</a>
		    <li><a>UPTIME :  <?= get_server_uptime() ?></a>
		    <li><a>Espace libre :  <?= get_disk() ?> %</a>
    	</ul>
</nav>

<div class="container">
	<div class ="row row-centered">
		<div class ="col-md-4 col-md-offset-4">
		<div class="vcenter"><a href="#box"><img SRC="logo.png"></a></div>
		</div>
	</div>
</div>

<div class ="container">
	<div class ="row row-centered">
		<div id="box">
			<div class="col-xs-12">
				<div class="carousel slide">
					<div class="carousel-inner">
		            	<div class="item active">
							<h2>torrents actif : <?= get_torrent() ?></h2>
						</div>
						<div class="item">
							<h2>Dernier torrent : <?= get_torrent_name() ?></h2>
						</div>
					</div>
				</div>
			</div>
						
			<div class="col-sm-12 col-xs-12">
				<?php include("tiles.php"); ?>
			</div>
			
		</div>
	</div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    $('.carousel').carousel({
        interval: 5000
    })
</script>

</body>
</html>
