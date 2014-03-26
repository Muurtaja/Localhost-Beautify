<html>
	<head>
		<link href="localhostBootstrap/bootstrap-3.1.1-dist/css/bootstrap.css" rel="stylesheet">
		<script type="text/javascript" src="localhostBootstrap/bootstrap-3.1.1-dist/js/jquery-2.1.0.min.js"></script>
		<script type="text/javascript" src="localhostBootstrap/bootstrap-3.1.1-dist/js/bootstrap.js"></script>
	</head>	
<body>
	<div class="container">
		<a href="<?php echo $Webservice::$host?>"><h1>Webserver</h1></a>
		<?php echo $Webservice::createBreadcrumb(); ?>
		<div class="row">
	   		<div class="col-lg-6">
				
				<h3 >List of Files</h3>	
				<div class="list-group">
					<?php 
						echo $Webservice::generateDropDown('success','Order by');
						echo $Webservice::generateDropDown('info','Direction');
					 ?>					
				</div>

				<?php echo $Webservice::listFiles(); ?>
			
			</div>
			<div class="col-lg-6">
				<?php if($Webservice::$Online){ ?>
				<div class="list-group">
					<h3>Shortcuts Online</h3>
					<?php 					
					foreach ($Webservice::$Online as $key => $value) {
						echo"<a target='_blank' class='list-group-item' 
						href='". $value["link"]. "' >" . $value['value'] ."</a>";
					}					
					?>							
				</div>
				<?php } ?> 
				<div class="list-group">
					<h3>Shortcuts Offline</h3>
					<?php 					
					foreach ($Webservice::$Offline as $key => $value) {
						echo"<a target='_blank' class='list-group-item' 
						href='". $value["link"]. "' >" . $value['value'] ."</a>";
					}
					?>				 
				</div>
			</div>
		</div>
 	</div>

</body>
</html>