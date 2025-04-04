<?php

namespace Glohm\ProcessoSeletivo\Routes;

use Glohm\ProcessoSeletivo\Controller\AlarmController;

class Alarm
{
    private $controller;

    public function __construct()
    {
        $this->controller = new AlarmController();
    }

    private function jsonResponse($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function fetchAlarm($params = [])
    {
        $data = $this->controller->fetchAlarm();
        $this->jsonResponse($data);
    }

    public function fetchAlarmById($params)
    {
        $data = $this->controller->fetchAlarmById($params);
        $this->jsonResponse($data);
    }

    public function insert($params)
    {
        $data = $this->controller->insert(params: $params);
        $this->jsonResponse($data, 201);
    }

    public function fetchActuatedAlarm()
    {
        $data = $this->controller->fetchActuatedAlarm();
        $this->jsonResponse($data, 201);
    }
    public function insertActuatedAlarm($params)
    {
        $data = $this->controller->insertActuatedAlarm(params: $params);
        $this->jsonResponse($data, 201);
    }

    public function delete($params)
    {
        $data = $this->controller->delete($params);
        $this->jsonResponse($data);
    }

    public function update($params)
    {
        $data = $this->controller->update($params);
        $this->jsonResponse($data);
    }
}
