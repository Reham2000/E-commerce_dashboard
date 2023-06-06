<?php
namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;

class Region extends Model implements Crud
{
  private $id ,$name_en ,$name_ar ,$status ,$city_id ,$created_at ,$updated_at;
  public function create(){
    $query = "INSERT INTO `regions` (`name_en`, `name_ar`,`city_id`) VALUES (?,?,?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('ssi',$this->name_en,$this->name_ar,$this->city_id);
    return $stmt->execute();
  }
  public function read(){
    $query = "SELECT * FROM `regions`";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->get_result();
  }
  public function update(){
    $query = "UPDATE `regions` SET `name_en` = ? , `name_ar` = ?  ,`city_id` = ? ,`status` = ? WHERE `id`= ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('sssii',$this->name_en,$this->name_ar,$this->city_id,$this->status,$this->id);
    return $stmt->execute();
  }
  public function delete(){
    $query = "DELETE FROM `regions` WHERE `id` = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('i',$this->id);
    return $stmt->execute();
  }
  public function getRegionById()
  {
    $query = "SELECT * FROM `regions` WHERE `id` = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('i',$this->id);
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
   * Get the value of name_en
   */
  public function getName_en()
  {
    return $this->name_en;
  }

  /**
   * Set the value of name_en
   *
   * @return  self
   */
  public function setName_en($name_en)
  {
    $this->name_en = $name_en;

    return $this;
  }

  /**
   * Get the value of name_ar
   */
  public function getName_ar()
  {
    return $this->name_ar;
  }

  /**
   * Set the value of name_ar
   *
   * @return  self
   */
  public function setName_ar($name_ar)
  {
    $this->name_ar = $name_ar;

    return $this;
  }

  /**
   * Get the value of status
   */
  public function getStatus()
  {
    return $this->status;
  }

  /**
   * Set the value of status
   *
   * @return  self
   */
  public function setStatus($status)
  {
    $this->status = $status;

    return $this;
  }

  /**
   * Get the value of created_at
   */
  public function getCreated_at()
  {
    return $this->created_at;
  }

  /**
   * Set the value of created_at
   *
   * @return  self
   */
  public function setCreated_at($created_at)
  {
    $this->created_at = $created_at;

    return $this;
  }

  /**
   * Get the value of updated_at
   */
  public function getUpdated_at()
  {
    return $this->updated_at;
  }

  /**
   * Set the value of updated_at
   *
   * @return  self
   */
  public function setUpdated_at($updated_at)
  {
    $this->updated_at = $updated_at;

    return $this;
  }

  /**
   * Get the value of city_id
   */
  public function getCity_id()
  {
    return $this->city_id;
  }

  /**
   * Set the value of city_id
   *
   * @return  self
   */
  public function setCity_id($city_id)
  {
    $this->city_id = $city_id;

    return $this;
  }
}
