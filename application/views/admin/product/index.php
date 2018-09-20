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
							<?php echo anchor('admin/product/create', '<i class="fa fa-plus"></i> '. lang('products_create_product'), array('class' => 'btn btn-block btn-primary btn-flat')); ?>
						</h3>
					</div>
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>
										<?php echo lang('product_cod');?>
									</th>
									<th>
										<?php echo lang('product_name');?>
									</th>
									<th>
										<?php echo lang('product_size');?>
									</th>
									<th>
										<?php echo lang('product_color');?>
									</th>
									<th>
										<?php echo lang('product_stock');?>
									</th>
									<th>
										<?php echo lang('product_category');?>
									</th>
									<th>
										<?php echo lang('product_brand');?>
									</th>
									<th>
										<?php echo lang('product_cost_value');?>
									</th>
									<th>
										<?php echo lang('product_sell_value');?>
									</th>
									<th>
										<?php echo lang('products_action');?>
									</th>

								</tr>
							</thead>
							<tbody>

								<?php foreach($products as $prod){ ?>
								<tr>
									<td>
										<?php echo htmlspecialchars($prod->prod_codigo, ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td>
										<?php echo htmlspecialchars($prod->prod_nome, ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td>
										<?php echo htmlspecialchars($prod->prod_tamanho, ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td>
										<?php echo htmlspecialchars($prod->prod_cor, ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td>
										<?php echo htmlspecialchars($prod->prod_estoque, ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td>
										<?php echo htmlspecialchars($prod->cat_titulo, ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td>
										<?php echo htmlspecialchars($prod->mar_titulo, ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td>
										<?php 
										setlocale(LC_MONETARY,"pt_BR.UTF-8");
										echo money_format("%n", $prod->prod_valor_de_custo); ?>

									</td>
									<td>
										<?php 
										setlocale(LC_MONETARY,"pt_BR.UTF-8");
										echo money_format("%n", $prod->prod_valor_de_venda); ?>
									</td>

									<td>
										<?php echo anchor('admin/product/edit/'.$prod->prod_id, lang('actions_edit'), array('class' => 'btn btn-primary btn-flat')); ?>
										<?php echo anchor('admin/product/delete/'.$prod->prod_id, lang('actions_delete'), array('class' => 'btn btn-danger btn-flat')); ?>
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