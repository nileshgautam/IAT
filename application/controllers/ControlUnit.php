<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ControlUnit extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata"); //Set server date an time to Asia
		if (!isset($_SESSION['userInfo'])) {
			$this->session->sess_destroy();
			redirect('Login/index');
		}
	}
	public function index()
	{
		//$this->load->view('pages/login');

		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('dashboard');
		$this->load->view('layout/footer');
	}

	public function dashboard()
	{
		$data['clients']=$this->MainModel->count('client_details');
		$data['users']=$this->MainModel->count('users');
		$data['workorders']=$this->MainModel->count('work_order');
		$data['allclients']=$this->MainModel->selectAll('client_details');
		$data['workOrder']=$this->MainModel->selectAllworkOrder();
		$data['Users']=$this->MainModel->selectAll('users');
		// print_r($data);die;
		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('dashboard', $data);
		$this->load->view('layout/footer');
	}

	public function newClientPage()
	{
		$data['country'] = $this->MainModel->selectAll('countries', 'name');
		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('pages/new-client', $data);
		$this->load->view('layout/footer');
	}

	// function to load company 
	public function newUsersPage()
	{
		$data['country'] = $this->MainModel->selectAll('countries', 'name');
		$data['role'] = $this->MainModel->selectAll('roles', 'role');
		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('pages/new-user', $data);
		$this->load->view('layout/footer');
	}
	// function to load user table from database
	public function allUsers()
	{
		$data['users'] = $this->MainModel->selectAll('users', 'first_name');
		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('template/usertab', $data);
		$this->load->view('layout/footer');
	}
	public function allClients()
	{
		$data['clients'] = $this->MainModel->selectAll('client_details', 'client_name');
		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('template/all-clients', $data);
		$this->load->view('layout/footer');
	}

	public function managerallClients()
	{
		$data['clients'] = $this->MainModel->selectAll('client_details', 'client_name');
		$this->load->view('layout/header');
		$this->load->view('manager/manager-sidebar');
		$this->load->view('pages/all-clients-manager', $data);
		$this->load->view('layout/footer');
	}

	// team dashboard will apear after login
	public function teamDashboard()
	{
		$data['workorder'] = $this->MainModel->getallworkorder($_SESSION['userInfo']['id']);
		$this->load->view('layout/header');
		$this->load->view('team/team-sidebar', $data);
		$this->load->view('team/team-dashboard');
		$this->load->view('layout/footer');
	}

	// Manager dashboard
	public function manager()
	{
		$data['workOrder'] = $this->MainModel->getallworkorder($_SESSION['userInfo']['id']);
		$this->load->view('layout/header');
		$this->load->view('manager/manager-sidebar', $data);
		$this->load->view('manager/manager-dashboard');
		$this->load->view('layout/footer');
	}



	public function managerAllWorkOrder()
	{
		$data['worksOrders'] = $this->MainModel->selectAll('work_order', 'client_id');
		$this->load->view('layout/header');
		$this->load->view('manager/manager-sidebar');
		$this->load->view('pages/manager-work-orders', $data);
		$this->load->view('layout/footer');
	}

	public function newWorkOrder($clientid = null)
	{
		$data['clients'] = $this->MainModel->selectAll('client_details', 'client_name');
		$data['clientid'] = $clientid;
		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('pages/new-work-order', $data);
		$this->load->view('layout/footer');
	}

	public function allWorkOrder()
	{
		// $data['workOrder']=$this->MainModel->selectAllworkOrder();
		// $data['worksOrders'] = $this->MainModel->selectAll('work_order', 'client_id');
		$data['worksOrders'] = $this->MainModel->selectAllworkOrder();
		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('pages/all-workorder', $data);
		$this->load->view('layout/footer');
	}

}
