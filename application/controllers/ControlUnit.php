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
	// admin dashboard
	public function dashboard()
	{
		$data['allclients'] = $this->MainModel->selectAll('client_details');
		$data['workOrder'] = $this->MainModel->selectAllworkOrder();
		$data['Users'] = $this->MainModel->getallusers();
		// print_r($data);die;
		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('layout/dashboard', $data);
		$this->load->view('layout/footer');
	}
	// function to create new Client view
	public function newClientPage()
	{
		$data['country'] = $this->MainModel->selectAll('countries', 'name');
		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('pages/new-client', $data);
		$this->load->view('layout/footer');
	}

	// function to creatge new users
	public function newUsersPage()
	{
		$data['country'] = $this->MainModel->selectAll('countries', 'name');
		$data['role'] = $this->MainModel->selectAll('roles', 'role');
		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('pages/new-user', $data);
		$this->load->view('layout/footer');
	}
	// function to show list of all the existing user from database
	public function allUsers()
	{
		$data['users'] = $this->MainModel->selectAll('users', 'first_name');
		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('template/all-users', $data);
		$this->load->view('layout/footer');
	}
	// function to show list of all the existing clients from database
	public function allClients()
	{
		$data['clients'] = $this->MainModel->selectAll('client_details', 'client_name');
		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('template/all-clients', $data);
		$this->load->view('layout/footer');
	}


	// team dashboard will apear after loggedin 
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

		// $data['workOrder'] = $this->MainModel->CompleteWorkorder();
		$data['workOrders'] = $this->MainModel->selectAllworkOrder();
		// $data['completeSteps'] = $this->MainModel->CompleteWorkstepsByworkorders();
		$this->load->view('layout/header');
		$this->load->view('manager/manager-sidebar');
		$this->load->view('manager/manager-dashboard', $data);
		$this->load->view('layout/footer');
	}
	// function to show list of all the existing clients from database to the manager menus
	// public function managerallClients()
	// {
	// 	$data['clients'] = $this->MainModel->selectAll('client_details', 'client_name');
	// 	$this->load->view('layout/header');
	// 	$this->load->view('manager/manager-sidebar');
	// 	$this->load->view('pages/all-clients-manager', $data);
	// 	$this->load->view('layout/footer');
	// }
	// function to show list of all the workorders, on manager screen
	public function managerAllWorkOrder()
	{
		// $data['worksOrders'] = $this->MainModel->selectAll('work_order', 'client_id');
		$data['workOrder'] = $this->MainModel->getallworkorder($_SESSION['userInfo']['id']);
		$data['workOrders'] = $this->MainModel->selectAllworkOrder();
		$this->load->view('layout/header');
		$this->load->view('manager/manager-sidebar');
		$this->load->view('pages/manager-work-orders', $data);
		$this->load->view('layout/footer');
	}
	// Function to create new workorder
	public function newWorkOrder($clientid = null)
	{
		$data['clients'] = $this->MainModel->selectAll('client_details', 'client_name');
		$data['clientid'] = $clientid;
		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('pages/new-work-order', $data);
		$this->load->view('layout/footer');
	}
// function to show list of all the workorder on admin menus
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
