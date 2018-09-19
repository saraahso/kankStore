<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<div class="content-wrapper">
	<section class="content-header">
		<?php echo $pagetitle; ?>
		<?php echo $breadcrumb; ?>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">
							<?php echo anchor('admin/category/create', '<i class="fa fa-plus"></i> '. lang('categories_create_category'), array('class' => 'btn btn-block btn-primary btn-flat')); ?>
						</h3>
					</div>
					<div class="box-body">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>
										<?php echo lang('category_titulo');?>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($categories as $cat):?>
								<tr>
									<td class="col-md-10">
										<?php echo htmlspecialchars($cat->cat_titulo, ENT_QUOTES, 'UTF-8'); ?>
									</td>

									<td class="col-md-2">
										<?php echo anchor('admin/category/edit/'.$cat->cat_id, lang('actions_edit'), array('class' => 'btn btn-primary btn-flat')); ?>

										<?php echo anchor('admin/category/delete/'.$cat->cat_id, lang('actions_delete'), array('class' => 'btn btn-danger btn-flat')); ?>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>