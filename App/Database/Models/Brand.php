<?php
namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;

class Brand extends Model implements Crud {
    private $id,$name_en,$name_ar,$status,$image,$created_at,$updated_at;
    private const ACTIVE = 1;
    private const NOT_ACTIVE = 0;

    public function create(){
      $query = "INSERT INTO `brands` (`name_en`, `name_ar`, `image`) VALUES (?,?,?)";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('sss', $this->name_en, $this->name_ar, $this->image);
      return $stmt->execute();
    }
    public function read(){
        $query = "SELECT * FROM brands ";
        return $this->conn->query($query);
    }
    public function update(){
      $query = "UPDATE `brands` SET `name_en` = ? , `name_ar` = ? ,`image` = ? ,`status` = ? WHERE `id`= ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('ssssi', $this->name_en, $this->name_ar, $this->image, $this->status, $this->id);
      return $stmt->execute();
    }
    public function delete(){
      $query = "DELETE FROM `brands` WHERE `id` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('i', $this->id);
      return $stmt->execute();
    }
    public function updateWithoutImage()
  {
    $query = "UPDATE `brands` SET `name_en` = ? , `name_ar` = ? ,`status` = ? WHERE `id`= ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('sssi', $this->name_en, $this->name_ar, $this->status, $this->id);
    return $stmt->execute();
  }
    public function getBrandById(){
      $query = "SELECT * FROM brands WHERE id = ?";
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
    public function getBrand()
    {
        $query = "SELECT id FROM brands WHERE id = ? AND status = ". self::ACTIVE;
        $stmt =  $this->conn->prepare($query);
        $stmt->bind_param('i',$this->id);
        $stmt->execute();
        return $stmt->get_result();
    }



}
