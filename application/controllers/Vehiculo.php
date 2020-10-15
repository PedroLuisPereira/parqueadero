<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Vehiculo extends CI_Controller
{
    private $request;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ClienteModelo');
        $this->load->model('VehiculoModelo');
        $this->load->model('ParqueaderoModelo');
        $this->request = json_decode(file_get_contents('php://input'));
    }

    /**
     * Listar todos los vehiculos registrados
     *
     */
    public function index()
    {
        $datos["vehiculos"] = $this->VehiculoModelo->listar();
        echo json_encode($datos);
        exit();
    }

    /**
     * Listar todos los vehiculos registrados por id_cliente
     *
     */
    public function listarIdCliente($id_cliente)
    {
        $datos["vehiculos"] = $this->VehiculoModelo->listarIdCliente($id_cliente);
        echo json_encode($datos);
        exit();
    }

    /**
     * Listar vehiculo por placa
     *
     */
    public function listarPlaca($placa)
    {
        $vehiculos = $this->VehiculoModelo->listarPlaca($placa);

        //verificar si existe la placa
        if (count($vehiculos) > 0) {
            $tipo = $vehiculos[0]->tipo;
            $datos["parqueaderos"] = $this->ParqueaderoModelo->listarTipo($tipo);
            echo json_encode($datos);
            exit();
        }else{
            $datos["parqueaderos"] = array();
            echo json_encode($datos);
            exit();
        }
    }

    /**
     * Agregar un nuevo vehiculos 
     *
     */
    public function agregar()
    {

        $validacion = true;

        //verificar si no existe la placa
        $registro = $this->VehiculoModelo->getPlaca($this->request->placa);
        if (count($registro) > 0) {
            $validacion = false;
        }

        if ($validacion) {
            $this->VehiculoModelo->insertar(array(
                'tipo' => $this->request->tipo,
                'placa' => $this->request->placa,
            ), $this->request->id_cliente);
        } else {
            $this->output->set_status_header(422);
        }
    }


    /**
     * Actualizar vehiculos 
     *
     */
    public function update($id)
    {
        $validacion = true;

        //verificar si no existe la placa
        $registro = $this->VehiculoModelo->getPlaca($this->request->placa);
        if (count($registro) > 0) {
            if ($id != $registro[0]->id) {
                $validacion = false;
            }
        }

        if ($validacion) {
            $this->VehiculoModelo->actualizar(array(
                'id' => $id,
                'tipo' => $this->request->tipo,
                'placa' => $this->request->placa,
            ));
        } else {
            $this->output->set_status_header(422);
        }
    }


    /**
     * Eliminar vehiculos 
     *
     */
    public function destroy($id)
    {
        $this->VehiculoModelo->eliminar(array(
            'id' => $id
        ));
    }
}
