        <!-- Modal -->
        <div class="modal fade" id="allWorkOrderModalCenter" tabindex="-1" role="dialog" aria-labelledby="allWorkOrderModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="allWorkOrderModalCenterTitle"> Total Work Orders</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="all-work-order">
                  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        
                    </div>
                </div>
            </div>
        </div>

<!-- bootstrap bundle js-->
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<!-- slimscroll js-->
<script src="<?php echo base_url(); ?>assets/vendor/slimscroll/jquery.slimscroll.js"></script>
<!-- chartjs js-->
<script src="<?php echo base_url(); ?>assets/vendor/charts/charts-bundle/Chart.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/charts/charts-bundle/chartjs.js"></script>


<!-- jvactormap js-->
<!-- <script src="<?php echo base_url(); ?>assets/vendor/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->
<!-- sparkline js-->
<!-- <script src="<?php echo base_url(); ?>assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/charts/sparkline/spark-js.js"></script> -->
<!-- dashboard sales js-->
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/js/validation.js"></script>
<!-- main js-->
<!-- <script src="<?php echo base_url(); ?>assets/libs/js/main-js.js"></script> -->
<!-- Optional JavaScript -->
<script src="<?php echo base_url(); ?>assets/js/main.js"></script>









<!-- show all the messages  -->
<?php
if ($this->session->flashdata('success')) {
?><script>
        showAlert("<?php echo $this->session->flashdata('success'); ?>", 'success');
    </script>
<?php
}
?>
<?php
if ($this->session->flashdata('error')) {
?>
    <script>
        showAlert("<?php echo $this->session->flashdata('error'); ?>", 'danger');
    </script>
<?php
}
?>



</body>

</html>