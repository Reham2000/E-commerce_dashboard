<?php
namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;

class Region extends Model implements Crud
{
  public function create(){
    $query = "SELECT * FROM `regions`";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->get_result();
  }
  public function read(){

  }
  public function update(){

  }
  public function delete(){

  }
}
