<div class="control-group cms-mediamanager-image<?= isset($class) ? ' '.$class : '' ?>" >
	<input name="<?= $mm_field_name ?>" type="hidden" value="<?= $image ? $image->id : ''?>">
	<span class="control-label"><?= isset($item_label) ? $item_label : '' ?></span>
	<div class="controls">
		<div class="cms-mediamanager-selected-cont">
			<div class="cms-mediamanager-selected-item cloneable" style="display:none">
			</div>
			<? if($image): ?>
				<div class="cms-mediamanager-selected-item">
					<img src="<?= \Config::get('mediamanager.web_dir')?>all/150x150/<?= $image->filename ?>" />
				</div>
			<? endif ?>
		</div>
		<a class="btn btn-primary" href="#" data-media-type="<?= $media_type ?>" data-action="media_manager"
			data-mm-multi="<?= $mm_multi ?>" data-mm-field-name="<?= $mm_field_name ?>"	><?= isset($label) ? $label : 'Add Image' ?></a>
	</div>
</div>
