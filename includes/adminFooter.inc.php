<footer class="main-footer no-print <?php
  
  $theme = new Theme();
  echo $theme->loadSmallFooterText();

?>">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> <?= VERSION ?>
  </div>
  <strong>Copyright &copy; <?= COPYRIGHTYEAR ?> <a href="javascript:void(0)"><?= SYSTEM ?></a>.</strong> All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Overall BS Modal -->
<div class="modal fade" id="modal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="modalDetails"></div>
			</div>
		</div>
	</div>
</div>


<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/plugins/datatables/datatables.min.js"></script>
<script src="../assets/plugins/select2/js/select2.full.min.js"></script>
<script src="../assets/plugins/chart.js/Chart.min.js"></script>
<script src="../assets/plugins/chart.js/Chart.min.js"></script>
<script src="../assets/plugins/summernote/summernote-bs4.min.js"></script>
<script src="../assets/plugins/dropzone/dropzone-min.js"></script>
<script src="../assets/plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../assets/js/demo.js"></script>
</body>
</html>