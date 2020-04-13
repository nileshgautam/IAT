<?php

class MainModel extends ci_model
{
    public function insertInto($tableName = null, $data = null)
    {
        $this->db->insert($tableName, $data);
        $insert_id = $this->db->insert_id();
        return $this->db->affected_rows() ? $insert_id : FALSE;
    }

    public function selectAllWhere($tableName = null, $condition = null)
    {
        $this->db->where($condition);
        $query = $this->db->get($tableName)->result_array();
        return $this->db->affected_rows() ? $query : false;
    }

    // function to extract all data form data base by table name short by given 
    public function selectAll($tableName = null, $order_col = null)
    {
        $this->db->order_by($order_col, "asc");
        $result = $this->db->get($tableName)->result_array();

        return $this->db->affected_rows() ? $result : FALSE;
    }

    // function to extract distinct data from given table
    public function selectDistict($tableName = null, $selection_value = null)
    {
        $this->db->distinct();
        $this->db->select($selection_value);
        $result = $this->db->get($tableName)->result_array();
        return $this->db->affected_rows() ? $result : FALSE;
    }
    // function to select all data from database in given condition 
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

    // update table 

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
    // function to delete row with given condition
    public function deleteRow($tableName = null, $condition = null)
    {
        $this->db->where($condition);
        $query = $this->db->delete($tableName);
        return ($query != null) ? FALSE : TRUE;
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


    public function selectAllworkOrder()
    {
        $query = "SELECT * , client_details.client_name FROM work_order LEFT join client_details on work_order.client_id=client_details.client_id";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }


    // function to select all the process data from the database 

    public function getAllprocess($id)
    {
        $query = "SELECT process_master.process_id, process_master.process_description,sub_process_master.sub_process_id,sub_process_master.sub_process_description, risk_master.risk_id, risk_master.risk_name, risk_master.risk_level,control_master.control_id, control_master.control_name, work_steps.work_steps_id,work_steps.steps_name,control_objective_master.ctrl_obj_id, control_objective_master.ctrl_obj_name FROM process_master left JOIN sub_process_master on process_master.process_id=sub_process_master.process_id LEFT JOIN risk_master on sub_process_master.sub_process_id=risk_master.sub_process_id LEFT JOIN control_master on risk_master.risk_id=control_master.risk_id LEFT JOIN work_steps on work_steps.control_id=control_master.control_id LEFT JOIN control_objective_master on control_master.control_id=control_objective_master.control_id WHERE sub_process_master.sub_process_id='$id' ORDER BY `risk_master`.`risk_level` ASC";

        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    function getControlByRiskID($id = null)
    {

        $query = "SELECT process_master.process_id, process_master.process_description,sub_process_master.sub_process_id,sub_process_master.sub_process_description, risk_master.risk_id, risk_master.risk_name, risk_master.risk_level,control_master.control_id, control_master.control_name, work_steps.work_steps_id,work_steps.steps_name,control_objective_master.ctrl_obj_id, control_objective_master.ctrl_obj_name FROM process_master left JOIN sub_process_master on process_master.process_id=sub_process_master.process_id LEFT JOIN risk_master on sub_process_master.sub_process_id=risk_master.sub_process_id LEFT JOIN control_master on risk_master.risk_id=control_master.risk_id LEFT JOIN work_steps on work_steps.control_id=control_master.control_id LEFT JOIN control_objective_master on control_master.control_id=control_objective_master.control_id WHERE sub_process_master.sub_process_id='$id' ORDER BY `risk_master`.`risk_level` ASC";

        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    function getRiskbyId($subprocessId = null)
    {
        $query = "SELECT risk_master.sub_process_id, risk_master.risk_id, risk_master.risk_name, risk_master.risk_level, control_master.control_id,control_master.control_name FROM `risk_master` LEFT JOIN control_master on risk_master.risk_id=control_master.risk_id WHERE risk_master.sub_process_id='$subprocessId'";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }
    // function to find all control and work steps by risk id

    public function getControlWorkstepByid($risk_id = null)
    {
        $query = "SELECT control_master.risk_id, control_master.control_id, control_master.control_description, control_master.control_objectives, work_steps.work_steps_id, work_steps.step_description from control_master LEFT JOIN work_steps on control_master.control_id=work_steps.control_id WHERE control_master.risk_id='$risk_id'";;
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    // function for extraction work order details from data base
    public function getSelectedWorkorder($id)
    {
        $query = "SELECT client_details.client_id, client_details.client_name, work_order.work_order_id, work_order.work_order_name, work_order.processes,work_order.start_date, work_order.end_date FROM client_details LEFT JOIN work_order on client_details.client_id=work_order.client_id WHERE work_order.work_order_id='$id'";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    // function to get all users

    function getallusers()
    {
        $query = "SELECT * FROM `users` WHERE role!='Admin'";
        $result = $this->db->query($query)->result_array();
        return $this->db->affected_rows() ? $result : false;
    }

    //create new id for product/order table
    // public function getNew_Id($prefix, $table, $pad_length = 3)
    // {
    //     $id = 0;
    //     $row = $this->db->query("SELECT max(id) as maxid  FROM " . $table)->row();

    //     if ($row) {
    //         $id = $row->maxid;
    //     }
    //     $id++;

    //     $Id = strtoupper($prefix . date('y') . date('m') . date('d') . str_pad($id, $pad_length, '0', STR_PAD_LEFT));

    //     return $Id; // $maxid==NULL?1:$maxid+1;
    // }


    // public function Update($column_name = null, $tableName = null, $data = null, $id = null)
    // {
    //     $this->db->set($column_name, $data);  //Set the column name and which value to set..

    //     $this->db->where('item_id', $id); //set column_name and value in which row need to update

    //     $this->db->update($tableName); //Set your table name
    // }

    // //delete records by using 
    // public function delete($tableName = null, $id = null)
    // {
    //     $query =  $this->db->where($id);
    //     $this->db->delete($tableName);
    //     if ($query != null) {
    //         return 'FALSE';
    //     } else {
    //         return TRUE;
    //     }
    // }

    // public function max_date($table = null, $date_clm = null)
    // {

    //     $this->db->select_max($date_clm);
    //     $query = $this->db->get($table);  // Produces: SELECT MAX(date) as date FROM members
    //     return $query->result_array();
    // }


    // // function to select records by column which are ununique
    // public function select_Duplicate_Column($column = null, $tableName = null, $condition = null)
    // {

    //     $this->db->select($column);
    //     $this->db->where($condition);
    //     $query = $this->db->get($tableName)->result_array();
    //     return $query;
    // }

    // // function to extract date in yyyy-mm-dd format from timestamp field between given range
    // public function selectAllBetween($tableName = null, $first_condition = null, $second_condition = null)
    // {
    //     $this->db->where($first_condition);
    //     $this->db->where($second_condition);
    //     $query = $this->db->get($tableName)->result_array();
    //     return $this->db->affected_rows() ? $query : false;
    // }




    // public function selectAllProcessAndSubprocess($table = null, $p_id = null, $sp_id = null)
    // {
    //     $query = "SELECT * FROM $table WHERE sub_process_id in ($sp_id) AND process_id = $p_id";
    //     $result = $this->db->query($query)->result_array();
    //     return $this->db->affected_rows() ? $result : false;
    // }

    // public function selectAllbyMultipleId($table = null, $id = null, $col = null)
    // {
    //     $query = "SELECT * FROM $table WHERE $col in ($id)";
    //     $result = $this->db->query($query)->result_array();
    //     return $this->db->affected_rows() ? $result : false;
    // }

    // public function getProcessWithSubprocess($p_id, $sp_id)
    // {
    //     $query = "SELECT p.process_description,p.process_id,sp.sub_process_description,sp.sub_process_id
    //               FROM process_master p
    //               LEFT JOIN sub_process_master sp ON p.process_id = sp.process_id
    //               WHERE p.process_id = '$p_id' AND sp.sub_process_id IN ($sp_id)";
    //     $result = $this->db->query($query)->result_array();
    //     return $this->db->affected_rows() ? $result : false;
    // }

    // public function getAllProcessWithSubprocess()
    // {
    //     $query = "SELECT p.process_description,p.process_id,sp.sub_process_description,sp.sub_process_id
    //               FROM process_master p
    //               LEFT JOIN sub_process_master sp ON p.process_id = sp.process_id";
    //     $result = $this->db->query($query)->result_array();
    //     return $this->db->affected_rows() ? $result : false;
    // }






    // // Function to count all the rows from database by table name.
    // public function count($table = null)
    // {
    //     $query = "SELECT count(*) as total FROM $table ORDER BY id DESC";
    //     $result = $this->db->query($query)->result_array();
    //     return $this->db->affected_rows() ? $result : false;
    // }

    // public function selectWhere($table = null, $conditionOne = null, $conditionTwo = null)
    // {
    //     $query = "SELECT * FROM $table where $conditionOne and $conditionTwo ORDER BY id DESC";
    //     $result = $this->db->query($query)->result_array();
    //     return $this->db->affected_rows() ? $result : false;
    // }

    // funtion to select all the worksteps by client name and their orders data from two table using left join

    // count complete work steps

    // public function workstepCount($wId = '', $prId = '', $spId = '')
    // {
    //     $query1 = "SELECT COUNT(work_step_id) AS completeSteps FROM work_steps_complete_status WHERE work_order_id = '$wId' AND process_id = '$prId' AND sub_process_id = '$spId'";

    //     $query2 = "SELECT COUNT(work_steps_id) AS totalSteps  FROM work_steps WHERE sub_process_id = '$spId'";
    //     $result1 = $this->db->query($query1)->result_array();
    //     $result2 = $this->db->query($query2)->result_array();
    //     return $this->db->affected_rows() ? array($result2[0], $result1[0]) : false;
    // }

    // public function CompleteWorkorder()
    // {
    //     $query = 'SELECT *, client_details.client_name FROM `work_order` left JOIN client_details on client_details.client_id=work_order.client_id where work_order.complete_status=' . Complete . '
    //    ';
    //     $result = $this->db->query($query)->result_array();
    //     return $this->db->affected_rows() ? $result : false;
    // }


    // public function CompleteWorkstepsByworkorders()
    // {
    //     $query = 'SELECT work_order_id, process_id,sub_process_id, COUNT(*) as Complete_steps_total FROM `work_steps_complete_status` GROUP by work_order_id
    //    ';
    //     $result = $this->db->query($query)->result_array();
    //     return $this->db->affected_rows() ? $result : false;
    // }


}
