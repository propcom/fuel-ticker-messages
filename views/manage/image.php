<div class="control-group">
	<span class="control-label"></span>
    <input type="hidden" data-field="image_id" id="image_id" name="image_id" value="">
	<div class="controls">
		<? if($image): ?>
			<img src="/data/media/<?= $image->type->dir_name . $image->filename ?>" />
		<? endif ?>
		<a class="btn btn-primary" href="#" data-media-type="class-image" data-action="media_manager"> Image</a>
	</div>
</div>