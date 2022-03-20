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
                    <h4>Search Criteria</h4>
                </div>
                <div class="panel-body">
                    <form action="" onsubmit="return false" class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="control-label col-md-4">Date *</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>
                                    <input type="text" id="date" class="form-control">
                                </div>
                                <strong class="text-danger date hide">Invalid date</strong>
                            </div>
                        </div>

                        <div class="col-md-12" align="center">
                            <button id="searchbtn" class="btn btn-purple"><i class="fa fa-fw fa-search"></i>&nbsp;Search</button>
                        </div>
                        <input type="hidden" id="dataload">
                    </form>
                </div>
            </div>

            <div class="panel panel-orange hide" id="searchblock">
                <div class="panel-heading">
                    <h4>Search Result</h4>
                </div>
                <div class="panel-body" id="searchresult"></div>
            </div>
        </div>
    </div>
<?php
    load_footer();
?>

<script>
    $( document ).ready( function () {
        $('#date').datepicker({
            'orientation': 'left',
            'autoclose': 'true',
            'format': 'dd-mm-yyyy'
        }); //datepicker

        $('#searchbtn').click( function () {
            var haserror = false;

            if( $('#date').val() == null || $.trim( $('#date').val() ) == '' ) {
                haserror = true;
                $('.date').removeClass('hide');
            } else {
                $('.date').addClass('hide');
            }

            if( haserror == true ) {
                return;
            } else {

                $('#searchblock').removeClass('hide');

                var date = $('#date').val().split('-');
                var nDate = date[2] + "-" + date[1] + "-" + date[0];
                $('#searchresult').load("<?php echo base_url();?>database/report_db.php", {'action': 'dailysell', 'date':nDate}, function (d) {
                    //
                });
            }
        });
    });
    
    function redirectURL(invoiceno) {
//        alert(invoiceno);
        location.href = "<?php echo base_url();?>sellinformation.php?invoiceno="+invoiceno;
    }

</script>
