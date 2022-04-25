<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MatiereModele extends CI_Model
{
    
    /**
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     */
    function getAllMatiere()
    {
        $sql = "select * from matiere";    
        
        $query = $this->db->query($sql);
        $res= $query->result_array();
        return $res;
    }

    function listeAchatAFaire()
    {
        $sql = "select * from achatnec where reste<=seuil";
        $query = $this->db->query($sql);
        $res= $query->result_array();
        return $res;
    }

    function mouvement($idmatiere)
    {
        $sql = "select * from mouve where idmatiere=%s";
        $sql = sprintf($sql,$idmatiere);
        //echo $sql;
        $query = $this->db->query($sql);
        $res= $query->result_array();
        return $res;
    }

    function getreste($idmatiere){
        $sql = "select * from achatnec where id=%s";
        $sql = sprintf($sql,$idmatiere);
        $query = $this->db->query($sql);
        $res= $query->result_array();
        return $res;   
    }

    function somme($liste){
        $entree=0;
        $sortie = 0;
        for($i=0;$i<count($liste);$i++){
            $entree=$entree + $liste[$i]['entree'];
            $sortie=$sortie + $liste[$i]['sortie'];
        }
        $val[0]=$entree;
        $val[1]=$sortie;
        return $val;
    }

    function insertAchat($idmatiere,$quantite,$prix){
        $sql = "call insertAchat(%s,%s,%s)";
        $sql = sprintf($sql,$idmatiere,$quantite,$prix);
        $query = $this->db->query($sql);
        return $query;        
    }

    

    
}

?>