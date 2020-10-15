<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ParqueaderoModelo extends CI_Model
{
    public $id;
    public $hora_entrada;
    public $hora_salida;
    public $minutos;
    public $valor_minuto;
    public $total;
    public $estado;
    public $id_vehiculo;


    public function __construct()
    {
        parent::__construct();
    }



    public function listar()
    {
        $this->db->where('estado', "Disponible");
        $query = $this->db->get('parqueadero')->result();
        return $query;
    }


    public function listarTipo($tipo)
    {
        $this->db->where('estado', "Disponible");
        $this->db->where('tipo', $tipo);
        $query = $this->db->get('parqueadero')->result();
        return $query;
    }

    public function listarAutos()
    {
        $this->db->where('tipo', "Automovil");
        $query = $this->db->get('parqueadero')->result();
        return $query;
    }

    public function listarBicicletas()
    {
        $this->db->where('tipo', "Bicicleta");
        $query = $this->db->get('parqueadero')->result();
        return $query;
    }

    public function listarMotos()
    {
        $this->db->where('tipo', "Moto");
        $query = $this->db->get('parqueadero')->result();
        return $query;
    }

    public function listarPlaca($placa)
    {
        $this->db->where('placa', $placa);
        $query = $this->db->get('parqueadero')->result();
        return $query;
       
    }

    public function listarParqueadero($parqueadero)
    {
        $this->db->where('parqueadero', $parqueadero);
        $query = $this->db->get('parqueadero')->result();
        return $query;
       
    }

    public function actualizar($data)
    {
        $this->db->where('parqueadero', $data['parqueadero'])->update('parqueadero', array(
            'estado' => $data['estado'],
            'placa' => $data['placa'],
        ));
    }
}
