        <!-- Modal -->
        <!-- <div class="modal fade" id="allWorkOrderModalCenter" tabindex="-1" role="dialog" aria-labelledby="allWorkOrderModalCenterTitle" aria-hidden="true">
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
        </div> -->



        <!-- modal for show all the selected subprocess and their sub process -->
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id=""> Selected Process and Sub-process</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Process</th>
                                        <th>Sub-process</th>
                                    </tr>
                                </thead>
                                <tbody id="selected-subprocess">
                                    
                                </tbody>
                            </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success submit-services" data-dismiss="modal">Save</button>
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

        <!-- bootstrap bundle js-->
        <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
        <!-- slimscroll js-->
        <script src="<?php echo base_url(); ?>assets/vendor/slimscroll/jquery.slimscroll.js"></script>
        <!-- chartjs js-->
        <script src="<?php echo base_url(); ?>assets/vendor/charts/charts-bundle/Chart.bundle.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/charts/charts-bundle/chartjs.js"></script>

        <!-- dashboard sales js-->
        <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap4.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/validation.js"></script>
        <!-- main js-->
        <!-- Optional JavaScript -->

        <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/potesting.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


        </body>

        </html>