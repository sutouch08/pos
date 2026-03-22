<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
  private $tb = "menu";
  private $tg = "menu_group";
  private $ts = "menu_sub_group";

  public function __construct()
  {
    parent::__construct();
  }


  public function get($menu)
  {
    $rs = $this->db->where('code', $menu)->get($this->tb);

    if($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }
  

  public function get_active_menu_groups($type = 'side')
  {
    $rs = $this->db
      ->where('type', $type)
      ->where('active', 1)
      ->order_by('position', 'ASC')
      ->get($this->tg);

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function get_menu_groups()
  {
    $rs = $this->db->order_by('position', 'ASC')->get($this->tg);

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function get_menus_sub_group($group_code)
  {
    $rs = $this->db
      ->where('group_code', $group_code)
      ->where('active', 1)
      ->order_by('position', 'ASC')
      ->get($this->ts);

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function get_menus_by_sub_group($sub_group_code, $group_code)
  {
    $rs = $this->db
      ->where('group_code', $group_code)
      ->where('sub_group', $sub_group_code)
      ->where('active', 1)
      ->where('url IS NOT NULL')
      ->order_by('position', 'ASC')
      ->get($this->tb);

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function get_menus_by_group($group_code, $all = TRUE)
  {
    $this->db
      ->where('group_code', $group_code)
      ->where('active', 1);

    if ($all === FALSE)
    {
      $this->db
        ->where('sub_group IS NULL', NULL, FALSE)
        ->where('url IS NOT NULL');
    }

    $rs = $this->db
      ->order_by('position', 'ASC')
      ->get($this->tb);

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function get_valid_menus_by_group($group_code, $all = TRUE)
  {
    $this->db
      ->where('group_code', $group_code)
      ->where('active', 1);

    if ($all === FALSE)
    {
      $this->db
        ->where('sub_group IS NULL', NULL, FALSE)
        ->where('url IS NOT NULL');
    }

    $rs = $this->db
      ->where('valid', 1)
      ->order_by('position', 'ASC')
      ->get($this->tb);

    if ($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function count_menu($group_code)
  {
    return $this->db->where('group_code', $group_code)->count_all_results($this->tb);
  }


  public function is_active($menu_code)
  {
    $count = $this->db->where('code', $menu_code)->where('active', 1)->count_all_results($this->tb);

    return $count > 0 ? TRUE : FALSE;
  }
}
