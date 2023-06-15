<?php
namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;

class Coupon extends Model implements Crud
{
  public function create(){

  }
  public function read(){
    $query = "SELECT * FROM `coupons`";
    return $this->conn->query($query);
  }
  public function update(){

  }
  public function delete(){

  }
}
