<?php
function get_json(){
$json = file_get_contents('service.json');
$data = json_decode($json, true);
return $data;
}
  $type = (isset($_GET['type'])) ? $_GET['type'] : "";
  $value = (isset($_POST['value'])) ? $_POST['value'] : ""; //value posted
  $id = (isset($_POST['id'])) ? $_POST['id'] : ""; //id of the element
  $id = explode("_",$id);

$data=get_json();
$data[$id[0]][$id[1]]=$value;
$item = json_encode($data);
file_put_contents('service.json', $item);
?>
