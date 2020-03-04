<!-- Optional JavaScript -->
<script src="<?php echo base_url(); ?>assets/js/main.js"></script>
<!-- jquery 3.3.1 js-->
<!-- bootstrap bundle js-->
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<!-- slimscroll js-->
<script src="<?php echo base_url(); ?>assets/vendor/slimscroll/jquery.slimscroll.js"></script>
<!-- chartjs js-->
<script src="<?php echo base_url(); ?>assets/vendor/charts/charts-bundle/Chart.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/charts/charts-bundle/chartjs.js"></script>

<!-- main js-->
<script src="<?php echo base_url(); ?>assets/libs/js/main-js.js"></script>
<!-- jvactormap js-->
<script src="<?php echo base_url(); ?>assets/vendor/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- sparkline js-->
<script src="<?php echo base_url(); ?>assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/charts/sparkline/spark-js.js"></script>
<!-- dashboard sales js-->
<script src="<?php echo base_url(); ?>assets/libs/js/dashboard-sales.js"></script>

<!-- datepicker -->

<script src="<?php echo base_url(); ?>assets/vendor/datepicker/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datepicker/tempusdominus-bootstrap-4.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datepicker/datepicker.js"></script>

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