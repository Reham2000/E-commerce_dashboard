<?php
namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;

class Seller extends Model implements Crud
{
  private $id, $name, $description, $logo, $phone, $email, $password, $status, $address_id, $created_at, $updated_at;
  public function create(){

  }
  public function read(){
    $query = "SELECT * FROM `sellers`";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->get_result();
  }
  public function update(){
    $query = "UPDATE `sellers` SET `name` = ? , `description` = ? , `logo` = ?, `phone` = ?, `email` = ? , `password` = ? ,`status` = ?, `address_id` = ?   WHERE `id`= ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('ssssssssi',$this->name,$this->description,$this->logo,$this->phone,$this->email,$this->password,$this->status,$this->address_id,$this->id);
    return $stmt->execute();
  }
  public function updateWithoutPassword(){
    $query = "UPDATE `sellers` SET `name` = ? , `description` = ? , `logo` = ?, `phone` = ?, `email` = ? , `status` = ?, `address_id` = ?   WHERE `id`= ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('ssssssssi',$this->name,$this->description,$this->logo,$this->phone,$this->email,$this->status,$this->address_id,$this->id);
    return $stmt->execute();
  }
  public function delete(){
    $query = "DELETE FROM `sellers` WHERE `id` = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('i',$this->id);
    return $stmt->execute();
  }
  public function getSellerById()
  {
    $query = "SELECT * FROM `sellers` WHERE `id` = ?";
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

  /**
   * Get the value of description
   */
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Set the value of description
   *
   * @return  self
   */
  public function setDescription($description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get the value of logo
   */
  public function getLogo()
  {
    return $this->logo;
  }

  /**
   * Set the value of logo
   *
   * @return  self
   */
  public function setLogo($logo)
  {
    $this->logo = $logo;

    return $this;
  }

  /**
   * Get the value of phone
   */
  public function getPhone()
  {
    return $this->phone;
  }

  /**
   * Set the value of phone
   *
   * @return  self
   */
  public function setPhone($phone)
  {
    $this->phone = $phone;

    return $this;
  }

  /**
   * Get the value of email
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set the value of email
   *
   * @return  self
   */
  public function setEmail($email)
  {
    $this->email = $email;

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
   * Get the value of address_id
   */
  public function getAddress_id()
  {
    return $this->address_id;
  }

  /**
   * Set the value of address_id
   *
   * @return  self
   */
  public function setAddress_id($address_id)
  {
    $this->address_id = $address_id;

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
   * Get the value of password
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set the value of password
   *
   * @return  self
   */
  public function setPassword($password)
  {
    $this->password = password_hash($password, PASSWORD_BCRYPT);

    return $this;
  }
}
