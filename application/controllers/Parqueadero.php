<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Parqueadero extends CI_Controller
{
    private $request;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ParqueaderoModelo');
        $this->load->model('VehiculoModelo');
        $this->load->model('TarifaModelo');
        $this->request = json_decode(file_get_contents('php://input'));
    }

    //consultar parqueadero dismonibles
    public function listar()
    {
        $datos["parqueaderos"] = $this->ParqueaderoModelo->listar();
        echo json_encode($datos);
        exit();
    }

    public function listarAutosMover()
    {
        $datos["parqueaderos"] = $this->ParqueaderoModelo->listarAutos();
        echo json_encode($datos);
        exit();
    }

    public function listarBicicletasMover()
    {
        $datos["parqueaderos"] = $this->ParqueaderoModelo->listarBicicletas();
        echo json_encode($datos);
        exit();
    }

    public function listarMotosMover()
    {
        $datos["parqueaderos"] = $this->ParqueaderoModelo->listarMotos();
        echo json_encode($datos);
        exit();
    }

    
    //zona de parqueo 
    public function listarAutos()
    {
        $datos["parqueaderos"] = $this->ParqueaderoModelo->listarAutos();
        $arrayDatos["parqueaderos"] = json_decode(json_encode($datos["parqueaderos"]), true);

        for ($i = 0; $i < count($arrayDatos["parqueaderos"]); $i++) {
            if ($arrayDatos["parqueaderos"][$i]['estado'] == "No disponible") {
                $placa = $arrayDatos['parqueaderos'][$i]['placa'];
                $cliente = $this->VehiculoModelo->listarCliente($placa);
                $cliente = json_decode(json_encode($cliente), true);
                $arrayDatos["parqueaderos"][$i]['cliente'] = $cliente;
            }
        }

        echo json_encode($arrayDatos);
        exit();
    }

    public function listarBicicletas()
    {
        $datos["parqueaderos"] = $this->ParqueaderoModelo->listarBicicletas();
        $arrayDatos["parqueaderos"] = json_decode(json_encode($datos["parqueaderos"]), true);

        for ($i = 0; $i < count($arrayDatos["parqueaderos"]); $i++) {
            if ($arrayDatos["parqueaderos"][$i]['estado'] == "No disponible") {
                $placa = $arrayDatos['parqueaderos'][$i]['placa'];
                $cliente = $this->VehiculoModelo->listarCliente($placa);
                $cliente = json_decode(json_encode($cliente), true);
                $arrayDatos["parqueaderos"][$i]['cliente'] = $cliente;
            }
        }

        echo json_encode($arrayDatos);
        exit();
    }

    public function listarMotos()
    {
        $datos["parqueaderos"] = $this->ParqueaderoModelo->listarMotos();
        $arrayDatos["parqueaderos"] = json_decode(json_encode($datos["parqueaderos"]), true);

        for ($i = 0; $i < count($arrayDatos["parqueaderos"]); $i++) {
            if ($arrayDatos["parqueaderos"][$i]['estado'] == "No disponible") {
                $placa = $arrayDatos['parqueaderos'][$i]['placa'];
                $cliente = $this->VehiculoModelo->listarCliente($placa);
                $cliente = json_decode(json_encode($cliente), true);
                $arrayDatos["parqueaderos"][$i]['cliente'] = $cliente;
            }
        }

        echo json_encode($arrayDatos);
        exit();
    }
}
