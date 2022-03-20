<?php
    require_once 'resource.php';
    start_session();
    load_header('Daily Sell');
    load_navbar();
    load_datepicker();
    load_datatables();
?>
    <div class="container">
        <div class="col-md-12">
            <div class="panel panel-orange">
                <div class="panel-heading">
                    <h4>Sell Information</h4>
                </div>
                <div class="panel-body" id="searchresult"></div>
            </div>
        </div>
    </div>
<?php
    load_footer();
?>

<script>
    $(document).ready( function () {
        $('#searchresult').load("<?php echo base_url();?>database/report_db.php", {'action': 'overallsell'}, function (d) {
            //
        });
    });

    function redirectURL(invoiceno) {
        location.href = "<?php echo base_url();?>sellinformation.php?invoiceno="+invoiceno;
    }
</script>
