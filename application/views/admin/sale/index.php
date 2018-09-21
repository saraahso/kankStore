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
							<?php echo anchor('admin/sale/create', '<i class="fa fa-plus"></i> '. lang('sales_create_sale'), array('class' => 'btn btn-block btn-primary btn-flat')); ?>
						</h3>
					</div>
					<div class="box-body">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>
										<?php echo lang('sale_date');?>
									</th>
									<th>
										<?php echo lang('sale_total');?>
									</th>
									<th>
										<?php echo lang('sale_tipoPagamento');?>
									</th>
									<th>
										<?php echo lang('menu_actions');?>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($sales as $sale){ ?>
								<tr>
									<td>
										<?php echo date('d/m/Y', strtotime($sale->ven_data) ); ?>
									</td>
									<td>
										<?php 
										setlocale(LC_MONETARY,"pt_BR.UTF-8");
										echo money_format("%n", $sale->ven_total); ?>
									</td>
									<td>
										<?php echo htmlspecialchars($sale->ven_tipo_pagamento, ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td>
										<?php echo anchor('admin/sale/see/'.$sale->ven_id, lang('actions_see'), array('class' => 'btn btn-primary btn-flat')); ?>
										<?php echo anchor('admin/sale/delete/'.$sale->ven_id, lang('actions_delete'), array('class' => 'btn btn-danger btn-flat')); ?>
									</td>
								</tr>
								<?php }?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>