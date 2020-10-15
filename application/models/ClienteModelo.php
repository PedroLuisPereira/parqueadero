<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ClienteModelo extends CI_Model
{
    public $numero_documento;
    public $nombre;
    public $apellidos;


    public function __construct()
    {
        parent::__construct();
    }


    public function listar()
    {   
        $this->db->order_by('nombre', 'ASC');
        $query = $this->db->get('clientes')->result();
        return $query;
    }

    public function getNumeroDocumento($numero_documento)
    {
        $query = $this->db->where('numero_documento', $numero_documento)->get('clientes')->result();
        return $query;
    }

    public function insertar($data)
    {
        $this->db->insert('clientes', array(
            'numero_documento' => $data['numero_documento'],
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
        ));

        return $this->db->insert_id();
    }



    public function actualizar($data)
    {
        $this->db->where('id', $data['id'])->update('clientes', array(
            'numero_documento' => $data['numero_documento'],
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
        ));
    }

    public function eliminar($data)
    {
        $this->db->delete('clientes', array('id' => $data['id']));
    }
}
