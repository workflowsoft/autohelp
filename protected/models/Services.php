<?php
/**
 * Created by PhpStorm.
 * User: shart
 * Date: 09.01.14
 * Time: 21:17
 */

class Services {

    function __construct() {
        $services = Service::model()->findAll();
        foreach($services as $service) {
            $id = 'service' . $service->id;
            $this->$id = $service;
        }
    }


} 