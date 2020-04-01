<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MainWebsite extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Audit_model');
		$this->load->helper('filter');
		if (!isset($_SESSION['userInfo'])) {
			$this->session->sess_destroy();
			redirect('Login/index');
		}
	}




	public function upload_excel()
	{

		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('template/upload-master');
		$this->load->view('layout/footer');
	}

	public function excel_reader()
	{
		if (empty($_FILES['sample_file']['tmp_name'])) {
			$this->session->set_flashdata('error', "Please Choose file");
			redirect(__CLASS__ . '/upload_excel');
		}

		$file = $_FILES['sample_file']['tmp_name'];
		$filename = $_FILES['sample_file']['name'];
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		if (!empty($extension)) {
			if ($extension != 'csv' && $extension != 'xlsx' && $extension != 'XLSX') {
				$this->session->set_flashdata("error", "System Error, Only CSV and Xlsx files are allowed.");
				redirect(__CLASS__ . '/upload_excel');
			}
		}
		if (!is_readable($file)) {
			$this->session->set_flashdata('error', "File is not readable.");
			redirect(__CLASS__ . '/upload_excel');
		}

		$objPHPExcel = PHPExcel_IOFactory::load($file);
		//get only the Cell Collection


		//extract to a PHP readable array format
		foreach ($objPHPExcel->getWorksheetIterator() as $key => $worksheet) {
			$cell_collection = $worksheet->getCellCollection();

			for ($i = 0; $i < count($cell_collection); $i++) {
				$column = $worksheet->getCell($cell_collection[$i])->getColumn();
				$row = $worksheet->getCell($cell_collection[$i])->getRow();
				$data_value = $worksheet->getCell($cell_collection[$i])->getValue();
				//header will/should be in row 1 only. of course this can be modified to suit your need.
				$arr_data[$key][$row][$column] = $data_value;
			}
		}
		if (($arr_data[0][1]['A'] == 'process_id') && ($arr_data[0][1]['B'] == 'process_description') && ($arr_data[0][1]['C'] == 'sub_process_id') && ($arr_data[0][1]['D'] == 'sub_process_description') && ($arr_data[0][1]['E'] == 'work_steps_id') && ($arr_data[0][1]['F'] == 'step_description') && ($arr_data[0][1]['G'] == 'mandatory_status') && ($arr_data[0][1]['H'] == 'risk_id') && ($arr_data[0][1]['I'] == 'risk_name')) {
			$data = $this->excel_data($arr_data);
			// get all unique processes
			$processes = $this->get_all_unique($data[0], 'process_description');
			$empty_cell=[];
			$empty_cell_counter=0;
			$counter = 0;
			$risk_counter=0;
			$sub_process_counter=0;
			$error=0;
			// get all unique process name
			foreach ($processes as $key => $process_name) {
				if (!empty($process_name)) {
					// find process by process name
					$res_based_name = $this->Audit_model->find_process_id('process_master', 'process_description', $process_name);
					$next_id = 0;
					if ($res_based_name) {
					    // keep process id to check sub processes	 
						$next_id = $res_based_name[0]['process_id'];
					} else {
						// check the process with process id if process name not matched
						$res_based_id = $this->Audit_model->find_process_id('process_master', 'process_id', $data[0][$key]['process_id']);
						if ($res_based_id) {
							$data_s = array("process_name" => $process_name);
							$condition = array("process_id" =>  $res_based_id[0]['process_id']);
							$next_id = $res_based_id[0]['process_id'];
							//update process_name
							$this->Audit_model->update_table('process_master', $condition, $data_s);
						} else {
							// if process not found then enter new process
							$next_id = $this->Audit_model->getNewIDorNo('p', 'process_master');
							$tbl_data = array('process_description' => $process_name, 'status' => 0, 'process_id' => $next_id);
							$this->Audit_model->insertData('process_master', $tbl_data);
						}
					}
				} else {
					$empty_cell_counter++;
					array_push($empty_cell,'process_description');
					$error=1;
				}
				//find sub_processs for each process
				$sub_process_data = $this->get_data_by_filter($data['0'], $process_name, 'process_description');
				// find unique sub_process
				$unique_sub_process_name = $this->get_all_unique($sub_process_data, 'sub_process_description');
  
				
				foreach ($unique_sub_process_name as $sp_key => $sub_process_name) {
					if (!empty($sub_process_name)) {
						
						$condition = array('sub_process_description' => $sub_process_name, 'process_id' => $next_id);
						$next_sub_process_id = 0;
						// check sub processes by process id and sub_process name  
						$res_based_sub_process_name = $this->Audit_model->select_table_Where_data('sub_process_master', $condition);
						
						if ($res_based_sub_process_name) {
							
							$next_sub_process_id = $res_based_sub_process_name[0]['sub_process_id'];
						} else {
							$condition = array('sub_process_id' => $sub_process_data[$sub_process_counter]['sub_process_id'], 'process_id' => $next_id);
							$res_based_sub_process_id = $this->Audit_model->select_table_Where_data('sub_process_master', $condition);
							if ($res_based_sub_process_id) {
								$data_sub = array("sub_process_name" => $sub_process_name);
								$condition = array("sub_process_id" =>  $res_based_sub_process_id[0]['sub_process_id']);
								//update process_name
								$this->Audit_model->update_table('sub_process_master', $condition, $data_sub);
							} else {
								$next_sub_process_id = $this->Audit_model->getNewIDorNo('sp', 'sub_process_master');
								$tbl_data = array('sub_process_description' => $sub_process_name, 'status' => 0, 'process_id' => $next_id, 'sub_process_id' => $next_sub_process_id);
								$this->Audit_model->insertData('sub_process_master', $tbl_data);
							}
						}
					} else {
						$empty_cell_counter++;
						array_push($empty_cell,'sub_process_description');
						$error=1;
					}
					// filter data by sub process name and process name
					$work_steps_data = $this->get_data_by_multiple_column_filter($data['0'], [$process_name, $sub_process_name], ['process_description', 'sub_process_description']);
					// find unique records of work steps	
					$unique_work_steps = $this->get_all_unique($work_steps_data, 'step_description');
					
					foreach ($unique_work_steps as $key => $work_steps_name) {
						if (!empty($work_steps_name)) {
							
							$condition = array('step_description' => $work_steps_name, 'sub_process_id' => $next_sub_process_id);
							// check the work steps by step name and sub process id  
							$res_based_work_steps_name = $this->Audit_model->select_table_Where_data('work_steps', $condition);

							
							if ($res_based_work_steps_name) {
								// do nothing
							} else {
								$condition = array('sub_process_id' => $next_sub_process_id, 'work_steps_id' => $work_steps_data[$counter]['work_steps_id']);

								// check the work steps by work step id and sub process id   
								$res_based_work_steps_id = $this->Audit_model->select_table_Where_data('work_steps', $condition);

								if ($res_based_work_steps_id) {
									$data_steps = array("steps_name" => $work_steps_name, "mandatory_status" =>  !empty($work_steps_data[$counter]['mandatory_status'])? $work_steps_data[$counter]['mandatory_status']:'NM');
									$condition = array("work_steps_id" =>  $res_based_work_steps_id[0]['work_steps_id']);
								
									$this->Audit_model->update_table('work_steps', $condition, $data_steps);
								} else {
								
									$next_work_steps_id = $this->Audit_model->getNewIDorNo('ws', 'work_steps');
									$tbl_data = array('step_description' => $work_steps_name, 'status' => 0, 'work_steps_id' => $next_work_steps_id, 'sub_process_id' => $next_sub_process_id, "mandatory_status" =>  !empty($work_steps_data[$counter]['mandatory_status'])? $work_steps_data[$counter]['mandatory_status']:'NM');
									$this->Audit_model->insertData('work_steps', $tbl_data);
								}
							}
						} else {
							$empty_cell_counter++;
							array_push($empty_cell,'work_steps');
							$error=1;
						}

						$counter++;
					}

					// find unique records of risk	
					$unique_risk_name= $this->get_all_unique($work_steps_data , 'risk_name');

					
					foreach ($unique_risk_name as $key => $risk_name) {
						if (!empty($risk_name)) {
							
							$condition = array('risk_name' => $risk_name, 'sub_process_id' => $next_sub_process_id);
							// check the risk by risk name and sub process id
							$res_based_risk_name = $this->Audit_model->select_table_Where_data('risk_master', $condition);

							
							if ($res_based_risk_name) {
								// do nothing
							} else {
								$condition = array('sub_process_id' => $next_sub_process_id, 'risk_id' => $work_steps_data[$risk_counter]['risk_id']);

								// check the risk by risk id and sub process id 
								$res_based_risk_id = $this->Audit_model->select_table_Where_data('risk_master', $condition);

								if ($res_based_risk_id) {
									$data_risks = array("risk_name" => $risk_name);
									$condition = array("risk_id" => $res_based_risk_id[0]['risk_id']);
									$this->Audit_model->update_table('risk_master', $condition, $data_risks);
								} else {
									$next_risk_id = $this->Audit_model->getNewIDorNo('r', 'risk_master');
									$tbl_data = array('risk_name' => $risk_name, 'risk_id' => $next_risk_id, 'sub_process_id' => $next_sub_process_id);
									$this->Audit_model->insertData('risk_master', $tbl_data);
								}
							}
						} else {
							$empty_cell_counter++;
							array_push($empty_cell,'risk_name');
							$error=1;
						}
						$risk_counter++;	
					}
				$sub_process_counter++;
				}
			}
			if($error==1){
				$this->session->set_flashdata('success', "Few Fields were empty! But all the data are successfully inserted");
				redirect('MainWebsite/upload_excel');
			}
			else{
				$this->session->set_flashdata('success', "File successfully uploaded");
				redirect('MainWebsite/upload_excel');	
			}	
		} else {
			$this->session->set_flashdata('error', "Please check the header of file");
			redirect('MainWebsite/upload_excel');
		}
	}
	
	private function get_all_unique($data, $column_name)
	{
		$unique_columns = array_unique(array_column($data, $column_name));
		return $unique_columns;
	}
	private function get_data_by_filter($data, $process, $col_name)
	{
		$data = array_filter($data, array(new Filter($col_name, $process), "filter_callback"));
		return $data;
	}
	private function get_data_by_multiple_column_filter($data, $values, $col_names)
	{
		$data = array_filter($data, array(new Filter($col_names, $values), "filter_callback_array"));
		return $data;
	}
	private function excel_data($arr_data)
	{
		$final_data = [];
		foreach ($arr_data as $sheetkey => $value) {
			$header = $arr_data[$sheetkey][1];
			$len = count($arr_data[$sheetkey]);
			$data = [];
			for ($i = 2; $i <= $len; $i++) {
				$ob = [];
				foreach ($header as $key => $value) {
					$ob[$header[$key]] =	isset($arr_data[$sheetkey][$i][$key]) ? $arr_data[$sheetkey][$i][$key] : "";
				}
				$data[] = $ob;
			}
			$final_data[$sheetkey] = $data;
		}
		return $final_data;
	}
}
