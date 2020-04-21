<?php

namespace Kerasai\ConsoleCommandLoader;

use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\DependencyInjection\TaggedContainerInterface;

/**
 * Class TaggedCommandLoader.
 */
class TaggedCommandLoader implements CommandLoaderInterface {

  /**
   * Command names mapped to service IDs.
   *
   * @var array
   */
  protected $commandMap;

  /**
   * The service container.
   *
   * @var \Symfony\Component\DependencyInjection\TaggedContainerInterface
   */
  protected $container;

  /**
   * CommandLoader constructor.
   *
   * @param \Symfony\Component\DependencyInjection\TaggedContainerInterface $container
   *   The service container.
   */
  public function __construct(TaggedContainerInterface $container) {
    $this->container = $container;
    $this->commandMap = $this->initCommands($container);
  }

  /**
   * {@inheritdoc}
   */
  public function get($name) {
    return $this->container->get($this->commandMap[$name]);
  }

  /**
   * {@inheritdoc}
   */
  public function has($name) {
    return array_key_exists($name, $this->commandMap);
  }

  /**
   * {@inheritdoc}
   */
  public function getNames() {
    return array_keys($this->commandMap);
  }

  /**
   * Initializes command data.
   *
   * @param \Symfony\Component\DependencyInjection\TaggedContainerInterface $container
   *   The service container.
   *
   * @return array
   *   The command names mapped to corresponding service IDs.
   *
   * @throws \Exception
   */
  protected function initCommands(TaggedContainerInterface $container) {
    $commandMap = [];
    foreach ($container->findTaggedServiceIds('console.command') as $serviceId => $serviceTags) {
      foreach ($serviceTags as $tag) {
        if (empty($tag['command'])) {
          throw new \Exception(sprintf('Service "%s" tagged as "console.command" with no "command" set.'));
        }
        $commandMap[$tag['command']] = $serviceId;
      }
    }
    return $commandMap;
  }

}
