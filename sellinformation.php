<?php
    $method = $_SERVER['REQUEST_METHOD'];
    require_once 'resource.php';

    if( strtolower( $method ) == 'get' ) {
        $invoiceno = $_GET['invoiceno'];

        start_session();
        load_header('Sell Information');
        load_navbar();
        load_printme();
        load_datatables();
    ?>
        <input type="hidden" id="invoiceno" value="<?php echo $invoiceno; ?>">
        <div class="col-md-12" align="left">
            <button class="btn btn-md btn-success" id="print"><i class="fa fa-fw fa-print"></i>&nbsp;Print</button>
        </div> <br> <br>
        <div class="col-md-12">
            <div class="panel panel-orange" id="printdata">
                <div class="panel-heading">
                    <h4 align="center">Sell Information</h4>
                </div>
                <div class="panel-body" id="loaddata"></div>
            </div>
        </div>
    <?php
        load_footer();
    } else {
        exit('No direct script access allowed here');
    }
?>

<script>
    $( document ).ready( function () {
        $('#loaddata').load("<?php echo base_url();?>database/report_db.php", {'action':'details', 'invoiceno':$('#invoiceno').val()}, function (d) {
            //
        });

        $('#print').click( function () {

            var date = new Date();

            var dd = date.getDate();
            var m = date.getMonth()+1;
            var yy = date.getFullYear();

            var hh = date.getHours();
            var mm = date.getMinutes();
            var ss = date.getSeconds();
            var ext = ( hh >= 12 ) ? 'PM' : 'AM';
            hh = ( hh > 12 ) ? hh-12 : hh;

            var nDate = dd+"-"+m+"-"+yy+" "+hh+":"+mm+":"+ss+ " " + ext;

            $('#hidedate').removeClass('hide').find('h5').text("Print Time: " + nDate);

            $('#printdata').printMe({
                "path": [
                    "<?php echo base_url(); ?>assets/css/bootstrap.min.css",
                    "<?php echo base_url(); ?>assets/css/style.css"
                ]
            });

            $('#hidedate').addClass('hide');
        });
    });
</script>
