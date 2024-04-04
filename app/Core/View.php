<?php

namespace AplikasiKas\Core;

class View
{
    public static function setView(string $view, $data = [])
    {
        require "app/View/layout/header.php";
        require "app/View/$view.php";
        require "app/View/layout/footer.php";
    }
    public static function redirect(string $url)
    {
        header("Location: $url");
    }
    public static function redirectMsg(string $url, string $message, bool $error)
    {
        if ($error) {
            header("Location: $url?error=$message");
            exit();
        } else {
            header("Location: $url?success=$message");
            exit();
        }
    }
}