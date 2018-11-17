<?php
/**
 * Created by PhpStorm.
 * User: andreyfilenko
 * Date: 2018-11-06
 * Time: 21:59
 */

namespace App\Services;

use Psr\Log\LoggerInterface;

class Greeting
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function greet(string $name): string
    {
        $this->logger->info("Greeted $name");
        return "Hello $name";
    }
}