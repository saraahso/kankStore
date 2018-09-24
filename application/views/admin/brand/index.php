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
							<?php echo anchor('admin/brand/create', '<i class="fa fa-plus"></i> '. lang('brands_create_brand'), array('class' => 'btn btn-block btn-primary btn-flat')); ?>
						</h3>
					</div>
					<div class="box-body">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>
										<?php echo lang('brand_titulo');?>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($brands as $brand):?>
								<tr>
									<td class="col-md-10">
										<?php echo htmlspecialchars($brand->mar_titulo, ENT_QUOTES, 'UTF-8'); ?>
									</td>

									<td class="col-md-2">
										<?php echo anchor('admin/brand/edit/'.$brand->mar_id, lang('actions_edit'), array('class' => 'btn btn-primary btn-flat')); ?>

										<?php echo anchor('admin/brand/delete/'.$brand->mar_id, lang('actions_delete'), array('class' => 'btn btn-danger btn-flat')); ?>
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