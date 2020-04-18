<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h3 class="mb-2">Dashboard</h3>
                </div>
            </div>
        </div>
        <div id="chart_div"></div>
        <div class="card mb-5 complete" style="display:none">
            <div class="card-header p-2">
                <h3 class="">Complete</h3>
            </div>
            <div class="card-body" id="client-card-body">
                <div id="totla-complete-order" class="clients">
                </div>
                <!-- <div id="donut"></div> -->
            </div>
        </div>
        <div class="card mb-5 under-process" style="display:none">
            <div class="card-header p-2">
                <h3 class="">Under process</h3>
            </div>
            <!-- <div class="card-body" id="client-card-body"> -->
            <div id="totla-underprocess-wo" class="clients">
            </div>
            <!-- </div> -->
        </div>
    </div>
</div>
<!-- google chart -->
<script src="<?php echo base_url(); ?>assets/js/chart.js"></script>
