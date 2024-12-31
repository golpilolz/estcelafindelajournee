<?php

namespace App;

use Bref\SymfonyBridge\BrefKernel as BaseKernel;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;

class Kernel extends BaseKernel
{
  use MicroKernelTrait;

  #[\Override]
  public function getLogDir(): string
  {
    if (isset($_SERVER['LAMBDA_TASK_ROOT'])) {
      return '/tmp/log/';
    }

    return parent::getLogDir();
  }

  #[\Override]
  public function getCacheDir(): string
  {
    if (isset($_SERVER['LAMBDA_TASK_ROOT'])) {
      return '/tmp/cache/' . $this->environment;
    }

    return parent::getCacheDir();
  }
}
