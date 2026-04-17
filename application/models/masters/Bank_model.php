<?php
class Bank_model extends CI_Model
{
  private $tb = "bank_account";

  public function __construct()
  {
    parent::__construct();
  }


	public function add(array $ds = array())
	{
		if(!empty($ds))
		{
			return $this->db->insert($this->tb, $ds);
		}

		return FALSE;
	}


	public function update($id, array $ds = array())
	{
		if(!empty($ds) && !empty($id))
		{
			return $this->db->where('id', $id)->update($this->tb, $ds);
		}

		return FALSE;
	}


	public function delete($id)
	{
		return $this->db->where('id', $id)->delete($this->tb);
	}


	public function get($id)
	{
		$rs = $this->db->where('id', $id)->get($this->tb);

		if($rs->num_rows() === 1)
		{
			return $rs->row();
		}

		return NULL;
	}


	public function get_id($acc_no)
	{
		$rs = $this->db->select('id')->where('acc_no', $acc_no)->get($this->tb);

		if($rs->num_rows() === 1)
		{
			return $rs->row()->id;
		}

		return NULL;
	}


  public function get_by_account_no($acc_no)
  {
    $rs = $this->db->where('acc_no', $acc_no)->get($this->tb);

    if($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function is_exists_account_no($acc_no, $id = NULL)
  {
    if( ! empty($id))
    {
      $this->db->where('id !=', $id);
    }

    return $this->db->where('acc_no', $acc_no)->count_all_results($this->tb) > 0;
  }

	
  public function get_all($active = FALSE)
  {
    if($active === TRUE)
    {
      $this->db->where('active', 1);
    }

    $rs = $this->db->get($this->tb);

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function count_rows(array $ds = array())
  {
    if(!empty($ds['bank_code']) && $ds['bank_code'] !== 'all')
    {
      $this->db->where('bank_code', $ds['bank_code']);
    }

    if(!empty($ds['account_name']))
    {
      $this->db->like('acc_name', $ds['account_name']);
    }

    if(!empty($ds['account_no']))
    {
      $this->db->like('acc_no', $ds['account_no']);
    }

    if(!empty($ds['branch']))
    {
      $this->db->like('branch', $ds['branch']);
    }

    if(isset($ds['active']) && $ds['active'] !== 'all')
    {
      $this->db->where('active', $ds['active']);
    }

    return $this->db->count_all_results($this->tb);
  }


  public function get_list(array $ds = array(), $perpage = 20, $offset = 0)
  {
    $this->db
    ->select('ac.*, b.name AS bank_name')
    ->from('bank_account AS ac')
    ->join('bank AS b', 'ac.bank_code = b.code', 'left');

    if(!empty($ds['bank_code']) && $ds['bank_code'] !== 'all')
    {
      $this->db->where('ac.bank_code', $ds['bank_code']);
    }

    if(!empty($ds['account_name']))
    {
      $this->db->like('ac.acc_name', $ds['account_name']);
    }

    if(!empty($ds['account_no']))
    {
      $this->db->like('ac.acc_no', $ds['account_no']);
    }

    if(!empty($ds['branch']))
    {
      $this->db->like('ac.branch', $ds['branch']);
    }

    if(isset($ds['active']) && $ds['active'] !== 'all')
    {
      $this->db->where('ac.active', $ds['active']);
    }

    $rs = $this->db
    ->order_by('ac.id', 'ASC')
    ->limit($perpage, $offset)
    ->get();
    
    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }


  public function has_transection($id)
  {
    $exists = FALSE;
    
    if( ! $exists && $this->db->where('account_id', $id)->count_all_results('payment_method') > 0)
    {
      $exists = TRUE;
    }

    if( ! $exists && $this->db->where('acc_id', $id)->count_all_results('order_pos_payment') > 0)
    {
      $exists = TRUE;
    }

    if( ! $exists && $this->db->where('acc_id', $id)->count_all_results('pos_sales_movement') > 0)
    {
      $exists = TRUE;
    }

    if( ! $exists && $this->db->where('id_account', $id)->count_all_results('order_payment') > 0)
    {
      $exists = TRUE;
    }

    if( ! $exists && $this->db->where('acc_id', $id)->count_all_results('order_down_payment') > 0)
    {
      $exists = TRUE;
    }

    return $exists;
  }

} //---- End class


 ?>
