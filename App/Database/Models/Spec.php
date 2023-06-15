<?php
namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;

class Spec extends Model implements Crud
{
  private $id,$name;
  public function create(){
    $query = "INSERT INTO `specs` (`name`) VALUES (?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('s', $this->name);
    return $stmt->execute();
  }
  public function read(){
    $query = "SELECT * FROM specs ";
    return $this->conn->query($query);
  }
  public function update(){

  }
  public function delete(){

  }
  public function getSpecById(){
      $query = "SELECT * FROM specs WHERE id = ?";
      $stmt =  $this->conn->prepare($query);
      $stmt->bind_param('i', $this->id);
      $stmt->execute();
      return $stmt->get_result();
  }
  /**
   * Get the value of id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
   * Get the value of name
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Set the value of name
   *
   * @return  self
   */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }
}
