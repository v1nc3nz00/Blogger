<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 15/10/2015
 * Time: 15:38
 */


error_reporting(E_ALL);
ini_set("display errors",1);
//require_once('tools/autoloader.php');
require_once('vendor/autoload.php');
$sitePrefix = '/Ex2/';

Authenticator::check();



Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twigConfig = array(
    'cache' => __DIR__.'/cache',
);
$twig = new Twig_Environment($loader, []);
$req = str_replace($sitePrefix, '', $_SERVER['REQUEST_URI']);
if($req==""){
    $req="home";
}

$req =  $req . '.twig';

$template = $twig->loadTemplate($req);


Registrator::check();
$data = Authenticator::getUserData();
$data += Registrator::getRegData();
$data += BlogPostReader::ReadPosts();
$data += ContactInfo::getInfo();
if (!Authenticator::isAuthenticated() and !Registrator::isRegistered()) {
    $data = array_merge($data, [
        'fullName' => 'Anonymous',
        'loginLink' => 'login',
        'loginLabel' => 'Login',
        "currentYear" => date("Y"),
    ]);
} elseif (!Authenticator::isAuthenticated() and Registrator::isRegistered()) {
    $data = array_merge($data, [
        'fullName' => 'Anonymous',
        'loginLink' => 'login',
        'loginLabel' => 'Login',
        "currentYear" => date("Y"),
    ]);
} else {
    $data = array_merge($data, [
        'loginLink' => 'logout',
        'loginLabel' => 'Logout',
        "currentYear" => date("Y"),
    ]);
}
$output = $template->render($data);
print $output;