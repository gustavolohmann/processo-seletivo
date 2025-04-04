<?php

namespace Glohm\ProcessoSeletivo\Routes;

use Glohm\ProcessoSeletivo\Controller\EquipmentController;

class Equipment
{
    private $controller;

    public function __construct()
    {
        $this->controller = new EquipmentController();
    }

    private function jsonResponse($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function fetchEquiment($params = [])
    {
        $data = $this->controller->fetchEquiment();
        $this->jsonResponse($data);
    }

    public function fetchEquimentById($params)
    {
        $data = $this->controller->fetchEquipmentById($params);
        $this->jsonResponse($data);
    }

    public function insert($params)
    {
        $data = $this->controller->insert($params);
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
