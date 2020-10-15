<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tarifa extends CI_Controller
{
    private $request;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('TarifaModelo');
        $this->request = json_decode(file_get_contents('php://input'));
    }


     /**
     * Listar todos las tarifas
     *
     */
    public function index()
    {
        $datos["tarifa"] = $this->TarifaModelo->listar();
        echo json_encode($datos);
        exit();
    }


     /**
     * Actualizar tarifas
     *
     */
    public function update()
    {
        $datos["tarifa"] = $this->TarifaModelo->listar();

        if (count($datos["tarifa"])  == 0) {
            $this->TarifaModelo->insertar(array(
                'minuto_autos' => $this->request->minuto_autos,
                'minuto_bicicletas' => $this->request->minuto_bicicletas,
                'minuto_motos' => $this->request->minuto_bicicletas,
                'descuento' => $this->request->descuento,
                'minutos' => $this->request->minutos,
            ));
        } else {
            $this->TarifaModelo->actualizar(array(
                'id' => 1,
                'minuto_autos' => $this->request->minuto_autos,
                'minuto_bicicletas' => $this->request->minuto_bicicletas,
                'minuto_motos' => $this->request->minuto_motos,
                'descuento' => $this->request->descuento,
                'minutos' => $this->request->minutos,
            ));
        }
    }
    
}
