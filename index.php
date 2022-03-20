<?php
    require_once 'resource.php';
    start_session();
    load_header('Home');
    if( check_login() == '1' ) {
        load_navbar();
        load_footer();
    } else {
        ?>
        <script>
            location.href = "<?php echo base_url();?>login.php";
        </script>
        <?php
    }