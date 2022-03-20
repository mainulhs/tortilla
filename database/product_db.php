<?php
   $method = $_SERVER['REQUEST_METHOD'];
    if( strtolower( $method ) == 'post' ) {
        session_start();
        $server = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'tortilla';

        require_once 'connection.php';
        $db = new database( $server, $username, $password, $database );
        $connect = $db->connect();

        if( $connect ) {
            $action = $_POST['action'];
            if( strtolower( $action ) == 'save' ) {
                $productcode = $_POST['productcode'];
                $productname = $_POST['productname'];
                $unitprice = $_POST['unitprice'];

                $select_qry = "SELECT * FROM tor_productinfo WHERE product_code='$productcode'";
                $execute_select_qry = $connect->query( $select_qry );

                if( $execute_select_qry->num_rows > 0 ) {
                    echo '1';
                } else {
                    $createdby = $_SESSION['username'];

                    date_default_timezone_set("Asia/Dhaka");
                    $createdtime = date("Y-m-d h:i:s");

                    $insert_qry= "INSERT INTO tor_productinfo(product_code, product_name, selling_price, unit_price, status, created_by, created_date) VALUES('$productcode', '$productname', '$unitprice', '$unitprice', 'active', '$createdby', '$createdtime')";
                    $execute_insert_qry = $connect->query( $insert_qry );

                    if( !$execute_insert_qry ) {
                        echo '2';
                    } else {
                        echo '3';
                    }
                }
            } /*save*/ else if( strtolower( $action ) == 'list' ) {
                $selectlist = "SELECT * FROM tor_productinfo";
                $execute_selectlist = $connect->query( $selectlist );
            ?>
                <div class="col-md-12">
                    <table class="table table-bordered table-striped table-hover" id="productlist">
                        <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Unit Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            while ( $row = $execute_selectlist->fetch_array() ) {
                        ?>
                                <tr>
                                    <td> <?php echo $row['product_code']; ?> </td>
                                    <td> <?php echo $row['product_name']; ?> </td>
                                    <td> <?php echo $row['unit_price']; ?> </td>
                                    <td> <?php echo $row['status']; ?> </td>
                                    <td>
                                        <button class="btn btn-purple btn-xs" title="Edit" onclick="editProduct(<?php echo $row['product_code'] ?>)"><i class="fa fa-fw fa-edit"></i></button>
                                        <button class="btn btn-red btn-xs"  title="Delete" onclick="deleteProduct(<?php echo $row['id'] ?>)"><i class="fa fa-fw fa-trash-o"></i></button>
                                    </td>
                                </tr>
                        <?php
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    $('#productlist').dataTable({
                        "order": [
                            [0, 'asc']
                        ],
                        "lengthMenu": [
                            [5, 15, 20, -1],
                            [5, 15, 20, "All"] // change per page values here
                        ],
                        "pageLength": 5, // set the initial value,
                        "columnDefs": [{  // set default column settings
                            'orderable': true,
                            'targets': [0]
                        }, {
                            "searchable": true,
                            "targets": [2]
                        }]
                    });
                </script>
            <?php
            } /*list*/ else if( strtolower( $action ) == 'invoiceno' ) {
                $date = $_POST['date'];
                $maxid = "SELECT MAX(invoice_no) as invoice_no FROM tor_productsell_master WHERE invoice_date='$date'";
                $execute_maxid = $connect->query( $maxid );
                $row = $execute_maxid->fetch_array();

                $maxinvoice = $row['invoice_no'];
                if( $maxinvoice != null ) {
                    $date = date('Ymd');
                    $id = substr( $maxinvoice, 8, strlen( $maxinvoice ) );
                    $newId = $date . (int) ( $id ) + 1;
                    echo $newId;
                } else {
                    $curr_date = date('Ymd') . '1';
                    echo $curr_date;
                }

            } /*invoiceno*/ else if( strtolower( $action ) == 'loadproductcode' ) {
                $productcode_query = "SELECT product_code FROM tor_productinfo WHERE status='active'";
                $execute_productcode_query = $connect->query( $productcode_query );

                $arr = array(); $cnt = 0;

                while( $row = $execute_productcode_query->fetch_array() ) {
                    $cnt++;
                    $arr[] = $row;
                }

                if( $cnt == 0 ) {
                    echo 'error';
                } else {
                    echo json_encode( $arr );
                }

            } /*loadproductcode*/ else if( strtolower( $action ) == 'loadproductinfo' ) {

                $productcode = $_POST['productcode'];
                $productinfo_query = "SELECT * FROM tor_productinfo WHERE product_code='$productcode'";
                $execute_productinfo_query = $connect->query( $productinfo_query );
                $arr = array(); $cnt = 0;
                while( $row = $execute_productinfo_query->fetch_array() ) {
                    $cnt++;
                    $arr[] = $row;
                }

                if( $cnt == 0 ) {
                    echo 'error';
                } else {
                    echo json_encode( $arr );
                }

            } /*loadproductinfo*/ else if( strtolower( $action ) == 'savesell' ) {

                $invoiceno = $_POST['invoiceno'];
                $invoicedate = $_POST['invoicedate'];
                $productcode = explode( '##', $_POST['productcode'] );
                $productname = explode( '##', $_POST['productname'] );
                $unitprice = explode( '##', $_POST['unitprice'] );
                $quantity = explode( '##', $_POST['quantity'] );
                $totalprice = explode( '##', $_POST['totalprice'] );
                $totalcost = $_POST['totalcost'];

                $len = count( $productcode );

                $day = date('D');
                $pos = strrpos($day, 'day');
                if( $pos === false ) {
                    $day .= 'day';
                }

                $createdby = $_SESSION['username'];

                date_default_timezone_set("Asia/Dhaka");
                $createdtime = date("Y-m-d h:i:s");
                $invoice_date = date('Y-m-d');
                //master table
                $master_tbl_qry = "INSERT INTO tor_productsell_master(invoice_no, invoice_date, invoice_day, totalprice, created_by, created_date) VALUES('$invoiceno', '$invoice_date', '$day', '$totalcost', '$createdby', '$createdtime')";
                $execute_master_tbl_query = $connect->query( $master_tbl_qry );
                if( !$execute_master_tbl_query ) {
                    echo '1';
                } else {
                    $cntr = 0;
                    for( $i = 0; $i < $len; $i++ ) {
                        date_default_timezone_set("Asia/Dhaka");
                        $createdtime = date("Y-m-d h:i:s");

                        $insert_product_sell_info = "INSERT INTO tor_productsell_details(product_code, product_name, unit_price, quantity, total_price, invoice_no, created_by, created_time ) VALUES('$productcode[$i]', '$productname[$i]', '$unitprice[$i]', '$quantity[$i]', '$totalprice[$i]', '$invoiceno', '$createdby', '$createdtime')";
                        $execute_insert_qry = $connect->query( $insert_product_sell_info );

                        if( !$execute_insert_qry ) { }
                        else {
                            $cntr++;
                        }
                    }

                    echo 'Insert##'.$cntr;
                }

            } /*savesell*/ else if( strtolower( $action ) == 'updateproductinfo' ) {

                $modiefied_by = $_SESSION['username'];
                date_default_timezone_set("Asia/Dhaka");
                $modified_time = date('Y-m-d h:i:s');

                $productname = $_POST['productname'];
                $unitprice = $_POST['unitprice'];
                $status = $_POST['status'];
                $id = $_POST['id'];

                $build_qry = "UPDATE tor_productinfo SET product_name='$productname', unit_price='$unitprice', selling_price='$unitprice', status='$status', modified_by='$modiefied_by', modified_date='$modified_time' WHERE id='$id'";
                $execute_build_qry = $connect->query( $build_qry );

                if( !$execute_build_qry ) {
                    echo 'Sorry something goes wrong.';
                } else {
                    echo 'Product Information is updated';
                }
                //echo $build_qry;
            } /*updateproductinfo*/ else if( strtolower( $action ) == 'deleteproductinfo' ) {
                $productid = $_POST['productid'];
                $delete_qry = "DELETE FROM tor_productinfo WHERE id='$productid'";
                $execute_delete_qry = $connect->query( $delete_qry );

                if( !$execute_delete_qry ) {
                    echo 'Sorry something goes wrong';
                } else {
                    echo '1';
                }
            } /*deleteproductinfo*/
        } else {
            echo mysqli_connect_error();
        }

    } else {
        exit('No direct script access allowed here');
    }