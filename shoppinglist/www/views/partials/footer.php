<section class="section">
<div class="container">
<?php if (isset($error)): ?>
	<div class="notification is-danger">
		<button class="delete"></button>
		<strong><?= e($error) ?></strong>
	</div>
<?php endif ?>
</div>
</section>
</div>

<footer class="footer">
	<div class="container">
		<div class="content has-text-centered">
			<p>
				<strong>Built</strong> by <a href="https://github.com/rathalos64">Alen Kocaj</a>. 
				The source code is licensed <a href="http://opensource.org/licenses/mit-license.php">MIT</a>. <br/>
				The website content is licensed <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">CC BY NC SA 4.0</a>.
			</p>
		</div>
	</div>
</footer>

<script>
var eventHandler = function (event) {
	// get the clicked element
	var toggle = event.target;
	if (toggle.nodeName.toLowerCase() === "button") {
		
		// for all submit buttons
		if (toggle.classList.contains("delete")) {
			toggle.parentElement.remove()
		}
	}
};

document.addEventListener("click", eventHandler);
</script>

<?php
ob_end_flush();
?>