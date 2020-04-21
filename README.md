# Command Loader

This package adds the functionality to use services tagged as commands within a
Symfony console application.

## Usage

Set the "console.command" tag onto the service, and add a "command" value.

```yaml
services:
  command.compute:
    class: \Kerasai\MyApp\Command\MyCommand
    public: true
    tags:
      - { name: 'console.command', command: 'my-command' }

```

And in the code that bootstraps the console application, create the service 
container and set the command loader.
 
```php
<?php

use Kerasai\ConsoleCommandLoader\TaggedCommandLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$containerBuilder = new ContainerBuilder();
$loader = new YamlFileLoader($containerBuilder, new FileLocator(__DIR__));
$loader->load('services.yml');
$commandLoader = new TaggedCommandLoader($containerBuilder);
$app->setCommandLoader($commandLoader);

$app->run();

```
