<?php

namespace Gnowland\JetFuel;

class Instance
{
    use Utils;

    protected $config;

    /**
     * @param string|array $config
     */
    public function __construct($config, $option)
    {
        $this->config = $this->toArray($config);
        $this->option = $this->toArray($option);
    }

    /**
     * Setup $config default values
     *
     * @param string|array $args
     */
    protected function setDefaultConfig($args, $var = 'config')
    {
        if (!current($this->$var)) {
            $this->$var = $this->toArray($args);
        }
    }

}
