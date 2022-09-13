<?php
/*
 * *************************************************************************
 *  * Copyright 2006-2022 (C) Björn Schleyer, Schleyer-EDV - All rights reserved.
 *  *
 *  * Made in Gelsenkirchen with-&hearts; by Björn Schleyer
 *  *
 *  * @project     RED-Host Panel
 *  * @file        Helper.php
 *  * @author      BjörnSchleyer
 *  * @site        www.schleyer-edv.de
 *  * @date        16.8.2022
 *  * @time        23:9
 *
 */

$helper = new Helper();

class Helper extends Controller
{

    // protector
    public function protect($string)
    {
        $protect = htmlspecialchars(trim($string), ENT_HTML401);

        return $protect;
    }

    // xss fix
    public function xssFix($string)
    {
        $string = $this->protect($string);

        $string = str_replace('<', '', $string);
        $string = str_replace('>', '', $string);
        $string = str_replace('´', '', $string);
        $string = str_replace('[', '(', $string);
        $string = str_replace(']', ')', $string);
        //$string = str_replace('_','', $string);
        $string = str_replace("'", '', $string);

        return $string;
    }

    // nl2br2
    public function nl2br2($string)
    {
        $string = $this->xssFix($string);
        $string = str_replace(array('\r\n', '\r', '\n'), '<br />', $string);

        return $string;
    }

    public function formatDateEng($date)
    {
        $date = new DateTime($date, new DateTimeZone('Europe/Berlin'));
        return $date->format('Y-m-d H:i:s');
    }

    public function formatDate($date)
    {
        $date = new DateTime($date, new DateTimeZone('Europe/Berlin'));
        return $date->format('d.m.Y H:i:s');
    }

    public function formatDateNormal($date)
    {
        $date = new DateTime($date, new DateTimeZone('Europe/Berlin'));
        return $date->format('d.m.Y H:i');
    }

    public function formatDateLicense($date)
    {
        $date = new DateTime($date, new DateTimeZone('Europe/Berlin'));
        return $date->format('d.m.Y');
    }

    public function formatDateWithoutTime($date)
    {
        $date = new DateTime($date, new DateTimeZone('Europe/Berlin'));
        return $date->format('d.m.Y');
    }

    public function formatDateTimeOnly($date)
    {
        $date = new DateTime($date, new DateTimeZone('Europe/Berlin'));
        return $date->format('H:i');
    }

    public function formatLoginDate($date)
    {
        $date = new DateTime($date, new DateTimeZone('Europe/Berlin'));
        return $date->format('d.m.y H:i');
    }

    public function formatDateTicketMessage($date)
    {
        $date = new DateTime($date, new DateTimeZone('Europe/Berlin'));
        return $date->format('d.m.y - H:i');
    }

    public function generateRandomString($length = 10, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function getSetting($data)
    {
        $SQL = self::db()->prepare("SELECT * FROM `settings`");
        $SQL->execute();
        $response = $SQL->fetch(PDO::FETCH_ASSOC);

        return $response[$data];
    }

    public function human_filesize($bytes, $dec = 2)
    {
        $size = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$dec}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    public function isa_convert_bytes_to_specified($bytes, $to, $decimal_places = 1)
    {
        $formulas = array(
            'K' => number_format($bytes / 1024, $decimal_places),
            'M' => number_format($bytes / 1048576, $decimal_places),
            'G' => number_format($bytes / 1073741824, $decimal_places)
        );
        return isset($formulas[$to]) ? $formulas[$to] : 0;
    }
}