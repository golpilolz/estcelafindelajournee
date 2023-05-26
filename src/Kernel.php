<?php

namespace App;

use Bref\SymfonyBridge\BrefKernel as BaseKernel;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Kernel extends BaseKernel
{
  use MicroKernelTrait;

  private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

  public function registerBundles(): iterable
  {
    $contents = require $this->getProjectDir() . '/config/bundles.php';
    foreach ($contents as $class => $envs) {
      if ($envs[$this->environment] ?? $envs['all'] ?? false) {
        yield new $class();
      }
    }
  }

  protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
  {
    $container->addResource(new FileResource($this->getProjectDir() . '/config/bundles.php'));
    $container->setParameter('container.dumper.inline_class_loader', true);
    $confDir = $this->getProjectDir() . '/config';

    $loader->load($confDir . '/{packages}/*' . self::CONFIG_EXTS, 'glob');
    $loader->load($confDir . '/{packages}/' . $this->environment . '/**/*' . self::CONFIG_EXTS, 'glob');
    $loader->load($confDir . '/{services}' . self::CONFIG_EXTS, 'glob');
    $loader->load($confDir . '/{services}_' . $this->environment . self::CONFIG_EXTS, 'glob');
  }

  public function getLogDir(): string
  {
    // When on the lambda only /tmp is writeable
    if (isset($_SERVER['LAMBDA_TASK_ROOT'])) {
      return '/tmp/log/';
    }

    return parent::getLogDir();
  }

  public function getCacheDir(): string
  {
    // When on the lambda only /tmp is writeable
    if (isset($_SERVER['LAMBDA_TASK_ROOT'])) {
      return '/tmp/cache/' . $this->environment;
    }

    return parent::getCacheDir();
  }
}
