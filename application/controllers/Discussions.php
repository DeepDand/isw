<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Discussions extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('string');
        $this->load->library('encrypt');
        $this->load->model('discussions_model');
        $this->load->library('form_validation');
        $this->lang->load('en_admin_lang');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    }

    public function index() {
        if ($this->uri->segment(3)) {
            $filter = $this->uri->segment(4);
            $direction = $this->uri->segment(5);
            $page_data['dir'] = $this->uri->segment(5);
        } else {
            $filter = null;
            $direction = null;
            $page_data['dir'] = 'ASC';
        }
        $this->load->model('Discussions_model');
        $page_data['query'] = $this->Discussions_model->fetch_discussions($filter,$direction);

        $this->load->view('common/login_header');
        $this->load->view('nav/top_nav');
        $this->load->view('discussions/view', $page_data);
        $this->load->view('common/footer');
    }

    public function create() {
        $this->form_validation->set_rules('usr_name', $this->lang->line('discussion_usr_name'), 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('usr_email', $this->lang->line('discussion_usr_email'), 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('ds_title', $this->lang->line('discussion_ds_title'), 'required|min_length[1]|max_length[255]');
        $this->form_validation->set_rules('ds_body', $this->lang->line('discussion_ds_body'), 'required|min_length[1]|max_length[5000]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('common/login_header');
            $this->load->view('nav/top_nav');
            $this->load->view('discussions/newd');
            $this->load->view('common/footer');
        } else {
            $data = array('usr_name' => $this->input->post('usr_name'),
                          'usr_email' => $this->input->post('usr_email'),
                          'ds_title' => $this->input->post('ds_title'),
                          'ds_body' =>  $this->input->post('ds_body')
                          );
            if ($ds_id = $this->Discussions_model->create($data)) {
              echo $ds_id;
              //redirect('comments/index/'.$ds_id);
            } else {
                // error
                // load view and flash sess error
                $this->load->view('errors/error_exception');
              }
            }
          }


    public function flag() {
        $ds_id = $this->uri->segment(3);
        if ($this->Discussions_model->flag($ds_id)) {
            redirect('discussions/');
        } else {
            // error
            // load view and flash sess error
            $this->load->view('errors/error_exception');
          }
      $data = array('usr_name' => $this->input->post('usr_name'),
              'usr_email' => $this->input->post('usr_email'),
              'ds_title' => $this->input->post('ds_title'),
              'ds_body' =>  $this->input->post('ds_body'));
              if ($ds_id = $this->Discussions_model->create($data)) {
                redirect('comments/index/'.$ds_id);
              } else {
                // ADD CODE HERE TO HANDLE THIS - NO PRIMARY KEY FOUND FOR THE unregister_tick_function          ...
                $this->load->view('errors/error_exception');
              }
            }

    public function open_login() {
      $this->load->view('common/login_header');
      $this->load->view('nav/top_nav');
      $this->load->view('admin/login');
      $this->load->view('common/footer');
    }
}

?>
