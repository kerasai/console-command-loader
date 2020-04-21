<?php

use Robo\Tasks;

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends Tasks {

  use \Kerasai\Robo\Phpcs\loadTasks;

  /**
   * Run the tests.
   */
  public function test() {
    $this->testPhpcs();
  }

  /**
   * PHPCS code style checks.
   */
  public function testPhpcs() {
    $this->taskPhpcs()->run();
  }

}
