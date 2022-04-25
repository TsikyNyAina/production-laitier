<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Produit extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('ProduitModele');
    }
    
    public function index(){
        $data['produits'] = $this->ProduitModele->getAllProduit();
        $this->load->view('ajoutProduit',$data);
    }
    
    public function insertProduit(){
        $idproduit=$this->input->get('produit');
        $quantite=$this->input->get('quantite');
        //Verification stock

        $verif = $this->ProduitModele->verificationQuantite($idproduit,$quantite);

        if($verif==NULL){
            $pre = $this->ProduitModele->prediction($idproduit,$quantite);
            
            
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('error', 'Matiere premiere non suffisant');        
            if(is_numeric($pre)){
                $this->session->set_flashdata('quantite', 'Essayer avec'.$pre);
            }
            else{
                $this->session->set_flashdata('quantite', $pre);
            }
            
            $this->index();
        }else{
            //insertion stockproduit  //insertion mvtstockproduit
            
            $this->ProduitModele->insertProduit($idproduit,$quantite);

            
            //update stockmatiere
            //insertion mvtstockmatiere
            for($i=0;$i<count($verif);$i++){
                $this->ProduitModele->gererstock($verif[$i]['idmatiere'],$verif[$i]['nec']);
            }
            $this->session->unset_userdata('error');

            $this->session->set_flashdata('success', 'Produit inserer');     
            $this->index();

        }

    }    

    public function mouvement(){
        $data['produits'] = $this->ProduitModele->getAllProduit();
        $idproduit=$this->input->get('idproduit');
        $data['stock']=array();
        if($idproduit!=null){
            $data['stock'] = $this->ProduitModele->mouvement($idproduit);   
            $data['matiere'] = $this->ProduitModele->getreste($idproduit);
            $data['total'] = $this->ProduitModele->somme($data['stock']);
        }
        
        $this->load->view('etatStockProduit',$data);
    }

    public function insertVente(){
        $data['produits'] = $this->ProduitModele->getAllProduit();
        $this->load->view('vente',$data);
    }

    public function insertionVente(){
        $idproduit = $this->input->get('produit');
        $quantite = $this->input->get('quantite');

        $this->ProduitModele->insertVente($idproduit,$quantite);

        $this->session->unset_userdata('error');

            $this->session->set_flashdata('success', 'Produit inserer'); 

        $this->insertVente();
    }
    
}

?>