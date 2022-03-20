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

            if( strtolower( $action ) == 'dailysell' ) {
                $date = $_POST['date'];
                $load_sell_info = "SELECT * FROM tor_productsell_master WHERE invoice_date='$date'";
                $execute_sell_info_qry = $connect->query( $load_sell_info );

                if( $execute_sell_info_qry->num_rows == 0 ) {
            ?>
                    <div class="table-responsive col-md-12">
                        <h4 align="center">No data found</h4>
                    </div>
            <?php
                } else {
            ?>
                    <div class="table-responsive col-md-12">
                        <table class="table table-bordered table-striped" id="dailysell">
                            <thead>
                                <tr>
                                    <th>Invoice No.</th>
                                    <th>Invoice Date</th>
                                    <th>Invoice Day</th>
                                    <th>Total Cost</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while( $row = $execute_sell_info_qry->fetch_array() ) {
                                ?>
                                        <tr>
                                            <td> <?php echo $row['invoice_no']; ?> </td>
                                            <td> <?php echo $row['invoice_date']; ?> </td>
                                            <td> <?php echo $row['invoice_day']; ?> </td>
                                            <td> <?php echo $row['totalprice']; ?> </td>
                                            <td>
                                                <button class="btn btn-danger" onclick="redirectURL('<?php echo $row['invoice_no']; ?>')"><i class="fa fa-fw fa-desktop"></i>&nbsp;Details</button>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <script>
                        $('#dailysell').dataTable({
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
                }

            } /*dailysell*/ else if( strtolower( $action ) == 'details' ) {
                $invoiceno = $_POST['invoiceno'];

                $details_qry = "SELECT * FROM tor_productsell_details WHERE invoice_no='$invoiceno'";
                $execute_details_qry = $connect->query( $details_qry );
                if( $execute_details_qry->num_rows == 0 ) {
            ?>
                    <div class="table-responsive col-md-12">
                        <h4 align="center">No data found</h4>
                    </div>
            <?php
                } else {
            ?>
                    <div class="col-md-12 table-responsive">
                        <h4>Invoice No: <?php echo $invoiceno; ?></h4> <br>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $totalcost = 0;
                                    while( $row = $execute_details_qry->fetch_array() ) {
                                ?>
                                        <tr>
                                            <td> <?php echo $row['product_code']; ?> </td>
                                            <td> <?php echo $row['product_name']; ?> </td>
                                            <td> <?php echo $row['unit_price']; ?> </td>
                                            <td> <?php echo $row['quantity']; ?> </td>
                                            <td> <?php echo $row['total_price']; ?> </td>
                                        </tr>
                                <?php
                                        $totalcost += (int) $row['total_price'];
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Total</strong></td>
                                    <td><strong><?php echo $totalcost; ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div style="position: fixed; bottom: 5px;" class="hide" id="hidedate" align="right"><h5></h5></div>
                    </div>

                    <script>
                        /*$('#salesdetails').dataTable({
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
                        });*/
                    </script>
            <?php
                }

            } /*details*/ else if( strtolower( $action ) == 'overallsell' ) {
                $load_sell_info = "SELECT * FROM tor_productsell_master";
                $execute_sell_info_qry = $connect->query( $load_sell_info );

                if( $execute_sell_info_qry->num_rows == 0 ) {
                    ?>
                    <div class="table-responsive col-md-12">
                        <h4 align="center">No data found</h4>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="table-responsive col-md-12">
                        <table class="table table-bordered table-striped" id="overallsell">
                            <thead>
                            <tr>
                                <th>Invoice No.</th>
                                <th>Invoice Date</th>
                                <th>Invoice Day</th>
                                <th>Total Cost</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while( $row = $execute_sell_info_qry->fetch_array() ) {
                                ?>
                                <tr>
                                    <td> <?php echo $row['invoice_no']; ?> </td>
                                    <td> <?php echo $row['invoice_date']; ?> </td>
                                    <td> <?php echo $row['invoice_day']; ?> </td>
                                    <td> <?php echo $row['totalprice']; ?> </td>
                                    <td>
                                        <button class="btn btn-danger" onclick="redirectURL('<?php echo $row['invoice_no']; ?>')"><i class="fa fa-fw fa-desktop"></i>&nbsp;Details</button>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <script>
                        $('#overallsell').dataTable({
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
                }
            } /*overall sell*/
        } else {
            echo mysqli_connect_error();
        }
    } else {
        exit('No direct script access allowed here');
    }