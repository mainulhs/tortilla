<?php
    require_once 'resource.php';
    start_session();
    load_header('Add Product');
    load_navbar();
?>
    <div class="alert alert-success hide" style="margin-top: 50px;">
        <h4>Product information is added successfully.</h4>
    </div>

    <div class="alert alert-danger hide" style="margin-top: 50px;">
        <h4></h4>
    </div>

    <div class="container">
        <div class="col-md-8 col-md-offset-2 top-margin-100">
            <div class="panel panel-orange">
                <div class="panel-heading">
                    <h4>Add Product</h4>
                </div>
                <div class="panel-body">
                    <form action="" onsubmit="return false" class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="control-label col-md-3">Product Code *</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-code"></i></span>
                                    <input type="text" id="productcode" class="form-control" placeholder="Product Code">
                                </div>
                                <strong class="hide productcode text-error">Invalid product code</strong>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="control-label col-md-3">Product Name *</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-leaf"></i></span>
                                    <input type="text" id="productname" class="form-control" placeholder="Product Name">
                                </div>
                                <strong class="hide productname text-error">Invalid product name</strong>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="control-label col-md-3">Unit Price *</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-money"></i></span>
                                    <input type="number" step="0.001" min="0" id="unitprice" class="form-control" placeholder="0.000">
                                    <span class="input-group-addon">TK.</span>
                                </div>
                                <strong class="hide unitprice text-error">Invalid unit price</strong>
                            </div>
                        </div>

                        <input type="hidden" id="savedata">

                        <div class="col-md-12" align="center">
                            <button class="btn btn-red" id="saveproduct"><i class="fa fa-fw fa-save"></i>&nbsp;Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
    load_footer();
?>
<script>
    $( document ).ready( function () {

       $('#productcode').focus();

       $('#saveproduct').click( function () {
           var haserror = false;

           if( $('#productcode').val() == null || $.trim( $('#productcode').val() ) == '' ) {
               haserror = true;
               $('.productcode').removeClass('hide');
           } else {
               $('.productcode').addClass('hide');
           }

           if( $('#productname').val() == null || $.trim( $('#productname').val() ) == '' ) {
               haserror = true;
               $('.productname').removeClass('hide');
           } else {
               $('.productname').addClass('hide');
           }

           if( $('#unitprice').val() == null || $.trim( $('#unitprice').val() ) == '' || parseFloat( $.trim( $('#unitprice').val() ) ) <= 0 ) {
               haserror = true;
               $('.unitprice').removeClass('hide');
           } else {
               $('.unitprice').addClass('hide');
           }

           if( haserror == true ) {
               return;
           } else {
               $('#savedata').load("<?php echo base_url();?>database/product_db.php", { 'action':'save', 'productcode':$('#productcode').val(), 'productname':$('#productname').val(), 'unitprice': $('#unitprice').val() }, function (d) {
                   if( d == '1' ) {
                       $('.alert.alert-danger').removeClass('hide').find('h4').text('Product code is already used');
                       $('.alert.alert-danger').fadeTo(2000, 500).slideUp(500, function () { });
                   } else if( d == '2' ) {
                       $('.alert.alert-danger').removeClass('hide').find('h4').text('Sorry something goes wrong');
                       $('.alert.alert-danger').fadeTo(2000, 500).slideUp(500, function () { });
                   } else if( d == '3' ) {
                       $('.alert.alert-success').removeClass('hide').fadeTo(2000, 500).slideUp(500, function () {
                           <?php
                            if( hasprivilige('productlist') ) {
                           ?>
                                location.href="<?php echo base_url();?>productlist.php";
                           <?php
                            }
                           ?>
                       });
                   } else {
                       alert(d);
                   }
               });
           }
       });
    });
</script>
