<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TarifaModelo extends CI_Model
{
    public $id;
    public $minuto_autos;
    public $minuto_bicicletas;
    public $minuto_motos;
    public $descuento;
    public $minutos;


    public function __construct()
    {
        parent::__construct();
    }


    public function listar()
    {
        $query = $this->db->get('tarifas')->result();
        return $query;
    }


    public function insertar($data)
    {
        $this->db->insert('tarifas', array(
            'minuto_autos' => $data['minuto_autos'],
            'minuto_bicicletas' => $data['minuto_bicicletas'],
            'minuto_motos' => $data['minuto_motos'],
            'descuento' => $data['descuento'],
            'minutos' => $data['minutos'],
        ));

    }


    public function actualizar($data)
    {
        $this->db->where('id', $data['id'])->update('tarifas', array(
            'minuto_autos' => $data['minuto_autos'],
            'minuto_bicicletas' => $data['minuto_bicicletas'],
            'minuto_motos' => $data['minuto_motos'],
            'descuento' => $data['descuento'],
            'minutos' => $data['minutos'],
        ));
    }
    
}
