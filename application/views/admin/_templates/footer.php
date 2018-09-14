<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<footer class="main-footer">
	<div class="pull-right hidden-xs">
		<b>
			<?php echo lang('footer_version'); ?>
		</b> v1.0
	</div>
	<strong>
		<?php echo lang('footer_copyright'); ?>&copy; &nbsp 2018-
		<?php echo date('Y'); ?>
		<a href="https://www.facebook.com/saraah.sso" target="_blank">&nbsp Sara S. de Oliveira</a>
	</strong>
	</br>
	<?php echo lang('footer_all_rights_reserved'); ?>.
</footer>
</div>


<script src="<?php echo base_url($frameworks_dir . '/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url($plugins_dir . '/slimscroll/slimscroll.min.js'); ?>"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
<?php if ($mobile == TRUE): ?>
        <script src="<?php echo base_url($plugins_dir . '/fastclick/fastclick.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($admin_prefs['transition_page'] == TRUE): ?>
        <script src="<?php echo base_url($plugins_dir . '/animsition/animsition.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'users' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
        <script src="<?php echo base_url($plugins_dir . '/pwstrength/pwstrength.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'groups' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
        <script src="<?php echo base_url($plugins_dir . '/tinycolor/tinycolor.min.js'); ?>"></script>
        <script src="<?php echo base_url($plugins_dir . '/colorpickersliders/colorpickersliders.min.js'); ?>"></script>
<?php endif; ?>
        <script src="<?php echo base_url($frameworks_dir . '/adminlte/js/adminlte.min.js'); ?>"></script>
        <script src="<?php echo base_url($frameworks_dir . '/domprojects/js/dp.min.js'); ?>"></script>


<script type="text/javascript">
	$(document).ready(function() {
		$('#table_id').DataTable();
	});
	var save_method; //for save method string
	var table;

	function add_product() {
		save_method = 'add';
		$('#form')[0].reset(); // reset form on modals
		$('#modal_form').modal('show'); // show bootstrap modal
		//$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
	}

	function save() {
		var url;
		if (save_method == 'add') {
			url = "<?php echo current_url(),'add_product'?>";
		} else {
			url = "<?php echo current_url(),'stock_update'?>";
		}
		// ajax adding data to database
		$.ajax({
			url: url,
			type: "POST",
			data: $('#form').serialize(),
			dataType: "JSON",
			success: function(data) {
				//if success close modal and reload ajax table
				$('#modal_form').modal('hide');
				location.reload(); // for reload a page
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error adding / update data');
			}
		});
	}
</script>
    </body>
</html>