<?php

namespace Glohm\ProcessoSeletivo\Controller;
use Glohm\ProcessoSeletivo\Model\EquipamentModel;

class EquipmentController
{
    private $model;

    public function __construct()
    {
        $this->model = new EquipamentModel();
    }

    public function fetchEquiment()
    {
        return $this->model->fetchEquiment();
    }

    public function fetchEquipmentById($id)
    {
        return $this->model->fetchEquipmentById($id);
    }

    public function insert($params)
    {
        return $this->model->insert($params);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }

    public function update($params)
    {
        return $this->model->update($params);
    }
}
