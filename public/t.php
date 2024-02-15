<?php
if(isset($_GET['p']) && $_GET['p'] != "")
{
    header("location:https://maidendropgroup.com/public/receipt_files/{$_GET['p']}.pdf");
}
if(isset($_GET['rd']) && $_GET['rd'] != "")
{
    header("location:https://maidendropgroup.com/public/reservation_files/{$_GET['rd']}.pdf");
}