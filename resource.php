<?php
    function base_url() {
        return (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/';
    }

    function start_session() {
        if(session_id() == '' || !isset($_SESSION)) {
            // session isn't started
            session_start();
        }
    }

    function check_login() {
        $username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : '';
        $login = 0;
        if( $username == null || $username == '' || $username == '0' ){
            $login = 0;
        } else {
            $login = 1;
        }
        return $login;
    }

    function hasprivilige( $privilige ) {
        $sessionprivilige = $_SESSION['privilige'];
        $priviligelist = explode( '##', $sessionprivilige );
        $count = 0;

        for( $i = 0; $i < count( $priviligelist ); $i++ ) {
            if( $priviligelist[ $i ] == $privilige ) {
                $count++;
                break;
            }
        }

        if( $count > 0 ) {
            return '1';
        } else {
            return '0';
        }
    }

    function load_header( $title ) {
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title> <?php echo isset( $title ) ? $title : "Document"; ?> </title>

            <!-- Bootstrap -->
            <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
            <!--Font Awesome-->
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
            <!--Custom CSS-->
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">

            <!-- Fonts -->
<!--            <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>-->

            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->

            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        </head>
        <body>
<?php
    } //header

    function load_navbar() {
        $display_name = $_SESSION['displayname'];
?>
        <!--Top navbar :: start-->
        <div class="navbar">
            <nav class="navbar navbar-custom navbar-static-top">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    <a class="navbar-brand" href="<?php echo base_url(); ?>">Tortilla</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbar">

                        <ul class="nav navbar-nav navbar-left">
                            <?php if( hasprivilige('user') ) { ?>
                                <!--<li class="dropdown">
                                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" area-haspopup="true" aria-expanded="false">User Level <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li role="presentation"><a href="<?php /*echo base_url('route/userlevel');*/?>">New User Level</a></li>
                                        <li class="divider"></li>
                                        <li role="presentation"><a href="<?php /*echo base_url('route/userlevellist');*/?>">User Level List</a></li>
                                    </ul>
                                </li>
-->
                            <?php }

                            if( hasprivilige( 'product' ) == '1' ) {
                                ?>
                                <li class="dropdown">
                                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" area-haspopup="true" aria-expanded="false">Product <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <?php if( hasprivilige('addproduct') ) {
                                        ?>
                                            <li role="presentation"><a href="<?php echo base_url();?>addproduct.php">Add Product</a></li>
                                        <?php
                                        }
                                        if( hasprivilige('productlist') ) {
                                        ?>
                                            <li role="presentation"><a href="<?php echo base_url();?>productlist.php">Product List</a></li>
                                        <?php
                                        }?>
                                    </ul>
                                </li>
                                <?php
                            }

                            if( hasprivilige( 'sales' ) == '1' ) {
                                ?>
                                <li class="dropdown">
                                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" area-haspopup="true" aria-expanded="false">Product <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <?php if( hasprivilige('sellproduct') ) {
                                        ?>
                                            <li role="presentation"><a href="<?php echo base_url();?>sellproduct.php">Sell Product</a></li>
                                            <?php
                                        }?>
                                    </ul>
                                </li>
                                <?php
                            }

                            if( hasprivilige('report') == '1' ) {
                                ?>
                                <li class="dropdown">
                                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" area-haspopup="true" aria-expanded="false">Report <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <?php if( hasprivilige('dailysell') ) {
                                            ?>
                                            <li role="presentation"><a href="<?php echo base_url();?>dailysell.php">Daily Sell</a></li>
                                            <?php
                                        }?>

                                        <?php if( hasprivilige('overallsell') ) {
                                            ?>
                                            <li role="presentation"><a href="<?php echo base_url();?>overallsell.php">All Sell</a></li>
                                            <?php
                                        }?>
                                    </ul>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown" id="usermenu">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-fw fa-user"></i>&nbsp;<?php echo $display_name; ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <!--<li><a href="<?php /*echo base_url(); */?>changepassword.php"><i class="fa fa-fw fa-key"></i>&nbsp;Change Password</a></li>-->
                                    <li class="divider"></li>
                                    <li><a href="<?php echo base_url(); ?>logout.php"><i class="fa fa-fw fa-power-off"></i>&nbsp;Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </div> <!--Top navbar :: end -->
<?php
    } //navbar

    function load_footer() {
?>
        <div id="hidden" class="hide"></div>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        </body>
    </html>
<?php
    } //footer

    function load_datatables() {
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables/media/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
        <?php
    }

    function load_jquery_ui() {
?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.min.css">
        <script src="<?php base_url();?>assets/js/jquery-ui.min.js"></script>
<?php
    }

    function load_datepicker() {
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/calender/css/datepicker.css">
    <script src="<?php base_url();?>assets/calender/js/bootstrap-datepicker.js"></script>
<?php
}
    function load_printme() {
?>
        <script src="<?php echo base_url();?>assets/printme/jquery-printme.min.js"></script>
<?php
    }