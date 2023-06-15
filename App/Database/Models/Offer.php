<?php

namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;


class Offer extends Model implements Crud
{
    private $id,$title,$image,$discount,$discount_type,$start_at,$end_at,$created_at,$updated_at;
    public function create(){
      $query = "INSERT INTO `offers` ( `title`, `image`, `discount`, `discount_type`, `start_at`, `end_at`) VALUES (?,?,?,?,?,?)";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('ssssss', $this->title, $this->image, $this->discount,$this->discount_type, $this->start_at, $this->end_at);
      return $stmt->execute();
    }
    public function read(){
      $query = "SELECT * FROM offers ";
      return $this->conn->query($query);
    }
    public function update(){
      $query = "UPDATE `offers` SET `title` = ?, `image` = ?, `discount` = ?, `discount_type` = ?, `start_at` = ?, `end_at` = ? WHERE `id`= ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('ssssssi', $this->title, $this->image, $this->discount, $this->discount_type, $this->start_at, $this->end_at, $this->id);
      return $stmt->execute();
    }
    public function delete(){
      $query = "DELETE FROM `offers` WHERE `id` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('i', $this->id);
      return $stmt->execute();
    }
    public function updateWithoutImage()
    {
      $query = "UPDATE `offers` SET `title` = ? , `discount` = ? ,`discount_type` = ?, `start_at` = ?, `end_at` = ? WHERE `id`= ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('sssssi', $this->title, $this->discount, $this->discount_type, $this->start_at, $this->end_at, $this->id);
      return $stmt->execute();
    }
    public function getOfferById(){
      $query = "SELECT * FROM offers WHERE id = ?";
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
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */
    public function setImage($image)
    {
        $this->image = $image;

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
