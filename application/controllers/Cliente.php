<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cliente extends CI_Controller
{
    private $request;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ClienteModelo');
        $this->load->model('VehiculoModelo');
        $this->request = json_decode(file_get_contents('php://input'));
    }

    /**
     * Listar todos los clientes registrados
     *
     */
    public function index()
    {
        $datos["clientes"] = $this->ClienteModelo->listar();
        echo json_encode($datos);
        exit();
    }

    /**
     * Registrar un nuevo cliente con un nuevo vehiculo
     *
     */
    public function store()
    {
        $validacion = true;

        //verificar si no existe el numero_documento
        $registro = $this->ClienteModelo->getNumeroDocumento($this->request->numero_documento);
        if (count($registro) > 0) {
            $validacion = false;
        }

        //verificar si no existe la placa
        $registro = $this->VehiculoModelo->getPlaca($this->request->placa);
        if (count($registro) > 0) {
            $validacion = false;
        }


        if ($validacion) {
            $id_cliente = $this->ClienteModelo->insertar(array(
                'numero_documento' => $this->request->numero_documento,
                'nombre' => $this->request->nombre,
                'apellidos' => $this->request->apellidos,
            ));

            $this->VehiculoModelo->insertar(array(
                'tipo' => $this->request->tipo,
                'placa' => $this->request->placa,
            ), $id_cliente);
        } else {
            $this->output->set_status_header(422);
        }
    }


    /**
     * Actualizar registro cliente
     *
     */
    public function update($id)
    {
        $validacion = true;

        //verificar si no existe el numero_documento
        $registro = $this->ClienteModelo->getNumeroDocumento($this->request->numero_documento);
        if (count($registro) > 0) {
            if ($id != $registro[0]->id) {
                $validacion = false;
            }
        }

        if ($validacion) {
            $this->ClienteModelo->actualizar(array(
                'id' => $id,
                'numero_documento' => $this->request->numero_documento,
                'nombre' => $this->request->nombre,
                'apellidos' => $this->request->apellidos,
            ));
        } else {
            $this->output->set_status_header(422);
        }
    }

    /**
     * Eliminar un cliente si no tiene vehiculos registrados
     *
     */
    public function destroy($id)
    {
        $validacion = true;

        //verificar si no existe el numero_documento
        $registro = $this->VehiculoModelo->listarIdCliente($id);

        if (count($registro) > 0) {
            $validacion = false;
        }
        if ($validacion) {
            $this->ClienteModelo->eliminar(array(
                'id' => $id
            ));
        } else {
            $this->output->set_status_header(422);
        }
    }
}
