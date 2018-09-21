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


						<div class="form-group">
							<?php echo lang('ven_date', 'date', array('class' => 'col-sm-2 control-label')); ?>
							<div class="col-sm-6">
								<input type="date" class="form-control" name="date" required>
							</div>
						</div>


						<div class="form-group">
							<?php echo lang('search-product', 'titleP', array('class' => 'col-sm-2 control-label')); ?>
							<div class="col-sm-6">
								<?php echo form_input($titleP);?>
							</div>
							<div class="col-sm-2">
								<button id="btn-agregar" type="button" class="btn btn-success btn-flat btn-block">
									<span class="fa fa-plus"></span>
									Add</button>
							</div>
						</div>
						<div class="table-responsive">
							<table id="tbventas" class="table table-striped table-hover ">
								<thead>
									<tr>
										<th scope="col">Codigo</th>
										<th scope="col">Nome</th>

										<th scope="col">Tamanho</th>
										<th scope="col">Quantidade</th>
										<th scope="col">Cor</th>
										<th scope="col">Preço</th>
										<th scope="col">Total</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
						<div class="form-group">
							<div class="col-md-3">
								<div class="input-group">
									<span class="input-group-addon">Subtotal:</span>
									<input type="text" class="form-control" placeholder="0.00" name="subtotal" readonly="readonly">
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group">
									<span class="input-group-addon">Desconto:</span>
									<input type="text" class="form-control" placeholder="0.00" name="descuento" onkeyup="myFunction()">
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group">
									<span class="input-group-addon" name="total" id="total">Tipo de Pagamento:</span>
									<?php echo form_dropdown('tipoPagamento', $tipoPagamento, '', array('class' => 'form-control')); ?>
								</div>
							</div>
							<div class="col-md-3">
								<div class="input-group">
									<span class="input-group-addon" name="total" id="total">Total:</span>

									<?php echo form_input($total);?>
								</div>
							</div>
						</div>


						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<div class="btn-group">

									<?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => lang('actions_submit'))); ?>
									<?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning btn-flat', 'content' => lang('actions_reset'))); ?>
									<?php echo anchor('admin/sale', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
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