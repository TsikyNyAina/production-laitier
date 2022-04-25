<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class UtilisateurModel extends CI_Model
{
    
    /**
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     */
    function loginUtulisateur($email, $password)
    {
        $this->db->select('id,nom,prenom,email,mdp');
        $this->db->from('utilisateur');
        $this->db->where('email', $email);
        $this->db->where('mdp', sha1($password));
        $this->db->where('estValider', 1);
        $query = $this->db->get();
        
        $user = $query->row();
        
        if(!empty($user)){
            return $user;
        } else {
            return array();
        }
    }
    function Login($email, $password)
    {
        $this->db->select('id,nom,prenom,email,mdp');
        $this->db->from('superAdmin');
        $this->db->where('email', $email);
        $this->db->where('mdp', sha1($password));
        $query = $this->db->get();
        
        $user = $query->row();
        
        if(!empty($user)){
            return $user;
        } else {
            return array();
        }
    }

    function listeAvalider()
    {
        $sql = "select * from utilisateur where estValider=0";    
        
        $query = $this->db->query($sql);
        $res= $query->result_array();
        return $res;
    }

    function insertUtilisateur($data)
    {
        $this->db->insert('utilisateur',$data);
        
        return true;
    }

    function updateUtilisateur($id)
    {
        
        $this->db->set('estValider',1);
        $this->db->where('id',$id);
        $this->db->update('utilisateur');
        return true;
    }
}

?>