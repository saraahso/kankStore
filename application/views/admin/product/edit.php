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
							<?php echo lang('products_edit_product'); ?>
						</h3>
					</div>
					<div class="box-body">
						<?php echo $message;?>

						<?php echo form_open('admin/product/save_changes', array('class' => 'form-horizontal', 'id' => 'form-edit_product'));
                            foreach($products as $product){
						?>
						<div class="form-group">
							<?php echo lang('product_cod', 'cod', array('class' => 'col-sm-2 control-label')); ?>
							<div class="col-sm-10">
								<input type="text" id="cod" name="cod" readonly="readonly" class="form-control" value="<?php echo $product->prod_codigo ?>">
							</div>
						</div>
						<div class="form-group">
							<?php echo lang('product_name', 'name', array('class' => 'col-sm-2 control-label')); ?>
							<div class="col-sm-10">
								<input type="text" id="name" name="name" class="form-control" value="<?php echo $product->prod_nome ?>">
							</div>
						</div>
						<div class="form-group">
							<?php echo lang('product_size', 'size', array('class' => 'col-sm-2 control-label')); ?>
							<div class="col-sm-10">
								<input type="text" id="size" name="size" class="form-control" value="<?php echo $product->prod_tamanho ?>">
							</div>
						</div>
						<div class="form-group">
							<?php echo lang('product_color', 'color', array('class' => 'col-sm-2 control-label')); ?>
							<div class="col-sm-10">
								<input type="text" id="color" name="color" class="form-control" value="<?php echo $product->prod_cor ?>">
							</div>
						</div>
						<div class="form-group">
							<?php echo lang('product_stock', 'stock', array('class' => 'col-sm-2 control-label')); ?>
							<div class="col-sm-10">
								<input type="text" id="stock" name="stock" class="form-control" value="<?php echo $product->prod_estoque ?>">
							</div>
						</div>
						<div class="form-group">
							<?php echo lang('product_category', 'category', array('class' => 'col-sm-2 control-label')); ?>
							<div class="col-sm-10">
								<?php echo form_dropdown('category', $categories, '', array('class' => 'form-control')); ?>
							</div>
						</div>
						<div class="form-group">
							<?php echo lang('product_brand', 'brand',array('class' => 'col-sm-2 control-label')); ?>
							<div class="col-sm-10">
								<?php echo form_dropdown('brand', $brands, '', array('class' => 'form-control')); ?>
							</div>
						</div>
						<div class="form-group">
							<?php echo lang('product_cost_value', 'cost_value', array('class' => 'col-sm-2 control-label')); ?>
							<div class="col-sm-10">
								<input type="text" id="cost_value" name="cost_value" class="form-control" value="<?php echo $product->prod_valor_de_custo ?>">
							</div>
						</div>
						<div class="form-group">
							<?php echo lang('product_sell_value', 'sell_value', array('class' => 'col-sm-2 control-label')); ?>
							<div class="col-sm-10">
								<input type="text" id="sell_value" name="sell_value" class="form-control" value="<?php echo $product->prod_valor_de_venda ?>">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<?php echo form_hidden('id', $product->prod_id);?>
								<div class="btn-group">
									<?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => lang('actions_submit'))); ?>
									<?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning btn-flat', 'content' => lang('actions_reset'))); ?>
									<?php echo anchor('admin/product', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
								</div>
							</div>
						</div>
						<?php 
                        }
                        echo form_close();?>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>