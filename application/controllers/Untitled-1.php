// function to load work steps according to process
    function choose_services($id = null)
    {
        $id = base64_decode($id);
        $data['client_data'] = $this->MainModel->selectAllFromWhere('client_details', array('client_id' => $id));
        // print_r($data['client_data']);
        // die;
        $data['services'] = $this->MainModel->selectAll('process_master', 'process_description');
        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('template/auditServices', $data);
        $this->load->view('layout/footer');
    }

    // function to show list of all the uploaded files.
    public function viewFiles()
    {
        // $id=$_POST;
        // print_r($id);die;
        $data = $this->MainModel->selectAllWhere('files', array('work_order_id' => $_POST['workid'], 'work_step_id' => $_POST['workstepsid']));
        echo $uploads_file = json_encode($data, true);
    }

    // function to show uploaded work steps file 
    public function worksteps_file()
    {
        $data = $this->MainModel->selectAllWhere('files', array('work_steps_id' => $_POST['workstepsid'], 'client_id' => $_POST['companyid']));
        echo $uploads_file = json_encode($data, true);
    }


    