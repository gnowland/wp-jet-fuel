<?php

namespace Gnowland\JetFuel;

class Instance
{
    use Utils;

    protected $config;

    /**
     * @param string|array $config
     */
    public function __construct($config)
    {
        $this->config = $this->toArray($config);
    }

    /**
     * Setup $config default values
     *
     * @param string|array $args
     */
    protected function setDefaultConfig($args)
    {
        if (!current($this->config)) {
            $this->config = $this->toArray($args);
        }
    }

}
