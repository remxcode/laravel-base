<?php

use Symfony\Component\Yaml\Yaml;

return Yaml::parse(file_get_contents(base_path('/resources/lang/zh_CN/validation.yml')));
