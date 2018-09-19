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
						<h3 class="box-title">xxxx</h3>
					</div>
					<div class="box-body">
						<table class="table table-striped table-hover">
							<tbody>
								<?php foreach ($sale_info as $info):?>
								<tr>
									<th>
										<?php echo lang('sale_date'); ?>
									</th>
									<td>
										<?php echo date('d/m/Y', strtotime($info->ven_data));  ?>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
						<table class="table table-striped table-hover">
							<thead>
								<tr>
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
										<?php echo lang('product_category');?>
									</th>
									<th>
										<?php echo lang('product_brand');?>
									</th>
									<th>
										<?php echo lang('itv_qtd');?>
									</th>
									<th>
										<?php echo lang('product_sell_value');?>
									</th>


								</tr>
							</thead>
							<tbody>
								<?php foreach($info->products as $product){ ?>
								<tr>
									<td>
										<?php echo htmlspecialchars($product->prod_nome, ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td>
										<?php echo htmlspecialchars($product->prod_tamanho, ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td>
										<?php echo htmlspecialchars($product->prod_cor, ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td>
										<?php echo htmlspecialchars($product->cat_titulo, ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td>
										<?php echo htmlspecialchars($product->mar_titulo, ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td>
										<?php echo htmlspecialchars($product->itv_qtd, ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td>
										<?php echo htmlspecialchars($product->prod_valor_de_venda, ENT_QUOTES, 'UTF-8'); ?>
									</td>
								</tr>
								<?php }?>
							</tbody>
						</table>
						<table class="table table-striped table-hover">
							<tbody>
								<?php foreach ($sale_info as $info):?>
								<tr>
									<th>
										<?php echo lang('sale_total'); ?>
									</th>
									<td>
										<?php echo $info->ven_total; ?>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<div class="btn-group">
							<?php echo anchor('admin/sale', lang('actions_back'), array('class' => 'btn btn-default btn-flat')); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>