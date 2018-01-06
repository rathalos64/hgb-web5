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
		<div class="content has-text-centered">
			<p>
				Made with ♥ and Wiener Schnitzel
			</p>
		</div>
		<div class="content has-text-centered">
			<p>
				<strong>Note</strong>: the use of the color cyan on this site is given default by the framework and does not stand in affiliation with any political party
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
			toggle.parentElement.parentElement.parentElement.remove()
		}
	}
};

document.addEventListener("click", eventHandler);
</script>

<?php
ob_end_flush();
?>