<?php
require_once(getenv("PROJECT_ROOT") . "/config/views/pre.php");
ob_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>The Shopping List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="/assets/css/bulma.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.min.css">

</head>
<body>

<nav class="navbar">
<!-- <div class="navbar-brand">
  <a class="navbar-item" href="https://bulma.io">
	<img src="https://bulma.io/images/bulma-logo.png" alt="Bulma: a modern CSS framework based on Flexbox" width="112" height="28">
  </a>
  <div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
	<span></span>
	<span></span>
	<span></span>
  </div>
</div> -->
<div class="navbar-brand">
	
	<?php if (!isset($user)): ?>
		<a class="navbar-item" href="/">
			<img src="/assets/images/logo.png" alt="The Shoppinglist" width="162" height="38">
		</a>
	<?php else: ?>
		<a class="navbar-item" href="/home/dashboard">
			<img src="/assets/images/logo.png" alt="The Shoppinglist" width="162" height="38">
		</a>
	<?php endif ?>
  
	<div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
	<span></span>
	<span></span>
	<span></span>
  </div>
</div>

<div id="navbarExampleTransparentExample" class="navbar-menu">
  <!-- <div class="navbar-start">
	<a class="navbar-item" href="https://bulma.io/">
	  Home
	</a>
	<div class="navbar-item has-dropdown is-hoverable">
	  <a class="navbar-link" href="/documentation/overview/start/">
		Docs
	  </a>
	  <div class="navbar-dropdown is-boxed">
		<a class="navbar-item" href="/documentation/overview/start/">
		  Overview
		</a>
		<a class="navbar-item" href="https://bulma.io/documentation/modifiers/syntax/">
		  Modifiers
		</a>
		<a class="navbar-item" href="https://bulma.io/documentation/columns/basics/">
		  Columns
		</a>
		<a class="navbar-item" href="https://bulma.io/documentation/layout/container/">
		  Layout
		</a>
		<a class="navbar-item" href="https://bulma.io/documentation/form/general/">
		  Form
		</a>
		<hr class="navbar-divider">
		<a class="navbar-item" href="https://bulma.io/documentation/elements/box/">
		  Elements
		</a>
		<a class="navbar-item is-active" href="https://bulma.io/documentation/components/breadcrumb/">
		  Components
		</a>
	  </div>
	</div>
  </div> -->

  <div class="navbar-end">

		<?php if (!isset($user)): ?>

			<div class="navbar-item">
				<form action="/auth/login" method="POST">
					<div class="field">
						<div class="control has-icons-left">
							<input class="input is-primary is-medium" type="text" name="username" placeholder="Username"/>		
							<span class="icon is-small is-left"><i class="fa fa-user"></i></span>
						</div>	
					</div>
				</div>

				<div class="navbar-item">
					<div class="field">
						<div class="control has-icons-left">
							<input class="input is-primary is-medium" type="password" name="password" placeholder="Password"/>		
							<span class="icon is-small is-left"><i class="fa fa-lock"></i></span>
						</div>	
					</div>
				</div>

				<div class="navbar-item">
					<div class="field is-grouped">
					<p class="control">
						<button class="button is-primary is-medium">
						<span class="icon">
							<i class="fa fa-sign-in"></i>
						</span>
						<span>Login</span>
						</button>
					</p>
					</div>
				</form>
			</div>
		
		<?php else: ?>

			<div class="navbar-item">
				<form action="/auth/logout" method="POST">
					<div class="field is-grouped">
					<p class="control">
						<button class="button is-primary is-medium">
						<span class="icon">
							<i class="fa fa-sign-out"></i>
						</span>
						<span>Logout</span>
						</button>
					</p>
					</div>
				</form>
			</div>

		<?php endif ?>

	</div>
</div>
</nav>

<div class="container">

<?php if (isset($error)): ?>
<section class="section">
	<div class="container">
		<div class="notification is-danger">
			<button class="delete"></button>
			<strong><?= e($error) ?></strong>
		</div>
	</div>
</section>
<?php endif ?>