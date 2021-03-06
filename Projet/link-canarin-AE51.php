<!DOCTYPE HTML>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Upload a File</title>
	</head>
	<body>
		
		<!--
			
			Polluscope Data Platforme by Yehia TAHER
			
			templated.co @templatedco
			
			Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
			
		-->
		
		
		<html>
			
			<head>
				
				<title>Polluscope Project</title>
				
				<meta charset="utf-8" />
				
				<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
				
				<meta name="description" content="" />
				
				<meta name="keywords" content="" />
				
				<link rel="stylesheet" href="assets/css/main2.css" />
				
				<link rel="stylesheet" href="assets/css/m1.css" />
				
				
			</head>
			
			<body class="is-preload">
				
				
				
				<!-- Header -->
				
				<header id="header">
					
					<a class="logo" href="index.php">Polluscope</a>
					
					<nav>
						
						<a href="#menu">Menu</a>
						
					</nav>
					
				</header>
				
				
				
				<!-- Nav -->
				
				<nav id="menu">
					
					<ul class="links">
						
						<b>Acquisition</b>
						
						<li><a href="get-flaten-data.php">Access and Filter </a></li>
						<li><a href="visualise-R.php">Filter and Visualise </a></li>
					<li><a href="visualise.php">Filter and Visualise V2 </a></li>
						<li><a href="upload-AE51.php">Upload AE51&Update canarin</a></li>	
						<li><a href="upload-cairsens.php">Upload Cairs&Update canarin</a></li>
						<li><a href="link-canarin-cairsens.php">Link Canarin-Cairsens</a></li>
						<li><a href="link-canarin-AE51.php">Link Canarin-AE51</a></li>
						
						<b>QUALIFICATION</b>
						
						<li><a href="upload-AE51-for-qualification.php">Upload AE51</a></li>	
						<li><a href="upload-cairsens-for-qualification.php">Upload Cairsens</a></li>
						<li><a href="upload-teom.php">Upload TEOM</a></li>	
						<li><a href="upload-fidas.php">Upload FIDAS</a></li>	
						<li><a href="upload-actris.php">Upload ACTRIS</a></li>
						<li><a href="upload-aethalometer.php">Upload AETHALOMETER</a></li>
						<li><a href="canarin-teom.php">Link Canarin-TEOM</a></li>
						<li><a href="canarin-fidas.php">Link Canarin-FIDAS</a></li>
						<li><a href="cairsens-actris.php">Link cairsens-ACTRIS</a></li>
						<li><a href="AE51-aethalometer.php">Link AE51-AETHALOMETER</a></li>
						
						
					</ul>
					
				</nav>
				
				
				
				<!-- Banner -->
				
				<section id="banner">
					
					<div class="inner">
						
						<h1>Polluscope Data Platform</h1>
						
						<p>A Cloud based Data platform<br>
							
						hosted at GLACTICA CNRS Cloud Platform.</p>
						
					</div>
					
					<!--	<video autoplay loop muted playsinline src="images/banner.mp4"></video> -->
					
				</section>
				
				
				
				<!-- Highlights -->
				
				<section class="wrapper">
					
					<div class="inner">
						
						
						
						<!-- Debut PhP Code par Yehia -->
						
						
						
						<?php
							
							
							// if ($dbcpolluscope = pg_Connect("host=193.55.95.225 port=25432 dbname=polluscope user=docker password=docker"))
							if ($dbcpolluscope = pg_Connect("host=localhost port=5432 dbname=polluscope user=postgres password=12345678 "))
							{  	 
						
						pg_exec($dbcpolluscope," CREATE TABLE IF NOT EXISTS \"AE51\"
								(
								\"Id\" serial,
								\"Device_ID\" text,
								\"Date\" date,
								\"Time\" time with time zone,
								\"Ref\" bigint,
								\"Sen\" bigint,
								\"ATN\" double precision,
								\"Flow\" integer,
								\"Temp\" integer,
								\"Status\" integer,
								\"Battery\" integer,
								\"BC\" bigint,
								CONSTRAINT \"AE51_pkey\" PRIMARY KEY (\"Id\") ) " );
								
								pg_exec($dbcpolluscope," CREATE TABLE IF NOT EXISTS \"link-canarin-AE51\"
								(
								id serial,
								canarin_id bigint,
								\"AE51_id\" text,
								CONSTRAINT \"link-canarin-AE51_pkey\" PRIMARY KEY (id)
								)
								" 
								);
								
							$creat=pg_exec($dbcpolluscope, "SELECT to_regclass('\"public\".\"AE51-list\"')");
							$row=pg_fetch_array($creat);
							if($row[0]==null)//if the table was not aleady exist
							{ 
							pg_exec($dbcpolluscope," CREATE TABLE IF NOT EXISTS \"AE51-list\" (id text)" );
							pg_exec($dbcpolluscope," INSERT INTO \"AE51-list\"(id)VALUES('AE51-S0-114-0903')" );	
							pg_exec($dbcpolluscope," INSERT INTO \"AE51-list\"(id)VALUES('AE51-S6-1241')" );
							
							}
							if (isset($_POST['AE51-name'])&&isset($_POST['canarinID'])&&$_POST['AE51-name']!='' && $_POST['canarinID']!="null") { 
									
									$AE51name=$_POST['AE51-name'];
									$canarinID=$_POST['canarinID'];
									
									$a=pg_exec($dbcpolluscope, "select * from \"AE51-list\" where id='$AE51name' ");
									$row1=pg_num_rows($a);
									if($row1==0)
									pg_exec($dbcpolluscope," INSERT INTO \"AE51-list\"(id)VALUES('$AE51name')" );
									$r=pg_exec($dbcpolluscope, "select * from \"link-canarin-AE51\" where \"canarin_id\"=$canarinID and \"AE51_id\"='$AE51name' ");
									$row2=pg_num_rows($r);
									if($row2==0)
									{ 
									pg_exec($dbcpolluscope, "INSERT INTO \"link-canarin-AE51\"(\"canarin_id\",\"AE51_id\") VALUES($canarinID,'$AE51name')");
									}

								}
								
								
								
								if (isset($_POST['AE51ID'])&&isset($_POST['canarinID'])&&$_POST['AE51ID']!="null" && $_POST['canarinID']!="null") { 
									
									$AE51ID=$_POST['AE51ID'];
									$canarinID=$_POST['canarinID'];
									
									$r=pg_exec($dbcpolluscope, "select * from \"link-canarin-AE51\" where \"canarin_id\"=$canarinID and \"AE51_id\"='$AE51ID' ");
									$row=pg_num_rows($r);
									if($row==0)
									pg_exec($dbcpolluscope, "INSERT INTO \"link-canarin-AE51\"(\"canarin_id\",\"AE51_id\") VALUES($canarinID,'$AE51ID')");	
									
									
								}
								
								if($queryAE51ID = pg_exec($dbcpolluscope, "select \"id\" from  \"AE51-list\" ") )
								{
									if($queryCanarinID = pg_exec($dbcpolluscope, "select id,name from  \"unified_node\" ") )
									{
										
									?> 
									
									<div class="highlights">
										<section>
											<div  class="content">
												
												<form action='' enctype="multipart/form-data" method="post">
													<?php	if (isset($_POST['AE51ID'])&&isset($_POST['canarinID'])&&$_POST['AE51ID']!="null" && $_POST['canarinID']!="null")
														{?>
														<p><h3 ><b>Added successfully</h3></b></p> 
														
														<?php }else {  ?>
														
														<p><h3 ><b>Make relation between AE51 and Canarin</h3></b></p>
													<?php } ?>
													<p style="display: -webkit-box" >
													ADD AE51 ID (optional): <br><input type="text" name="AE51-name" value='' ></p>
													<p style="display: -webkit-box" >
														<select class=button3 name=AE51ID  >	
															<option value=null >AE51 </option>
															<?php while( $AE51=pg_fetch_array($queryAE51ID) )
																{?>
																<option value=<?php echo $AE51[0];?> ><?php echo $AE51[0]; ?> </option>
															<?php }	?>
														</select>
														
														<select class=button6 name=canarinID  >	
															<option value=null >Canarin </option>
															<?php while( $Canarin=pg_fetch_array($queryCanarinID) )
																{?>
																<option value=<?php echo $Canarin[0];?> ><?php echo $Canarin[1]; ?> </option>
															<?php }	?>
														</select>
														<input type="submit" name="submit" value="Add" class=button7  />
													</p>
												</form>
											</div>
										</section>
										
										
										
										<?php
											
										}
										else { // queryId.
											
											print '<p style="color: red;">Could not run the query:<br />' ;
											
											
										} // End of query IF.
									}
									else { // queryDeviceID.
										
										print '<p style="color: red;">Could not run the query:<br />' ;
										
										
									} // End of query IF.
								} // end of: "if ($dbcpolluscope..."
								
								else { // if the connexion to polluscope (postgres) doesn't work... 
									
									print '<p style="color: red;">Could not connect to Postgres<br />'.'.</p>';
									
									mysqli_close($dbccanarin);
									
								}
								
								
								
								
								
							?>
							
							
							
						</div>
						
					</section> 
					
					
					
					<!-- CTA -->
					
					<section id="cta" class="wrapper">
						
						<div class="inner">
							
							<h2>To be added!</h2>
							
							<p>To be added!</p>
							
						</div>
						
					</section>
					
					
					
					<!-- Testimonials -->
					
					<section class="wrapper">
						
						<div class="inner">
							
							<header class="special">
								
								<h2>To be added!</h2>
								
								<p>To be added!</p>
								
							</header>
							
							<div class="testimonials">
								
								<section>
									
									<div class="content">
										
										<blockquote>
											
										<p>To be added!</p>
										
										</blockquote>
										
										<div class="author">
										
										<div class="image">
										
										<img src="images/pic01.jpg" alt="" />
										
										</div>
										
										<p class="credit">- <strong>Jane Doe</strong> <span>CEO - ABC Inc.</span></p>
										
										</div>
										
										</div>
										
										</section>
										
										<section>
										
										<div class="content">
										
										<blockquote>
										
										<p>Nunc lacinia ante nunc ac lobortis ipsum. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus.</p>
										
										</blockquote>
										
										<div class="author">
										
										<div class="image">
										
										<img src="images/pic03.jpg" alt="" />
										
										</div>
										
										<p class="credit">- <strong>John Doe</strong> <span>CEO - ABC Inc.</span></p>
										
										</div>
										
										</div>
										
										</section>
										
										<section>
										
										<div class="content">
										
										<blockquote>
										
										<p>Nunc lacinia ante nunc ac lobortis ipsum. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus.</p>
										
										</blockquote>
										
										<div class="author">
										
										<div class="image">
										
										<img src="images/pic02.jpg" alt="" />
										
										</div>
										
										<p class="credit">- <strong>Janet Smith</strong> <span>CEO - ABC Inc.</span></p>
										
										</div>
										
										</div>
										
										</section>
										
										</div>
										
										</div>
										
										</section>
										
										
										
										<!-- Footer -->
										
										<footer id="footer">
										
										<div class="inner">
										
										<div class="content">
										
										<section>
										
										<h3>To be added!</h3>
										
										<p>To be added!</p>
										
										</section>
										
										<section>
										
										<h4>To be added!</h4>
										
										<ul class="alt">
										
										<li><a href="#">Dolor pulvinar sed etiam.</a></li>
										
										<li><a href="#">Etiam vel lorem sed amet.</a></li>
										
										<li><a href="#">Felis enim feugiat viverra.</a></li>
										
										<li><a href="#">Dolor pulvinar magna etiam.</a></li>
										
										</ul>
										
										</section>
										
										<section>
										
										<h4>Magna sed ipsum</h4>
										
										<ul class="plain">
										
										<li><a href="#"><i class="icon fa-twitter">&nbsp;</i>Twitter</a></li>
										
										<li><a href="#"><i class="icon fa-facebook">&nbsp;</i>Facebook</a></li>
										
										<li><a href="#"><i class="icon fa-instagram">&nbsp;</i>Instagram</a></li>
										
										<li><a href="#"><i class="icon fa-github">&nbsp;</i>Github</a></li>
										
										</ul>
										
										</section>
										
										</div>
										
										<div class="copyright">
										
										&copy; Untitled. Photos <a href="https://unsplash.co">Unsplash</a>, Video <a href="https://coverr.co">Coverr</a>.
										
										</div>
										
										</div>
										
										</footer>
										
										
										
										<!-- Scripts -->
										
										<script src="assets/js/jquery.min.js"></script>
										
										<script src="assets/js/browser.min.js"></script>
										
										<script src="assets/js/breakpoints.min.js"></script>
										
										<script src="assets/js/util.js"></script>
										
										<script src="assets/js/main.js"></script>
										
										
										
										</body>
										
										</html>
										
										
										
										
										
										
										
																				