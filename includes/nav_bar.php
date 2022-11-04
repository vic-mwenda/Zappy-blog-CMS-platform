<header id="header" class="header d-flex align-items-center fixed-top">
	<div class="container-fluid container-xl d-flex align-items-center justify-content-between">

		<a href="index.php" class="logo d-flex align-items-center">
			<h1>Zappy</h1>
		</a>

		<nav id="navbar" class="navbar">
			<ul>
				<li><a href="index.php?">Blog</a></li>
				<?php
				$query = "SELECT * FROM `posts` WHERE id=34 ORDER BY updated_on DESC";
				$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
				if (mysqli_num_rows($run_query) > 0) {
				while ($row = mysqli_fetch_assoc($run_query)) {
					$post_id = $row['id'];
				if ($post_status='published'){
				?><li><a href="single-post.php?post=<?php echo $post_id;?>">Single Post</a></li>
				<?php }
					  else{ echo "No content posts";}}}
					  ?>

				<li class="dropdown"><a href=""><span>Categories</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
					<ul>
						<?php
						$query = "SELECT tag FROM `posts`";
						$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
						if (mysqli_num_rows($run_query) > 0) {
						while ($row = mysqli_fetch_assoc($run_query)) {
						$post_tag = $row['tag'];
						if (is_string($post_tag)){
						?><li><a href="category.php?category=<?php echo $post_tag?>"><?php echo $post_tag?></a></li>
						<?php }
					  else{ echo "No categories";}}}
					  ?>
					</ul>

				<li><a href="about.php?">About</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><b class="caret"></b></a>



					<ul class="dropdown-menu">
						<?php
						if (isset($_SESSION['username'])) {
							?>
							<li>
								<a href="admin/profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="admin/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
							</li>
						<?php
						} else{
							?>
							<li>
								<a href="admin/index.php"><i class="fa-solid fa-right-to-bracket"></i>Log In</a>
							</li>
						<?php
						}
						?>

					</ul>
				</li>
				<li>
					<a href="#" class="mx-2 js-search-open"><span class="fa fa-search"></span><b class="caret"></b></a>
					<div class="search-form-wrap js-search-form-wrap">
						<button class="btn js-search-close"><span class="bi-x"></span></button>
					</div><!-- End Search Form -->
				</li>
			</ul>

		</nav><!-- .navbar -->







			<i class="bi bi-list mobile-nav-toggle"></i>

			<!-- ======= Search Form ======= -->


		</div>

	</div>

</header><!-- End Header -->
