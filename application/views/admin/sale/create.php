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
							<?php echo lang('products_create_product'); ?>
						</h3>
					</div>
					<div class="box-body">
						<?php echo $message;?>

						<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-create_product')); ?>

						<button class="btn btn-success" onclick="add_product(<?php $products ?>)">
							<i class="fa fa-plus" aria-hidden="true"></i> Add Produto</button>

						<div class="form-group">
							<?php echo lang('product_search', 'name', array('class' => 'col-sm-2 control-label')); ?>

							<table class="table table-striped table-hover" id="table_id">
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
											<?php echo htmlspecialchars($prod->prod_valor_de_custo, ENT_QUOTES, 'UTF-8'); ?>
										</td>
										<td>
											<?php echo htmlspecialchars($prod->prod_valor_de_venda, ENT_QUOTES, 'UTF-8'); ?>
										</td>

										<td>
											<?php echo anchor('admin/product/edit/'.$prod->prod_id, lang('actions_edit')); ?>
											<?php echo anchor('admin/product/delete/'.$prod->prod_id, lang('actions_delete')); ?>
										</td>
									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<div class="btn-group">
									<?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => lang('actions_submit'))); ?>
									<?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning btn-flat', 'content' => lang('actions_reset'))); ?>
									<?php echo anchor('admin/product', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
								</div>
							</div>
						</div>
						<?php 
						
                        echo form_close();?>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>




<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title">Produtos</h3>
			</div>
			<div class="modal-body form">
				<form action="#" id="form" class="form-horizontal">
					<input type="hidden" value="" name="prod_id" />
					<div class="form-body">
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
								</tr>
							</thead>
							<tbody>
								<?php foreach($products as $prod){ ?>
								<tr>
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
										<?php echo htmlspecialchars($prod->prod_valor_de_custo, ENT_QUOTES, 'UTF-8'); ?>
									</td>
									<td>
										<?php echo htmlspecialchars($prod->prod_valor_de_venda, ENT_QUOTES, 'UTF-8'); ?>
									</td>
								</tr>
								<?php }?>
							</tbody>
						</table>

				</form>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Salvar</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- End Bootstrap modal -->