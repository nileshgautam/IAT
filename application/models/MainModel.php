<?php

class MainModel extends ci_model
{
    public function insertInto($tableName = null, $data = null)
    {
        $this->db->insert($tableName, $data);
        $insert_id = $this->db->insert_id();
        return $this->db->affected_rows() ? $insert_id : FALSE;
    }

    public function Update($column_name = null, $tableName = null, $data = null, $id = null)
    {
        $this->db->set($column_name, $data);  //Set the column name and which value to set..

        $this->db->where('item_id', $id); //set column_name and value in which row need to update

        $this->db->update($tableName); //Set your table name
    }

    public function selectId($tableName = null, $columnName = null)
    {
        $this->db->select($columnName); // ('a,b,c')
        $result = $this->db->get($tableName)->result_array();
        return $this->db->affected_rows() ? $result : FALSE;
    }

    public function selectAll($tableName = null, $order_col = null)
    {
        $this->db->order_by($order_col, "asc");
        $result = $this->db->get($tableName)->result_array();

        return $this->db->affected_rows() ? $result : FALSE;
    }

    public function selectDistict($tableName = null, $selection_value = null)
    {
        $this->db->distinct();
        $this->db->select($selection_value);
        $result = $this->db->get($tableName)->result_array();
        return $this->db->affected_rows() ? $result : FALSE;
    }

    public function selectAllForDuplicate($tableName = null, $condition = null)
    {
        $query = $this->db->get_where($tableName, $condition)->result_array();

        if ($query != null) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function selectAllFromWhere($tableName = null, $condition = null, $order_col = null)
    {
        $this->db->order_by($order_col, "asc");
        $query = $this->db->get_where($tableName, $condition)->result_array();
        if ($query != null) {
            return $this->db->affected_rows() ? $query : FALSE;
        } else {
            return FALSE; //$this->db->affected_rows()?$query[0][$query]:FALSE;
        }
    }

    public function update_field_where($clm_name = null, $clm_val = null, $table = null, $data = null)
    {
        $this->db->where($clm_name, $clm_val);
        $query = $this->db->update($table, $data);
        if ($query != null) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function deleteRow($tableName = null, $condition = null)
    {
        $this->db->where($condition);
        $query = $this->db->delete($tableName);
        if ($query != null) {
            return 'FALSE';
        } else {
            return TRUE;
        }
    }

    //create new id for product/order table
    public function getNew_Id($prefix, $table, $pad_length = 3)
    {
        $id = 0;
        $row = $this->db->query("SELECT max(id) as maxid  FROM " . $table)->row();

        if ($row) {
            $id = $row->maxid;
        }
        $id++;

        $Id = strtoupper($prefix . date('y') . date('m') . date('d') . str_pad($id, $pad_length, '0', STR_PAD_LEFT));

        return $Id; // $maxid==NULL?1:$maxid+1;
    }
    public function update_table($table = null, $condition = null, $data = null)
    {
        // $this->db->set('status', $data);
        $this->db->where($condition);
        $query = $this->db->update($table, $data);
        if ($query != null) {
            return true;
        } else {
            return false;
        }
    }

    public function insert_status($table = null, $data = null)
    {
        $this->db->insert($table, $data);
        return $this->db->affected_rows() ? 'TRUE' : 'FALSE';
    }
    //delete records by using 
    public function delete($tableName = null, $id = null)
    {
        $query =  $this->db->where($id);
        $this->db->delete($tableName);
        if ($query != null) {
            return 'FALSE';
        } else {
            return TRUE;
        }
    }

    public function max_date($table = null, $date_clm = null)
    {

        $this->db->select_max($date_clm);
        $query = $this->db->get($table);  // Produces: SELECT MAX(date) as date FROM members
        return $query->result_array();
    }
    // function to select records by column
    public function select_Column($column = null, $tableName = null, $condition = null)
    {
        $this->db->distinct();
        $this->db->select($column);
        $this->db->where($condition);
        $query = $this->db->get($tableName)->result_array();
        return $query;
    }

    // function to select records by column which are ununique
    public function select_Duplicate_Column($column = null, $tableName = null, $condition = null)
    {

        $this->db->select($column);
        $this->db->where($condition);
        $query = $this->db->get($tableName)->result_array();
        return $query;
    }

    // function to extract date in yyyy-mm-dd format from timestamp field between given range
    public function selectAllBetween($tableName = null, $first_condition = null, $second_condition = null)
    {
        $this->db->where($first_condition);
        $this->db->where($second_condition);
        $query = $this->db->get($tableName)->result_array();
        return $this->db->affected_rows() ? $query : false;
    }


    // function to extract date in yyyy-mm-dd format from timestamp field
    public function selectAllsubDate($column = null, $tableName = null)
    {
        // print_r($column);print_r($tableName);
        $query = "SELECT *, SUBSTRING($column,1,10) as mynewdate from $tableName";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    // function to extract date in dd-mm-yy format from database field
    public function selectAll_PA_job($colomn = null, $tableName = null)
    {
        // $query="SELECT *, concat(SUBSTRING($colomn,7,2),SUBSTRING($colomn,4,2),SUBSTRING($colomn,1,2)) as mynewdate from $tableName";

        $query = "SELECT *, SUBSTRING($colomn,1,8) as mynewdate from $tableName";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    // function to extract seller orders by ids from database in Job card table..
    public function selectAll_date_where_id($colomn = null, $tableName = null, $id = null)
    {

        $query = "SELECT *, SUBSTRING($colomn,1,10) as mynewdate from $tableName WHERE seller_id=$id";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    // function to extract seller all orders by  from database in Job card table..
    public function selectAll_order($colomn = null, $tableName = null, $status = null)
    {
        $query = "SELECT *, SUBSTRING($colomn,1,10) as mynewdate from $tableName where $status";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    public function selectAllProcessAndSubprocess($table = null, $p_id = null, $sp_id = null)
    {
        $query = "SELECT * FROM $table WHERE sub_process_id in ($sp_id) AND process_id = $p_id";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    public function selectAllbyMultipleId($table = null, $id = null, $col = null)
    {
        $query = "SELECT * FROM $table WHERE $col in ($id)";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    public function getProcessWithSubprocess($p_id, $sp_id)
    {
        $query = "SELECT p.process_name,p.process_id,sp.sub_process_name,sp.sub_process_id
                  FROM process_master p
                  LEFT JOIN sub_process_master sp ON p.process_id = sp.process_id
                  WHERE p.process_id = '$p_id' AND sp.sub_process_id IN ($sp_id)";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    public function getAllProcessWithSubprocess()
    {
        $query = "SELECT p.process_name,p.process_id,sp.sub_process_name,sp.sub_process_id
                  FROM process_master p
                  LEFT JOIN sub_process_master sp ON p.process_id = sp.process_id";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    // public function count($table = null, $id = null)
    // {
    //     $query = "SELECT COUNT(client_id) FROM $table WHERE client_id = '$id'";
    //     $result = $this->db->query($query)->result_array();
    //     return $this->db->affected_rows() ? $result[0]['COUNT(client_id)'] : false;
    //     // return $query;
    // }

    public function selectAllWhere($tableName = null, $condition = null)
    {
        $this->db->where($condition);
        $query = $this->db->get($tableName)->result_array();
        return $this->db->affected_rows() ? $query : false;
    }

    public function getClientOrders($table, $id)
    {
        $query = "SELECT work_order_id from $table WHERE client_id = '$id'";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    public function getProcessId($table, $id)
    {
        $query = "SELECT processes from $table WHERE work_order_id IN ($id)";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }
    
    public function getallworkorder($id)
    {
        $query = "SELECT client_workorder_relationship.client_id, work_order.work_order_id, work_order.work_order_name, work_order.processes, work_order.end_date as target_date, users_work_order_relationship.user_id, users_work_order_relationship.created_date As assgindate , users_work_order_relationship.work_status FROM work_order LEFT JOIN client_workorder_relationship on work_order.work_order_id= client_workorder_relationship.work_order_id LEFT JOIN users_work_order_relationship on work_order.work_order_id=users_work_order_relationship.work_order_id
        WHERE users_work_order_relationship.user_id='$id' ORDER by users_work_order_relationship.created_date DESC";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }
    // function to pick all the users data from the database
    public function getAlluersWithAsseignedWorkorders()
    {
        $query = "SELECT * FROM `users`LEFT JOIN users_work_order_relationship on users.user_id =users_work_order_relationship.user_id";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    // Function to count all the rows from database by table name.
    public function count( $table = null)
    {
       $query= "SELECT count(*) as total FROM $table ORDER BY id DESC";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    public function selectWhere( $table = null, $conditionOne=null, $conditionTwo=null)
    {
        $query= "SELECT * FROM $table where $conditionOne and $conditionTwo ORDER BY id DESC";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }  
    
    // funtion to select all the worksteps by client name and their orders
    public function selectAllworkOrder()
    {
        $query= "SELECT * , client_details.client_name FROM work_order LEFT join client_details on work_order.client_id=client_details.client_id";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

}
