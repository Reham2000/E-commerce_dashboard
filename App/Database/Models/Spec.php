<?php
namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;

class Spec extends Model implements Crud
{
  private $id,$name;
  public function create(){

  }
  public function read(){
    $query = "SELECT * FROM specs ";
    return $this->conn->query($query);
  }
  public function update(){

  }
  public function delete(){

  }
}
