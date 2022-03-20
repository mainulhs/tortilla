<?php

    /*Author: Shimul*/

    function encryption($password)
    {
        $data = $password;
        $options = [
            'cost' => 10,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];

        $hash = "";
        if (version_compare(PHP_VERSION, '7.0', '>=')) {
            $hash = password_hash($data, PASSWORD_BCRYPT);
        } else {
            $hash = password_hash($data, PASSWORD_BCRYPT, $options); //option is not required from PHP 7.0
        }

        return $hash;
    }

    function comparepassword($password, $base) //db password is base password.
    {
        if (password_verify($password, $base))
        {
            return true;
        }
        else
        {
            return true;
        }
    }