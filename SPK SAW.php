<?php  /* Nama file = spk_saw.php */ 
class spk_saw{ public $bobot = array(); public $alternatif = array(); public $criteria = array(); public $nilai = array(); public $status = array(); private $normalisasi = array(); private $pembobotan = array();  
// fungsi get 
public function get_bobot($id){ if(array_key_exists($id,$this->bobot)){ return $this->bobot[$id] ; }else{ return 0 ; } } 
public function get_nilai($id_Alternatif,$id_Criteria){ if(array_key_exists($id_Alternatif, $this->nilai) == 1){ if(array_key_exists($id_Criteria, $this->nilai[$id_Alternatif])){ $nilai = $this->nilai[$id_Alternatif][$id_Criteria]; } } return $nilai ; } 
public function get_status($id){ if(array_key_exists($id, $this-> status)) return $this->status[$id]; }  //fungsi set

 
public function set_status($status = array()){ $this->status = $status; return $this; } 
public function set_nilai($nilai = array()){ $this->nilai = $nilai; return $this; } 
public function set_bobot($value = array()){ $this->bobot = $value; return $this; } 
public function set_alternatif($alternatif = array()){ $this->alternatif = $alternatif; return $this; } 
public function set_criteria ($criteria = array()){ $this->criteria = $criteria; return $this; }  
//-----------------------------------------------------------------------------------------------------------get min 
public function get_min($key_kriteria){ $array = $this->list_nilai_Colom_Criteria($key_kriteria); if(!is_array($array)){ return 0; } foreach($array as $key=>$value){ if($key_kriteria == $key){ if(is_array($value) == 1){ return min($value); } } } }  
//------------------------------------------------------------------------------------------------------get max 
public function get_max($key_kriteria){ $array = $this->list_nilai_Colom_Criteria($key_kriteria); if(!is_array($array)){ return 0; }
foreach($array as $key=>$value){ if($key_kriteria == $key){ if(is_array($value) == 1){ return max($value); } } } }  //----------------------------------------------------------------------------------------------- fungsi nilai criteria 
private function list_nilai_Colom_Criteria($key_kriteria){ foreach ($this->nilai as $id_alternatif=>$array_criteria){ foreach($array_criteria as $id_criteria=>$nilai){ if($key_kriteria == $id_criteria){ $datanilai[$id_criteria][] = $nilai; } } } return $datanilai; }  
//----------------------------------------------------------------------------------------------menampilkan normalisasi 
public function pembobotan(){ if(count($this->normalisasi) != 0 ){ foreach ($this->normalisasi as $idAlternatif=>$arrayCriteria){ $data_[$idAlternatif] = 0; foreach ($arrayCriteria as $idCriteria=>$nilai){ $data_[$idAlternatif] += $nilai*$this->get_bobot($idCriteria) ; } } $this->pembobotan = $data_; } return $this; }  
//--------------------------------------------------------------------------------------------------------- funsi normalisasi

 
public function normalisasi(){ if(is_array($this->alternatif) && is_array($this->criteria)){ foreach($this->alternatif as $key_alternatif=>$value_alternatif){ foreach($this->criteria as $key_criteria=>$value_criteria){  
//jika status kriteria = cost 
if ($this->get_status($key_criteria) == 0) { $nilai[$key_alternatif][$key_criteria] = $this->get_nilai($key_alternatif,$key_criteria)?$this->get_min($key_criteria)/$this->get_nilai($key_alternatif,$key_criteria) : 0; }else{ $nilai[$key_alternatif][$key_criteria] = $this->get_nilai($key_alternatif,$key_criteria)?$this->get_nilai($key_alternatif,$key_criteria)/$this->get_max($key_criteria) : 0; } } } } $this->normalisasi = $nilai; return $this; }  //---------------------------------------------------------------------------------------------------------------get_normalisasi 



public function get_normalisasi(){ $html = ''; foreach($this->normalisasi()->normalisasi as $idAlternatif=>$arrayCriteria){ $html .= '<tr>'; foreach($arrayCriteria as $idCriteria=>$nilai){ $html .= '<td>'.$nilai.'</td>'; } $html .= '</tr>'; } return '<table border=1>'.$html.'</table>'; }  
//-------------------------------------------------------------------------------------------------------------------fungsi ranking 
public function ranking(){ $html = ''; foreach ($this->pembobotan as $idAlternatif=>$nilaiakhir){ $final_data[$idAlternatif] = $nilaiakhir; }

} 


 //----------------------------------------------------------------------------------------------------------------Code End spk_saw.php 
 //Include ("spk_saw.php");  
 // Cara Pemanggilan Program  //set Alternatif list 
 $alternatif = array(1=>"Alternatif 01", 2=> "Alternatif 02",3=> "Alternatif 03", 4=> "Alternatif 04");  
 //Set Kriteria list 
 $criteria = array(1=>"Criteria 1", 2=>"Criteria 1",3=>"Criteria 1", 4=>"Criteria 1",5=>"Criteria 1");  
 //Set Status Setiap Kriteria 0 = Cost dan 1 = benafit 
 $status = array( 1=> 0, 2=> 1, 3=> 1, 4=> 0, 5=> 1);  //Set Bobot Setiap Kriteria syarat bobot total = 1 or 100 
 $bobot = array(1=>0.25, 2=>0.15,3=>0.30, 4=>0.25,5=>0.05);  //Set Nilai Kriteria dari Setiap Alternatif 
 $nilai = array( 1=>array(1=>150,2=> 15,3=> 2, 4=> 2,5=> 3), 2=>array(1=> 500, 2=> 200,3=> 2, 4=> 3,5=> 2,) , 3=>array(1=> 200, 2=> 10,3=> 3, 4=> 1,5=> 3, ), 4=>array(1=> 350, 2=> 100,3=> 3, 4=> 1,5=> 2, )); 
 $saw = new spk_saw(); 
 // panggil class spk_saw

 
echo $saw->set_alternatif($alternatif)->set_criteria($criteria)->set_status($status)->set_bobot($bobot)->set_nilai($nilai)->get_nilai_real(); 
echo $saw->set_alternatif($alternatif) ->set_criteria($criteria)->set_status($status)->set_bobot($bobot)->set_nilai($nilai)->get_normalisasi(); 
echo $saw->set_alternatif($alternatif)->set_criteria($criteria)->set_status($status)->set_bobot($bobot)->set_nilai($nilai)->normalisasi()->pembobotan()->ranking(); 


?>


