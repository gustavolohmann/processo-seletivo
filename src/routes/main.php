<?php

namespace Glohm\ProcessoSeletivo\Routes;
use Glohm\ProcessoSeletivo\Routes\Alarm;
use Glohm\ProcessoSeletivo\Routes\Equipment;
class Main
{

    private function alarm(string $method, array $params = [])
    {
        $AlarmInstance = new Alarm();
        $AlarmInstance->$method($params);
    }

    private function equipment(string $method, array $params = [])
    {
        $EquipmentInstance = new Equipment();
        $EquipmentInstance->$method($params);
    }

    public static function route(string $route)
    {
        $parts = explode('/', trim($route, '/'));
        $classMethod = $parts[0] ?? null;
        $function = $parts[1] ?? null;

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
            case 'DELETE':
                $params = array_slice($parts, 2);
                break;
            case 'POST':
            case 'PUT':
                $inputJSON = file_get_contents("php://input");
                $params = json_decode($inputJSON, associative: true) ?? $_POST;

                break;
            default:
                http_response_code(405);
                echo json_encode(["error" => "Método HTTP não permitido"]);
                exit;
        }

        $instance = new Main();

        if ($classMethod && method_exists($instance, $classMethod)) {
            $instance->$classMethod($function, $params);
        } else {
            echo "Erro: Rota inválida.";
        }
    }
}