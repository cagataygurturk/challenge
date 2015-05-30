<?php

/*
 * Copyright (C) 2015 cagatay
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Application\Factories;

/**
 * Description of PersonServiceFactory
 *
 * @author cagatay
 */
use Framework\ServiceManager\ServiceManagerInterface;
use Framework\ServiceManager\FactoryInterface;
use Application\Services\PersonService;
use Application\Services\PersonServiceInterface;
use Framework\Exception\InvalidArgumentException;

class PersonServiceFactory implements FactoryInterface {

    /**
     * Get an instance of PersonService
     *
     * @return PersonServiceInterface
     */
    public function getService(ServiceManagerInterface $sm) {
        $config = $sm->get('Configuration')->getConfig();


        if (!$config['data_reader']['adapter']) {
            throw new InvalidArgumentException('Set data adapter in config');
        }
        if (!class_exists($config['data_reader']['adapter'])) {
            throw new InvalidArgumentException('Selector adaptor not exists: ' . $config['data_reader']['adapter']);
        }


        $adapter = new $config['data_reader']['adapter']($config['data_reader']['adapter_config']);
        if (!$adapter instanceof \Application\DAL\DataLayerInterface) {
            throw new InvalidArgumentException('Selector adaptor should implement DataLayerInterface');
        }

        $service = new PersonService($adapter);
        return $service;
    }

}
