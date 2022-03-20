<?php
    require_once 'resource.php';
    start_session();
    if( check_login() == '1' ) {
?>
        <script>
            location.href = "<?php echo base_url();?>";
        </script>
<?php
    } else {
        load_header('Home');
    }
?>

    <div class="alert alert-success hide" style="margin-top: 50px;">
        <h4>Login successful</h4>
    </div>

    <div class="alert alert-danger hide" style="margin-top: 50px;">
        <h4></h4>
    </div>

    <div class="container">
        <div class="col-md-8 col-md-offset-2 top-margin-150">
            <div class="panel panel-orange">
                <div class="panel-heading"><h4>Login</h4></div>
                <div class="panel-body">
                    <form action="" onsubmit="return false" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="" class="control-label col-md-3">Username</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
                                    <input type="text" id="username" class="form-control input-lg" placeholder="Username">
                                </div>
                                <strong class="hide username text-error">Invalid username</strong>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="control-label col-md-3">Password</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-key"></i></span>
                                    <input type="password" id="password" class="form-control input-lg" placeholder="Password">
                                </div>
                                <strong class="hide password text-error">Invalid password</strong>
                            </div>
                        </div>

                        <input type="hidden" id="checklogin">

                        <div class="col-md-12 col-sm-12 col-xs-12" align="center">
                            <button id='loginbtn' class="btn btn-lg btn-dark">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $(document).ready( function() {

                $('#username').val('').focus();
                $('#password').val('');

                $('#loginbtn').click( function() {
                    var haserror = false;

                    if( $('#username').val() == null || $.trim( $('#username').val() ) == '' ) {
                        $('.username').removeClass('hide');
                        haserror = true;
                    } else {
                        $('.username').addClass('hide');
                    }

                    if( $('#password').val() == null || $.trim( $('#password').val() ) == '' ) {
                        $('.password').removeClass('hide');
                        haserror = true;
                    } else {
                        $('.password').addClass('hide');
                    }

                    if( haserror == true ) {
                        return;
                    } else {

                        $('#loginbtn').prop('disabled', true);

                        $('#checklogin').load('<?php echo base_url(); ?>database/authentication.php', {'action':'login', 'username':$('#username').val(), 'password': $('#password').val() }, function(d) {
                            if( d == '1' ) {
                                if( d == '1' ) {
                                    $('.alert.alert-danger').removeClass('hide').find('h4').text("Invalid username and/or password");
                                    $('.alert.alert-danger').fadeTo(4000, 500).slideUp(500, function () {
                                        $('#loginbtn').prop('disabled', false);
                                    });
                                }
                            } else if( d == '2' ) {
                                $('.alert.alert-danger').removeClass('hide').find('h4').text("Invalid username and/or password");
                                $('.alert.alert-danger').fadeTo(4000, 500).slideUp(500, function () {
                                    $('#loginbtn').prop('disabled', false);
                                });
                            } else if( d == '3' ) {
                                alert('Login success');
                                location.href = "<?php echo base_url(); ?>";
                            } else if( d == '4' ) {
                                alert('Sorry! your id is inactive. Contact with admin');
                            } else if( d == '5' ) {
                                alert('sorry something goes wrong. check your network id');
                            } else {
                                alert(d);
                            }
                        });
                    }
                });
            });
        </script>
    </div>
<?php
load_footer();
