<?php

defined('BASEPATH') or exit('No direct script access allowed');

class VehiculoModelo extends CI_Model
{
    public $tipo;
    public $placa;
    public $id_cliente;

    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $query = $this->db
            ->select('vehiculos.id, vehiculos.placa, vehiculos.tipo, clientes.nombre, clientes.apellidos')
            ->from('vehiculos')
            ->join('clientes', 'clientes.id = vehiculos.id_cliente')
            ->order_by('clientes.nombre')
            ->get()
            ->result();
        return $query;
    }


    public function listarIdCliente($id_cliente)
    {
        $query = $this->db->where('id_cliente', $id_cliente)->get('vehiculos')->result();
        return $query;
    }

    public function listarPlaca($placa)
    {
        $query = $this->db->where('placa', $placa)->get('vehiculos')->result();
        return $query;
    }

    public function listarCliente($placa)
    {
        $this->db->select('clientes.nombre, clientes.apellidos, clientes.numero_documento');
        $this->db->from('vehiculos');
        $this->db->join('clientes', 'vehiculos.id_cliente = clientes.id');
        $this->db->where('vehiculos.placa', $placa);
        $query = $this->db->get()->result();
        return $query;
    }

    public function getPlaca($placa)
    {
        $query = $this->db->where('placa', $placa)->get('vehiculos')->result();
        return $query;
    }

    public function insertar($data, $id_cliente)
    {
        $this->db->insert('vehiculos', array(
            'tipo' => $data['tipo'],
            'placa' => $data['placa'],
            'id_cliente' => $id_cliente,
        ));
    }

    public function actualizar($data)
    {
        $this->db->where('id', $data['id'])->update('vehiculos', array(
            'tipo' => $data['tipo'],
            'placa' => $data['placa'],
        ));
    }

    public function eliminar($data)
    {
        $this->db->delete('vehiculos', array('id' => $data['id']));
    }
}
