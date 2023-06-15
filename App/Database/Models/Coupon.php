<?php
namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;

class Coupon extends Model implements Crud
{
  private $id, $code, $discount, $discount_type, $max_discount_value, $max_useage, $max_useage_per_user, $mini_order, $start_at, $end_at, $created_at, $updated_at;
  public function create(){
    $query = "INSERT INTO `coupons` ( `code`, `discount`, `discount_type`, `max_discount_value`, `max_useage`, `max_useage_per_user`, `mini_order`, `start_at`, `end_at`) VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('sssssssss', $this->code, $this->discount,$this->discount_type, $this->max_discount_value, $this->max_useage, $this->max_useage_per_user, $this->mini_order, $this->start_at, $this->end_at);
    return $stmt->execute();
  }
  public function read(){
    $query = "SELECT * FROM `coupons`";
    return $this->conn->query($query);
  }
  public function update(){
    $query = "UPDATE `coupons` SET `code` = ? ,`discount` = ? ,`discount_type` = ? ,`max_discount_value` = ? ,`max_useage` = ? ,`max_useage_per_user` = ? ,`mini_order` = ? ,`start_at` = ? ,`end_at` = ?  WHERE `id`= ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('sssssssssi', $this->code, $this->discount, $this->discount_type, $this->max_discount_value, $this->max_useage,$this->max_useage_per_user, $this->mini_order, $this->start_at, $this->end_at, $this->id);
    return $stmt->execute();
  }
  public function delete(){

  }
  public function getCouponById(){
    $query = "SELECT * FROM coupons WHERE id = ?";
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
   * Get the value of code
   */
  public function getCode()
  {
    return $this->code;
  }

  /**
   * Set the value of code
   *
   * @return  self
   */
  public function setCode($code)
  {
    $this->code = $code;

    return $this;
  }

  /**
   * Get the value of discount
   */
  public function getDiscount()
  {
    return $this->discount;
  }

  /**
   * Set the value of discount
   *
   * @return  self
   */
  public function setDiscount($discount)
  {
    $this->discount = $discount;

    return $this;
  }

  /**
   * Get the value of discount_type
   */
  public function getDiscount_type()
  {
    return $this->discount_type;
  }

  /**
   * Set the value of discount_type
   *
   * @return  self
   */
  public function setDiscount_type($discount_type)
  {
    $this->discount_type = $discount_type;

    return $this;
  }

  /**
   * Get the value of max_discount_value
   */
  public function getMax_discount_value()
  {
    return $this->max_discount_value;
  }

  /**
   * Set the value of max_discount_value
   *
   * @return  self
   */
  public function setMax_discount_value($max_discount_value)
  {
    $this->max_discount_value = $max_discount_value;

    return $this;
  }

  /**
   * Get the value of max_useage
   */
  public function getMax_useage()
  {
    return $this->max_useage;
  }

  /**
   * Set the value of max_useage
   *
   * @return  self
   */
  public function setMax_useage($max_useage)
  {
    $this->max_useage = $max_useage;

    return $this;
  }

  /**
   * Get the value of max_useage_per_user
   */
  public function getMax_useage_per_user()
  {
    return $this->max_useage_per_user;
  }

  /**
   * Set the value of max_useage_per_user
   *
   * @return  self
   */
  public function setMax_useage_per_user($max_useage_per_user)
  {
    $this->max_useage_per_user = $max_useage_per_user;

    return $this;
  }

  /**
   * Get the value of mini_order
   */
  public function getMini_order()
  {
    return $this->mini_order;
  }

  /**
   * Set the value of mini_order
   *
   * @return  self
   */
  public function setMini_order($mini_order)
  {
    $this->mini_order = $mini_order;

    return $this;
  }

  /**
   * Get the value of start_at
   */
  public function getStart_at()
  {
    return $this->start_at;
  }

  /**
   * Set the value of start_at
   *
   * @return  self
   */
  public function setStart_at($start_at)
  {
    $this->start_at = $start_at;

    return $this;
  }

  /**
   * Get the value of end_at
   */
  public function getEnd_at()
  {
    return $this->end_at;
  }

  /**
   * Set the value of end_at
   *
   * @return  self
   */
  public function setEnd_at($end_at)
  {
    $this->end_at = $end_at;

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
}
