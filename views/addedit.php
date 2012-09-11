<ul class="breadcrumb">
	<li><a href="/admin">Admin</a> <span class="divider">/</span></li>
	<li><a href="/admin/ticker/manage/">Flash Messages</a> <span class="divider">/</span></li>
	<li	class="active"><?= $message->is_new() ? 'Create' : 'Edit' ?> Message</li>
</ul>
<div class="row">

	<div class="row span12">
		<div id="create_employee">
			<header class="page-header row">
				<h1><?= $message->is_new() ? 'Create' : 'Edit' ?> Message</h1>
			</header>
			<?= $fieldset ?>
		</div>
	</div>

</div>