<?php
    require_once 'resource.php';
    start_session();
    load_header('Product List');
    load_navbar();
    load_datatables();
?>
    <div class="col-md-12">
        <div class="panel panel-orange">
            <div class="panel-heading">
                <h4>Product List</h4>
            </div>
            <div class="panel-body">
                <div id="loadproductlist"></div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Product Information</h4>
                </div>
                <div class="modal-body">
                    <form action="" onsubmit="return false" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="control-label col-md-3">Product Code *</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-code"></i></span>
                                    <input type="text" id="productcode" class="form-control" readonly>
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

                        <div class="form-group">
                            <label for="" class="control-label col-md-3">Status *</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-code-fork"></i></span>
                                    <select name="status" id="status" class="form-control">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="productid">
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12" align="center">
                        <button type="button" class="btn btn-purple" id="updatedata"><i class="fa fa-fw fa-save"></i>&nbsp;Update</button>
                        <button type="button" class="btn btn-red" data-dismiss="modal"><i class="fa fa-fw fa-times"></i>&nbsp;Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!--End of Modal-->

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
            </div>
            <div class="modal-body">
                <h5>Do you want to delete this product?</h5>
                <input type="hidden" id="productid">
            </div>
            <div class="modal-footer">
                <div class="col-md-12" align="center">
                    <button type="button" class="btn btn-success" id="deletedata"><i class="fa fa-fw fa-check"></i>&nbsp;Yes</button>
                    <button type="button" class="btn btn-red" data-dismiss="modal"><i class="fa fa-fw fa-times"></i>&nbsp;No</button>
                </div>
            </div>
        </div>
    </div>
</div> <!--End of Modal-->

    <div class="hide" id="loaddata"></div>

<?php
    load_footer();
?>
<script>
    $('#loadproductlist').load("<?php echo base_url();?>database/product_db.php", {'action':'list'}, function (d) {
        //alert(d);
    });

    function editProduct(id) {
        //alert(id);
        $('#loaddata').load("<?php echo base_url();?>database/product_db.php", {'action':'loadproductinfo', 'productcode':id}, function (response) {
//            console.log(response);
            var data = jQuery.parseJSON( response );
            $('#productcode').val( data[0].product_code );
            $('#productname').val( data[0].product_name );
            $('#unitprice').val( data[0].unit_price );
            $('#productid').val( data[0].id );
            $('#status').val( data[0].status );
        });
        $('#editModal').modal();
    }

    function deleteProduct(id) {
        $('#productid').val(id);
        $('#deleteModal').modal();
    }

    $( document ).ready( function() {
        $( '#updatedata' ).click( function() {
            var haserror = false;

            if( $('#productcode').val() == null || $.trim( $('#productcode').val() ) == '' ) {
                $('.productcode').removeClass('hide');
                haserror = true;
            } else {
                $('.productcode').addClass('hide');
            }

            if( $('#productname').val() == null || $.trim( $('#productname').val() ) == '' ) {
                $('.productname').removeClass('hide');
                haserror = true;
            } else {
                $('.productname').addClass('hide');
            }

            if( $('#unitprice').val() == null || $.trim( $('#unitprice').val() ) == '' ) {
                $('.unitprice').removeClass('hide');
                haserror = true;
            } else {
                $('.unitprice').addClass('hide');
            }

            if( haserror == true ) {
                return;
            } else {
                $('#loaddata').load("<?php echo base_url();?>database/product_db.php", {'action':'updateproductinfo', 'id':$('#productid').val(), 'productcode':$('#productcode').val(), 'productname':$('#productname').val(), 'unitprice':$('#unitprice').val(), 'status':$('#status').val() }, function(d) {
                    if( d == 'Product Information is updated' ) {
                        alert('Product Information is updated');
                        $('#editModal').modal('hide');
                        location.reload();
                    } else {
                        alert(d);
                    }
                });
            }
        }); //updatedata btn click

        $('#deletedata').click( function() {
            var productid = $('#productid').val();
            $('#loaddata').load("<?php echo base_url();?>database/product_db.php", {'action':'deleteproductinfo', 'productid':$('#productid').val(), 'productcode':$('#productcode').val(), 'productname':$('#productname').val(), 'unitprice':$('#unitprice').val(), 'status':$('#status').val() }, function(d) {
                if( d == '1' ) {
                    alert('Product information is removed');
                    location.reload();
                } else {
                    alert(d);
                }
            });
        }); //deleteDate btn click
    });
</script>
