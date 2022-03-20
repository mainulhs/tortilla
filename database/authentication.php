<?php
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'tortilla';

    require_once 'connection.php';
    $db = new database( $server, $username, $password, $database );
    $connect = $db->connect();

    if( $connect ) {

        $method = $_SERVER['REQUEST_METHOD'];

        if( strtolower( $method ) == 'post' ) {
            $action = $_POST['action'];

            if( $action == 'login' ) {
                $username = $_POST['username'];
                $password = $_POST['password'];

                $loginqry = "SELECT * FROM tor_userinfo WHERE username='$username'";
                $execute_qry = $connect->query( $loginqry );
                if( $execute_qry->num_rows > 0 ) {

                    require_once "../cryptography/authentication.php";
                    $row = $execute_qry->fetch_array();
                    $db_password = $row['pword'];
//                    echo $db_password;

                    if( comparepassword( $password, $db_password ) == true ) {
                        if( strtolower( $row['status'] ) == 'active' ) {
                            session_start();
                            $_SESSION['id'] = $row['id'];
                            $_SESSION['displayname'] = $row['display_name'];
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['userrole'] = $row['userrole'];
                            $_SESSION['privilige'] = $row['privilege'];
                            echo '3';
                        } else {
                            echo '4';
                        }
                    } else {
                        echo '2';
                    }

                } else {
                    echo '1';
                }
            } //login

        } else {
            exit('No direct script access allowed here');
        }

    } else {
        echo mysqli_connect_error();
    }