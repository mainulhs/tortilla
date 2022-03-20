<?php
    require_once 'resource.php';
    start_session();
    load_header('Sell Product');
    load_navbar();
    load_jquery_ui();
?>

<style>
    .ui-state-focus {
        background: darkblue !important;
        color: #ffffff !important;
        border: 0 !important;
    }
</style>

<div class="alert alert-danger hide" style="margin-top: 50px;">
    <h4></h4>
</div>

<div class="alert alert-success hide" style="margin-top: 50px;">
    <h4>Product sell info. is stored into database</h4>
</div>

    <div class="col-md-12">
        <div class="panel panel-orange">
            <div class="panel-heading">
                <h4>Sell Product</h4>
            </div>
            <div class="panel-body">
                <form action="" onsubmit="return false" class="form-horizontal">
                    <div class="form-group">
                        <label for="" class="control-label col-md-2">Invoice No.</label>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-fw fa-info"></i></span>
                                <input type="text" id="invoiceno" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="" class="control-label col-md-2">Date</label>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>
                                <input type="text" id="invoicedate" class="form-control" value="<?php echo date('d-m-Y'); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="loaddata">
                    <br>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="right"><strong>Total</strong></td>
                            <td id="grandtotalprice" align="right" style="font-weight: bold;">0</td>
                            <td></td>
                        </tr>
                        </tfoot>

                        <tbody>
                            <tr id="row0" class="rows">
                                <td>
                                    <input type="text" id="productcode0" name="productcode" onblur="loadProductInfo(0)" class="form-control productcode">
                                    <strong class="text-error hide" id="codeError0">Invalid product code</strong>
                                </td>
                                <td>
                                    <input type="text" id="productname0" name="productname" class="form-control productname" readonly>
                                </td>
                                <td>
                                    <input type="text" id="unitprice0" name="unitprice" class="form-control unitprice" readonly>
                                </td>
                                <td>
                                    <input type="text" id="quantity0" name="quantity" class="form-control quantity" onblur="calculateTotal(0)">
                                    <strong class="text-error hide" id="quantityError0">Invalid quantity</strong>
                                </td>
                                <td>
                                    <input type="text" id="totalprice0" name="totalprice" class="form-control totalprice" readonly>
                                </td>
                                <td>
                                    <a style="color: green; vertical-align: middle" href="javascript:void(0)" onclick="addRow()" title="Add More"><i class="fa fa-fw fa-plus fa-1x"></i></a>
                                    <a style="color: red;" href="javascript:void(0)" onclick="deleteRow(0)" title="Delete"><i class="fa fa-fw fa-times fa-1x"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-12" align="center">
                        <button class="btn btn-purple" id="savesell"><i class="fa fa-fw fa-save"></i>&nbsp;Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
    load_footer();
?>

<script>
    function loadInvoiceNo() {
        var date = $('#invoicedate').val();
        var kk = date.split("-");
        var nDate = kk[2] + "-" + kk[1] + "-" + kk[0];
        $('#loaddata').load("<?php echo base_url(); ?>database/product_db.php", {'action':'invoiceno','date':nDate}, function (d) {
            $('#invoiceno').val(d);
        });
    } //loadinvoiceno

    var index = 1; var data = [];

    function addRow() {
        var dd = index++;
        $('table').find('tbody > tr:last').after( rowContent( dd ) );

        $('.productcode').each( function () {
            $(this).autocomplete({
                'source':data
            });
        });
    }

    function rowContent( id ) {
        var td1 = "<td><input type='text' id='productcode"+id+"' name='productcode' onblur='loadProductInfo("+id+")' class='form-control productcode'>" +
                       "<strong class='text-error hide' id='codeError"+id+"'>Invalid product code</strong>"+
                  "</td>";
        var td2 = "<td><input type='text' id='productname"+id+"' name='productname' class='form-control productname' readonly></td>";
        var td3 = "<td><input type='text' id='unitprice"+id+"' name='unitprice' class='form-control unitprice' readonly></td>";
        var td4 = "<td><input type='text' id='quantity"+id+"' name='quantity' onblur='calculateTotal("+id+")' class='form-control quantity' onblur='calculateEverything("+id+")'>" +
                       "<strong class='text-error hide' id='quantityError"+id+"'>Invalid quantity</strong>" +
                  "</td>";
        var td5 = "<td><input type='text' id='totalprice"+id+"' name='totalprice' class='form-control totalprice' readonly></td>";
        var td6 = "<td>" +
                      "<a style='color: green;' href='javascript:void(0)' onclick='addRow()' title='Add More'><i class='fa fa-fw fa-plus fa-1x'></i></a>&nbsp;" +
                      "<a style='color: red;' href='javascript:void(0)' onclick='deleteRow("+id+")' title='Delete'><i class='fa fa-fw fa-times fa-1x'></i></a>" +
                  "</td>";
        var tr = "<tr id='row"+id+"' class='rows'>" + td1 + td2 + td3 + td4 + td5 + td6 + "</tr>";
        return tr;
    } //rowContent

    function deleteRow( id ) {
        var count = 0;

        $('.rows').each( function () {
            count++;
        }); //jQuery each

        if( count < 2 ) {
            alert('Minimum 1 row is required.');
        } else {
            $('#row'+id).remove();
        }
    } //deleteRow

    function calculateTotal(id) {
        var grandTotal = 0;
        var unitPrice = ( $.trim( $('#unitprice'+id).val() ) != '' ) ? parseFloat( $('#unitprice'+id).val() ) : 0;
        var quantity = 0;
        if( $('#quantity'+id).val() == null || $.trim( $('#quantity'+id).val() ) == '' ) {
            $('#quantity'+id).focus();
            $('#quantityError'+id).removeClass('hide');
        } else {
            $('#quantityError'+id).addClass('hide');
            quantity = parseFloat( $('#quantity'+id).val() );
            $('#totalprice'+id).val( unitPrice * quantity );
        }

        $('.totalprice').each( function () {
            if( $( this ).val() == null || $.trim( $( this ).val() ) == '' ) {
                grandTotal += 0;
            } else {
                grandTotal += parseFloat( $( this ).val() );
            }
        });

        $('#grandtotalprice').text(grandTotal);
    }

    function loadProductInfo(id) {
        var productcode = $('#productcode'+id).val();
        $('#loaddata').load("<?php echo base_url();?>database/product_db.php", {'action':'loadproductinfo', 'productcode':productcode}, function (d) {
            if( d == 'error' ) {
                $('#productcode'+id).focus();
                $('#codeError'+id).removeClass('hide');
            } else {
                $('#codeError'+id).addClass('hide');
                var response = jQuery.parseJSON(d);
                $('#productname'+id).val( response[0].product_name );
                $('#unitprice'+id).val( response[0].unit_price );
            }
        });
    }

    $( document ).ready( function () {

        $('#productcode0').focus();

        loadInvoiceNo();

        $('#loaddata').load("<?php echo base_url();?>database/product_db.php", {'action':'loadproductcode'}, function (response) {
            if( response == 'error' ) {
                //
            } else {
                var dd = jQuery.parseJSON( response );

                for( var ii in dd ) {
                    data.push( dd[ii].product_code );
                }
            }
        }); //load productcode

        $('.productcode').each( function () {
            $(this).autocomplete({
                'source':data
            });
        });

        $('#savesell').click( function () {
            var haserror = false; var counter = 0;

            //check empty product code
            $('.productcode').each( function () {

                var id = this.id;
                var name = this.name;
                var index = id.substr( name.length );

                if( $(this).val() == null || $.trim( $(this).val() ) == '' ) {
                    $('#codeError'+index).removeClass('hide');
                    counter++;
                } else {
                    $('#codeError'+index).addClass('hide');
                }
            }); //jQuery each

            //check empty quantity
            $('.quantity').each( function () {

                var id = this.id;
                var name = this.name;
                var index = id.substr( name.length );

                if( $(this).val() == null || $.trim( $(this).val() ) == '' ) {
                    $('#quantityError'+index).removeClass('hide');
                    counter++;
                } else {
                    $('#quantityError'+index).addClass('hide');
                }
            }); //jQuery each

            if( counter > 0 ) {
                haserror = true;
            }

            if( haserror == true ) {
                return;
            } else {
                $('#savesell').attr('disabled', true);
                var productcode = "", productname = "", unitprice = "", quantity = "", totalprice= "";
                var aa = 0, bb = 0, cc = 0, dd = 0, ee = 0, grandTotal = 0;

                $('.productcode').each( function () {
                    if( aa == 0 ) {
                        if( $(this).val() == null || $.trim( $(this).val() ) == '' ) {
                            productcode += "---";
                        } else {
                            productcode += $(this).val();
                        }
                        aa++;
                    } else {
                        if( $(this).val() == null || $.trim( $(this).val() ) == '' ) {
                            productcode += "##";
                            productcode += "---";
                        } else {
                            productcode += "##";
                            productcode += $(this).val();
                        }
                        aa++;
                    }
                }); //jQuery each :: productcode

                $('.productname').each( function () {
                    if( bb == 0 ) {
                        if( $(this).val() == null || $.trim( $(this).val() ) == '' ) {
                            productname += "---";
                        } else {
                            productname += $(this).val();
                        }
                        bb++;
                    } else {
                        if( $(this).val() == null || $.trim( $(this).val() ) == '' ) {
                            productname += "##";
                            productname += "---";
                        } else {
                            productname += "##";
                            productname += $(this).val();
                        }
                        bb++;
                    }
                }); //jQuery each :: productname

                $('.unitprice').each( function () {
                    if( cc == 0 ) {
                        if( $(this).val() == null || $.trim( $(this).val() ) == '' ) {
                            unitprice += "---";
                        } else {
                            unitprice += $(this).val();
                        }
                        cc++;
                    } else {
                        if( $(this).val() == null || $.trim( $(this).val() ) == '' ) {
                            unitprice += "##";
                            unitprice += "---";
                        } else {
                            unitprice += "##";
                            unitprice += $(this).val();
                        }
                        cc++;
                    }
                }); //jQuery each :: unitprice

                $('.quantity').each( function () {
                    if( dd == 0 ) {
                        if( $(this).val() == null || $.trim( $(this).val() ) == '' ) {
                            quantity += "---";
                        } else {
                            quantity += $(this).val();
                        }
                        dd++;
                    } else {
                        if( $(this).val() == null || $.trim( $(this).val() ) == '' ) {
                            quantity += "##";
                            quantity += "---";
                        } else {
                            quantity += "##";
                            quantity += $(this).val();
                        }
                        dd++;
                    }
                }); //jQuery each :: quantity

                $('.totalprice').each( function () {
                    if( ee == 0 ) {
                        if( $(this).val() == null || $.trim( $(this).val() ) == '' ) {
                            totalprice += "---";
                        } else {
                            totalprice += $(this).val();
                        }
                        ee++;
                    } else {
                        if( $(this).val() == null || $.trim( $(this).val() ) == '' ) {
                            totalprice += "##";
                            totalprice += "---";
                        } else {
                            totalprice += "##";
                            totalprice += $(this).val();
                        }
                        ee++;
                    }
                }); //jQuery each :: totalprice

                $('#loaddata').load("<?php echo base_url();?>database/product_db.php", { 'action':'savesell', 'invoiceno': $('#invoiceno').val(), 'invoicedate': $('#invoicedate').val(), 'productcode': productcode, 'productname': productname, 'unitprice': unitprice, 'quantity': quantity, 'totalprice': totalprice, 'totalcost': $('#grandtotalprice').text()}, function (d) {
                    if( d == '1' ) {
                        $('.alert.alert-danger').removeClass('hide').find('h4').text('Sorry something goes wrrong');
                        $('.alert.alert-danger').fadeTo(2000, 500).slideUp(500, function () {});
                    } else if( d.indexOf('Insert##') >= 0 ) {
                        $('.alert.alert-success').removeClass('hide').fadeTo(2000, 500).slideUp(500, function () {
                            location.reload();
                        });
                    } else {
                        $('.alert.alert-danger').removeClass('hide').find('h4').text(d);
                        $('.alert.alert-danger').fadeTo(2000, 500).slideUp(500, function () {});
                    }
                });
            }
        });
    });
</script>
