<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('UtilisateurModel');
        $this->load->library('form_validation');
        $this->load->library('email');
    }
    
    public function index(){
      $this->load->view('login');
    }

    public function loginMe(){
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $email = strtolower($this->security->xss_clean($this->input->post('email')));
            $password = $this->input->post('password');
            
            $result = array();
            $super = $this->input->post('super');

            if($super=='on'){
                $result=$this->UtilisateurModel->Login($email, $password);    

            }else{
                $result=$this->UtilisateurModel->loginUtulisateur($email, $password);          
            }

            if(!empty($result))
            {    
                if($super=='on'){            
                    $sessionArray = array('userId'=>$result->id,                    
                                        'nom'=>$result->nom,
                                        'prenom'=>$result->prenom,
                                        'email'=>$result->email,
                                        'isSuperAdmin'=>TRUE,
                                        'isLoggedIn' => TRUE
                                );

                    $this->session->set_userdata($sessionArray);
                    $this->load->view('acceuil');


                }else{
                    $sessionArray = array('userId'=>$result->id,                    
                                        'nom'=>$result->nom,
                                        'prenom'=>$result->prenom,
                                        'email'=>$result->email,
                                        'isLoggedIn' => TRUE
                                );

                    $this->session->set_userdata($sessionArray);
                    $this->load->view('acceuil');
                }
                
                
            }
            else
            {
                $this->session->set_flashdata('error', 'Email or password mismatch');
                
                $this->index();
            }
        }

    }
    public function inscription(){
        $this->load->view('inscription');   
    }

    public function valider(){
        $id= $this->input->get('id');
        $email = $this->input->get('email');
        
        
        $config['protocol']    = 'smtp';

        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'tramasimiarantsoa@gmail.com';
        $config['smtp_pass']    = '2604tsiky';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'text'; 
        $config['validation'] = TRUE; //bool whether to validate email or not      
        $this->email->initialize($config);
        $this->email->from('tramasimiarantsoa@gmail.com', 'Tsiky');
        $this->email->to($email);
        $this->email->subject('validation Inscription ');
        $message = 'Votre inscription sur le site production laitier a ete accepte';
        $this->email->message($message);  
        $this->email->send();
        echo $this->email->print_debugger();

        $this->UtilisateurModel->updateUtilisateur($id);

        $this->session->set_flashdata('success', 'Un uitilsateur valide');
        $data['avalider'] = $this->UtilisateurModel->listeAvalider();
        $this->load->view('validation',$data);
    }

    public function inscris(){
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        $this->form_validation->set_rules('password1', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', 'Email or PassWord invalid');
            $this->inscription();
        }
        else
        {
            $email = strtolower($this->security->xss_clean($this->input->post('email')));
            $password = $this->input->post('password');
            $password1 = $this->input->post('password1');
            $nom= $this->input->post('nom');
            $prenom = $this->input->post('prenom');
            
            if($password!=$password1){
                $this->session->set_flashdata('error', 'Password mismatch');
                
                $this->inscription();
            }else{
                $data['nom']=$nom;
                $data['prenom']=$prenom;
                $data['email']=$email;
                $data['mdp']=sha1($password);
                $data['estValider']=0;

                $this->UtilisateurModel->insertUtilisateur($data);
                $this->session->set_flashdata('success', 'Veuillez verifier votre email pour validation de l inscription');
                $this->inscription();
            }
        }
    }
    
    public function logout(){
        $this->session->sess_destroy();
        $this->index();
    }

    public function validation(){
        $data['avalider'] = $this->UtilisateurModel->listeAvalider();
        $this->load->view('validation',$data);
    }

}

?>