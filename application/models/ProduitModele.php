<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class ProduitModele extends CI_Model
{
    
    /**
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     */
    function getAllProduit()
    {
        $sql = "select * from Produit";    
        
        $query = $this->db->query($sql);
        $res= $query->result_array();
        return $res;
    }

    function verificationQuantite($idProduit,$quantite)
    {
        $sql = "select idmatiere,((%s*pourcentage)/100) as nec, reste from formuleMatiere where idproduit=%s";
        $sql = sprintf($sql,$quantite,$idProduit);
        $query = $this->db->query($sql);
        $res= $query->result_array();
        for ($i=0;$i<count($res);$i++){
            if($res[$i]['nec']>$res[$i]['reste']){
                return null;
            }
        }
        return $res;
    }

    function gererstock($idmatiere, $quantite){
        $sql = "call updatestockmatiere(%s,%s)";
        $sql = sprintf($sql,$idmatiere,$quantite);    
        
        $query = $this->db->query($sql);;
        return $query;
    }


    function insertProduit($idproduit,$quantite){
        $sql = "call insertProduit(%s,%s)";
        $sql = sprintf($sql,$idproduit,$quantite);    
        
        $query = $this->db->query($sql);;
        return $query;      
    }

    function mouvement($idproduit)
    {
        $sql = "select * from mouveProduit where idproduit=%s";
        $sql = sprintf($sql,$idproduit);
        //echo $sql;
        $query = $this->db->query($sql);
        $res= $query->result_array();
        return $res;
    }

    function getreste($idproduit){
        $sql = "select * from Produitreste where idProduit=%s";
        $sql = sprintf($sql,$idproduit);
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
    function insertVente($idproduit,$quantite){
        $sql = "call updatestockProduit(%s,%s)";
        $sql = sprintf($sql,$idproduit,$quantite);    
        
        $query = $this->db->query($sql);;
        return $query;      
    }


    function prediction($idproduit,$quantite){
        $sql = "select (%s*pourcentage)/100 as nec,idmatiere,pourcentage,reste from formulematiere where idProduit=%s order by nec asc";
        $sql = sprintf($sql,$quantite,$idproduit);    
        $query = $this->db->query($sql);
        $res= $query->result_array();
        $fff = 'stock totalement epuise';
        for($i=0;$i<count($res);$i++){
            
            
            $ff= $quantite*$res[$i]['reste']/$res[$i]['nec'];
            if($this->verificationQuantite($idproduit,$ff)!=null){
                $fff = $ff; 
                break;
            }
        }
        return $fff;      
    }

    
}

?>