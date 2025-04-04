<?php

namespace Glohm\ProcessoSeletivo\Controller;

use Glohm\ProcessoSeletivo\Model\AlarmModel;

class AlarmController
{
    private $model;

    public function __construct()
    {
        $this->model = new AlarmModel();
    }

    public function fetchAlarm()
    {
        return $this->model->fetchAlarm();
    }

    public function fetchAlarmById($id)
    {
        return $this->model->fetchAlarmById($id);
    }

    public function insert($params)
    {
        return $this->model->insert($params);
    }

    public function insertActuatedAlarm($params)
    {
        return $this->model->insertActuatedAlarm($params);

    }

    public function fetchActuatedAlarm()
    {
        return $this->model->fetchActuatedAlarm();

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
