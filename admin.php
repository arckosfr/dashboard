<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex">
	<title>Dashboard - DOMAIN.TLD</title>
	<link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/css.css">
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
		function get_json(){
			$json = file_get_contents('service.json');
			$data = json_decode($json, true);
			return $data;
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


	<div class="container">
  <div class="panel panel-default">
  <div class="panel-heading">Administration</div>
  <div class="panel-body">    
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th class ="text-center">Couleur</th>
        <th class ="text-center">Lien</th>
        <th class ="text-center">Titre</th>
        <th class ="text-center">Icone</th>
        <th class ="text-center">Preview</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach (get_json() as $item) { ?>
      <tr>
        <td class= "text-center editable" id=<?= $item[id] ?>_color><?= $item[color] ?></td>
        <td class= "text-center editable" id=<?= $item[id] ?>_lien><?= $item[lien] ?></td>
        <td class= "text-center editable" id=<?= $item[id] ?>_titre><?= $item[titre] ?></td>
        <td class= "text-center editable" id=<?= $item[id] ?>_icone><?= $item[icone] ?></td>
        <td class= "text-center" ><i class="fa fa-2x <?= $item[icone] ?>"></i></td>
       </tr>
	<?php } ?>
    </tbody>
  </table>
	</div>  
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.jeditable.min.js"></script>
<script>$(document).ready(function() {
      $('.editable').editable('save.php', {
      	event     : "dblclick",
        callback : function(value, settings) {
         window.location.reload();
    	}});
});</script>
</body>
</html>
