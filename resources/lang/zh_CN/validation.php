<?php

use Symfony\Component\Yaml\Yaml;

return Yaml::parse(file_get_contents(resource_path('/lang/zh_CN/validation.yml')));
