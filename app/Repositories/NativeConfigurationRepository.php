<?php

namespace App\Repositories;

use PhpCsFixer\Config;

class NativeConfigurationRepository
{
    public function __construct(private string $configPath)
    {
    }

    public function get(): Config
    {
        if (! file_exists($this->configPath)) {
            abort(1, $this->configPath." doesn't exist");
        }
        if (pathinfo($this->configPath, PATHINFO_EXTENSION) !== 'php') {
            abort(1, $this->configPath." isn't a php file");
        }
        $imported = require $this->configPath;
        if (! $imported instanceof Config) {
            abort(1, $this->configPath." doesn't return a valid Config object");
        }

        return $imported;
    }
}
