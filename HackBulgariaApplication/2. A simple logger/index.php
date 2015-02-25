<?php

include_once('lib.php');

$logger = new ConsoleLogger();
$logger->log(1, "My monkey!");
$logger->log(2, "Marilyn Manson");
$logger->log(3, "Sweet dreams.");

$logger = new FileLogger('index.log');
$logger->log(1, "My monkey!");
$logger->log(2, "Marilyn Manson");
$logger->log(3, "Sweet dreams.");

$logger = new HTTPLogger();
$logger->log(1, "My monkey!");
$logger->log(2, "Marilyn Manson");
$logger->log(3, "Sweet dreams.");
?>