<?php require_once("C:/xampp/htdocs" . "/views/partials/header.php"); ?>

<section class="hero">
<div class="hero-body">
	<div class="container">
		<p class="title">
			Audit log <i class="fa fa-comment-o"></i>
		</p>
		<p class="subtitle">
			All your actions your have done
		</p>
	</div>
</div>
</section>

<hr>

<section class="section">
    <div class="container">
		
		<table class="table table is-fullwidth">
			<thead>
				<tr>
					<th>Action</th>
					<th>IP</th>
					<th>Browser</th>
					<th>When</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($audits as $audit): ?>
				<tr>
					<td><?= e($audit->getAction()) ?></td>
					<td><?= e($audit->getIp()) ?></td>
					<td><?= \App\Utils::getBrowser(e($audit->getUserAgent())) ?></td>
					<td><?= date(DATE_RFC2822, e($audit->getCreatedAt())) ?></td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>

		<nav class="pagination">
			<ul class="pagination-list">
				<?php for($i = 1; $i <= $pages; $i++): ?>
					<li>
						<a 
							href="/home/audit?page=<?= e($i) ?>" 
							class="pagination-link <?php if($i == $page): ?>is-current<?php endif ?>">
							<?= e($i) ?>
						</a>
					</li>
				<?php endfor ?>
			</ul>
		</nav>
	</div>
</section>

<?php require_once("C:/xampp/htdocs" . "/views/partials/footer.php"); ?>