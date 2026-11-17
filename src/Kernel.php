<?php

declare(strict_types=1);

namespace App;

use Bref\SymfonyBridge\BrefKernel as BaseKernel;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;

class Kernel extends BaseKernel
{
  use MicroKernelTrait;
}
