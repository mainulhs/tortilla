<?php
    if( !session_start() ) {
        session_start();
    }
    require_once 'resource.php';
    $_SESSION['id'] = '';
    $_SESSION['displayname'] = '';
    $_SESSION['username'] = '';
    $_SESSION['userrole'] = '';
    session_unset();
    session_destroy();
?>

<script>
    location.href = "<?php echo base_url(); ?>";
</script>