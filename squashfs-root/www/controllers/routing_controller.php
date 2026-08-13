<?php

class Routing_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(ROUTING . DS . ROUTING);
        $this->Load_Model(ROUTING);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();

        if (isset($_POST[REBOOT_BUTTON])) {
            $this->reboot();
            header(LOCATION . REBOOT_PAGE . DS . ROUTING);
        }
    }

    public function addContent() {
        $routing = EMPTY_STRING;
        $routing_view = new View();

        $this->assignRebootRequireView($routing_view);
        $routing_view->Assign(ALL_ACTIVE_ROUTES_INFO, $this->getAllActiveRoutesInfo());
        $routing_view->Assign(STATIC_ROUTES_INFO, $this->getStaticRountsInfo());
        $routing_view->Assign(ADD_INTERFACE_OPTIONS, $this->getInterfaceOptions());

        $routing .= $routing_view->Render(ROUTING . DS . INFO, FALSE);
        $this->Assign(ROUTING, $routing);
    }

    public function getAllActiveRoutesInfo() {
        $allActiveRoutesInfo = array();

        if (count($this->getAllActiveRoutesArray()) > 0) {
            foreach ($this->getAllActiveRoutesArray() as $key => $routesInfo) {

                $allActiveRoutesInfo[$key] = array(
                    DESTINATION_IP => $this->getDestinationIP($routesInfo),
                    NET_MASK => $this->getSubnetMask($routesInfo),
                    GATE_WAY => $this->getGateway($routesInfo),
                    METRIC => $this->getMetric($routesInfo),
                    NAME_INTERFACE => $this->getInterface($routesInfo)
                );
            }
        }

        return $allActiveRoutesInfo;
    }

    public function getAllActiveRoutesArray() {
        return $this->model->getAllActiveRoutesArray();
    }

    public function getDestinationIP($routesInfo) {
        return strpos($routesInfo, DS) !== FALSE ? substr($routesInfo, 0, strpos($routesInfo, DS)) : DESTINATION_IP_DEFAULT;
    }

    public function getSubnetMask($routesInfo) {
        return strpos($routesInfo, DS) !== FALSE ? $this->translateSubnetMaskVal(explode(SPACE, substr($routesInfo, strpos($routesInfo, DS) + 1))[0]) : SUBNET_MASK_DEFAULT;
    }

    public function translateSubnetMaskVal($subnetMaskVal) {
        $subnetMaskArray = array(
            SUBNET_MASK_128_0_0_0_CODE => SUBNET_MASK_128_0_0_0_VAL,
            SUBNET_MASK_192_0_0_0_CODE => SUBNET_MASK_192_0_0_0_VAL,
            SUBNET_MASK_224_0_0_0_CODE => SUBNET_MASK_224_0_0_0_VAL,
            SUBNET_MASK_240_0_0_0_CODE => SUBNET_MASK_240_0_0_0_VAL,
            SUBNET_MASK_248_0_0_0_CODE => SUBNET_MASK_248_0_0_0_VAL,
            SUBNET_MASK_252_0_0_0_CODE => SUBNET_MASK_252_0_0_0_VAL,
            SUBNET_MASK_254_0_0_0_CODE => SUBNET_MASK_254_0_0_0_VAL,
            SUBNET_MASK_255_0_0_0_CODE => SUBNET_MASK_255_0_0_0_VAL,
            SUBNET_MASK_255_128_0_0_CODE => SUBNET_MASK_255_128_0_0_VAL,
            SUBNET_MASK_255_192_0_0_CODE => SUBNET_MASK_255_192_0_0_VAL,
            SUBNET_MASK_255_224_0_0_CODE => SUBNET_MASK_255_224_0_0_VAL,
            SUBNET_MASK_255_240_0_0_CODE => SUBNET_MASK_255_240_0_0_VAL,
            SUBNET_MASK_255_248_0_0_CODE => SUBNET_MASK_255_248_0_0_VAL,
            SUBNET_MASK_255_252_0_0_CODE => SUBNET_MASK_255_252_0_0_VAL,
            SUBNET_MASK_255_254_0_0_CODE => SUBNET_MASK_255_254_0_0_VAL,
            SUBNET_MASK_255_255_0_0_CODE => SUBNET_MASK_255_255_0_0_VAL,
            SUBNET_MASK_255_255_128_0_CODE => SUBNET_MASK_255_255_128_0_VAL,
            SUBNET_MASK_255_255_192_0_CODE => SUBNET_MASK_255_255_192_0_VAL,
            SUBNET_MASK_255_255_224_0_CODE => SUBNET_MASK_255_255_224_0_VAL,
            SUBNET_MASK_255_255_240_0_CODE => SUBNET_MASK_255_255_240_0_VAL,
            SUBNET_MASK_255_255_248_0_CODE => SUBNET_MASK_255_255_248_0_VAL,
            SUBNET_MASK_255_255_252_0_CODE => SUBNET_MASK_255_255_252_0_VAL,
            SUBNET_MASK_255_255_254_0_CODE => SUBNET_MASK_255_255_254_0_VAL,
            SUBNET_MASK_255_255_255_0_CODE => SUBNET_MASK_255_255_255_0_VAL,
            SUBNET_MASK_255_255_255_128_CODE => SUBNET_MASK_255_255_255_128_CODE,
            SUBNET_MASK_255_255_255_192_CODE => SUBNET_MASK_255_255_255_192_VAL,
            SUBNET_MASK_255_255_255_224_CODE => SUBNET_MASK_255_255_255_224_VAL,
            SUBNET_MASK_255_255_255_240_CODE => SUBNET_MASK_255_255_255_240_VAL,
            SUBNET_MASK_255_255_255_248_CODE => SUBNET_MASK_255_255_255_248_VAL,
            SUBNET_MASK_255_255_255_252_CODE => SUBNET_MASK_255_255_255_252_VAL,
            SUBNET_MASK_255_255_255_254_CODE => SUBNET_MASK_255_255_255_254_VAL,
            SUBNET_MASK_255_255_255_255_CODE => SUBNET_MASK_255_255_255_255_VAL
        );

        return $subnetMaskArray[$subnetMaskVal];
    }

    public function getGateway($routesInfo) {
        return strpos($routesInfo, VIA) !== FALSE ? explode(SPACE, substr($routesInfo, strpos($routesInfo, VIA) + 4))[0] : GATEWAY_DEFAULT;
    }

    public function getMetric($routesInfo) {
        return strpos($routesInfo, METRIC) !== FALSE ? explode(SPACE, substr($routesInfo, strpos($routesInfo, METRIC) + 7))[0] : METRIC_DEFAULT;
    }

    public function getInterface($routesInfo) {
        return $this->translateInterfaceName(explode(SPACE, substr($routesInfo, strpos($routesInfo, DEV) + 4))[0]);
    }

    public function translateInterfaceName($interfaceNameVal) {
        $interfaceNameArray = $this->getInterfaceNameArray();
        $interfaceName = EMPTY_STRING;

        if ($interfaceNameVal == INTERFACE_BR_LAN) {
            $interfaceName = INTERFACE_LAN_VAL;
        } else {
            foreach ($interfaceNameArray as $interfaceInfo) {
                if (strstr($interfaceInfo, $interfaceNameVal) !== FALSE) {
                    $interfaceName = strtoupper(explode(UCI_FIELD_DOT, $interfaceInfo)[0]);
                }
            }
        }
        return $interfaceName;
    }

    public function getInterfaceNameArray() {
        return $this->model->getInterfaceNameArray();
    }

    public function getStaticRountsInfo() {
        $staticRountsArray = array();
        $index = 0;

        while ($this->getLuxulRoute($index)) {
            $staticRountsArray[$index] = array(
                DESCRIPTION => $this->getStaticRouteDescription($index),
                NAME_INTERFACE => $this->getStaticRouteInterface($index),
                DESTINATION_IP => $this->getStaticRouteDestinationIP($index),
                NET_MASK => $this->getStaticRouteNetmask($index),
                GATE_WAY => $this->getStaticRouteGateway($index),
                METRIC => $this->getStaticRouteMetric($index)
            );

            $index++;
        }
        return $staticRountsArray;
    }

    public function getLuxulRoute($index) {
        return $this->model->getLuxulRoute(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getStaticRouteDescription($index) {
        return $this->model->getStaticRouteDescription(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getStaticRouteInterface($index) {
        return $this->model->getStaticRouteInterface(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getStaticRouteDestinationIP($index) {
        return $this->model->getStaticRouteDestinationIP(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getStaticRouteNetmask($index) {
        return $this->model->getStaticRouteNetmask(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getStaticRouteGateway($index) {
        return $this->model->getStaticRouteGateway(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getStaticRouteMetric($index) {
        return $this->model->getStaticRouteMetric(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getInterfaceOptions() {
        $interfaceNameArray = $this->getInterfaceNameArray();
        foreach ($interfaceNameArray as $interfaceInfo) {
            $options[explode(UCI_FIELD_DOT, $interfaceInfo)[0]] = strtoupper(explode(UCI_FIELD_DOT, $interfaceInfo)[0]);
        }

        return $this->helper->selectOption($options, INTERFACE_LAN_KEY);
    }

    public function save($tableData) {
        $this->deleteStaticRoutesInfo();

        $staticRoutesArray = explode(URL_POST_SEPERATOR, rawurldecode($tableData));

        foreach ($staticRoutesArray as $key => $staticRouteInfo) {
            if ($staticRouteInfo != EMPTY_STRING) {
                $staticRouteInfoArray = explode(COMMA, $staticRouteInfo);

                $this->addStaticRoute();
                $this->saveStaticRouteDescription(urldecode($staticRouteInfoArray[1]));
                $this->saveStaticRouteInterface($staticRouteInfoArray[2]);
                $this->saveStaticRouteDestinationIP($staticRouteInfoArray[3]);
                $this->saveStaticRouteNetmask($staticRouteInfoArray[4]);
                $this->saveStaticRouteGateway($staticRouteInfoArray[5]);
                $this->saveStaticRouteMetric($staticRouteInfoArray[6]);
            }
        }

        $this->commit();
        $this->saveRebootRequired();

        header(LOCATION . ROUTING_PAGE);
    }

    public function delete($index) {
        $this->deleteLuxulRoute($index);
        $this->deleteNetworkRoute($index);

        $this->commit();
        $this->saveRebootRequired();

        header(LOCATION . ROUTING_PAGE);
    }

    public function deleteStaticRoutesInfo() {
        $luxulRouteArray = $this->getStaticRountsInfo();

        if (count($luxulRouteArray) > 0) {
            for ($i=count($luxulRouteArray) -1; $i>=0; $i--) {
                $this->deleteLuxulRoute($i);
                $this->deleteNetworkRoute($i);
            }
        }
    }

    public function deleteLuxulRoute($index) {
        $this->model->deleteLuxulRoute(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function deleteNetworkRoute($index) {
        $this->model->deleteNetworkRoute(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function addStaticRoute() {
        $this->addLuxulRoute();
        $this->addNetworkRoute();
    }

    public function addLuxulRoute() {
        $this->model->addLuxulRoute();
    }

    public function addNetworkRoute() {
        $this->model->addNetworkRoute();
    }

    public function saveStaticRouteDescription($description) {
        $this->model->setStaticRouteDescription($description);
    }

    public function saveStaticRouteInterface($interface) {
        $this->model->setStaticRouteInterface($interface);
    }

    public function saveStaticRouteDestinationIP($destinationIP) {
        $this->model->setStaticRouteDestinationIP($destinationIP);
    }

    public function saveStaticRouteNetmask($netmask) {
        $this->model->setStaticRouteNetmask($netmask);
    }

    public function saveStaticRouteGateway($gateway) {
        $this->model->setStaticRouteGateway($gateway);
    }

    public function saveStaticRouteMetric($metric) {
        $this->model->setStaticRouteMetric($metric);
    }

}