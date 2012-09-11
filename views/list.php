<ul class="breadcrumb">
	<li><a href="/admin/">Admin</a> <span class="divider">/</span></li>
	<li>Ticker Messages</li>
</ul>
<header class="page-header">
	<h1>Ticker Messages</h1>
</header>

<div>
	<h3>Current message</h3>
	<div style=""><?=\Ticker\Model_Message::get_current_message()?></div>
</div>

<?= $datatable ?>

<div class="well">
	<a href="/admin/ticker/manage/create/" class="btn btn-primary" />Create Message</a>
</div>