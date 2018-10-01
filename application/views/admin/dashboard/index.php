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
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-maroon">
						<i class="fa fa-barcode"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">Produtos</span>
						<span class="info-box-number">
							<?php echo $count_products; ?>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-green">
						<i class="fa fa-money"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">Vendas</span>
						<span class="info-box-number">
							<?php echo $count_sale; ?>
						</span>
					</div>
				</div>
			</div>




			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-aqua">
						<i class="fa fa-user"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">Users</span>
						<span class="info-box-number">
							<?php echo $count_users; ?>
						</span>
					</div>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Gráfico</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse">
								<i class="fa fa-minus"></i>
							</button>
						</div>

					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-6">
								<select name="year" id="year" class="form-control">
									<?php foreach($years as $year): ?>
									<option value="<?php echo $year->year; ?>">
										<?php echo $year->year; ?>
									</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div id="grafico">
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- row -->

		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Custo x Venda Por Mês</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse">
								<i class="fa fa-minus"></i>
							</button>
						</div>

					</div>
					<div class="box-body">
						<div class="row">
							<table class="table table-striped table-hover">
								<tbody>
									<?php foreach ($sales as $info):?>
									<tr>
										<th>
											Total da Venda
										</th>

										<td>
											<?php 
										setlocale(LC_MONETARY,"pt_BR.UTF-8");
										echo money_format("%n", $info->total); ?>
										</td>
										<th>
											Total do Custo
										</th>

										<td>
											<?php 
										setlocale(LC_MONETARY,"pt_BR.UTF-8");
										echo money_format("%n", $info->totalcusto); ?>
										</td>
										<th>
											Mês
										</th>
										<td>
											<?php echo htmlspecialchars($info->month, ENT_QUOTES, 'UTF-8'); ?>
										</td>
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- row -->
	</section>
</div>