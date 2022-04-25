<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Matiere extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('MatiereModele');
    }
    
    public function index(){
        $data['matieres'] = $this->MatiereModele->getAllMatiere();
        $this->load->view('achatMatiere',$data);
    }
    
    public function insertAchat(){
        $idmatiere=$this->input->get('matiere');
        $quantite=$this->input->get('quantite');
        $prixAchat=$this->input->get('prix');



        $this->MatiereModele->insertAchat($idmatiere,$quantite,$prixAchat);
        $this->session->set_flashdata('success', 'Achat Insere');        
        $this->index();
    }    

    public function listeAchatNec(){
        $data['achatnec'] = $this->MatiereModele->listeAchatAFaire();
        $this->load->view('achatNec',$data);
    }

    public function mouvement(){
        $data['matieres'] = $this->MatiereModele->getAllMatiere();
        $idmatiere=$this->input->get('idmatiere');
        $data['stock']=array();
        if($idmatiere!=null){
            $data['stock'] = $this->MatiereModele->mouvement($idmatiere);   
            $data['matiere'] = $this->MatiereModele->getreste($idmatiere);
            $data['total'] = $this->MatiereModele->somme($data['stock']);
        }
        
        $this->load->view('etatStock',$data);
    }

    function actionToExcel(){
        $this->load->library("excel");
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);

        $table_columns = array("Id","nomMatiere","seuil","reste","unite");

        $column = 0;

        foreach($table_columns as $field)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column,1,$field);
            $column++;
        }

        $excel_row =2 ;
        $data = $this->MatiereModele->listeAchatAFaire();

        for($i=0;$i<count($data);$i++){
            $object->getActiveSheet()->setCellValueByColumnAndRow(0,$excel_row,$data[$i]['id']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1,$excel_row,$data[$i]['nomMatiere']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2,$excel_row,$data[$i]['seuil']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3,$excel_row,$data[$i]['reste']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4,$excel_row,"kg");
            $excel_row++;

        }

        $object_writer = PHPExcel_IOFactory::createWriter($object,'Excel5');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="AchatNecessaire.xls"');
        $object_writer->save('php://Output');

    }
}

?>