<?php
namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;

class Subcategory extends Model implements Crud {
    private $id,$name_en,$name_ar,$status,$image,$category_id,$created_at,$updated_at;
    private const ACTIVE = 1;
    private const NOT_ACTIVE = 0;

    public function create(){
      $query = "INSERT INTO `subcategories` ( `name_en`, `name_ar`, `image`, `category_id`) VALUES (?,?,?,?)";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('sssi', $this->name_en, $this->name_ar, $this->image,$this->category_id);
      return $stmt->execute();
    }
    public function read(){
      $query = "SELECT * FROM subcategories ORDER BY `category_id`";
      return $this->conn->query($query);
    }
    public function update(){
      $query = "UPDATE `subcategories` SET `name_en` = ? , `name_ar` = ? ,`image` = ? ,`status` = ?,`category_id` = ? WHERE `id`= ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('ssssii', $this->name_en, $this->name_ar, $this->image, $this->status,$this->category_id, $this->id);
      return $stmt->execute();
    }
    public function delete(){
      $query = "DELETE FROM `subcategories` WHERE `id` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('i', $this->id);
      return $stmt->execute();
    }
    public function updateWithoutImage()
  {
    $query = "UPDATE `subcategories` SET `name_en` = ? , `name_ar` = ? ,`status` = ? ,`category_id` WHERE `id`= ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('sssii', $this->name_en, $this->name_ar, $this->status,$this->category_id, $this->id);
    return $stmt->execute();
  }
    public function getSubcategoryById()
    {
      $query = "SELECT * FROM subcategories WHERE id = ?";
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



    /**
     * Get the value of category_id
     */
    public function getCategory_id()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getSubsByCat()
    {
        $query = "SELECT id,name_en FROM subcategories WHERE status ="
         . self::ACTIVE . " AND category_id = {$this->category_id}";
        return $this->conn->query($query);
    }
    public function getSubcategory()
    {
        $query = "SELECT id FROM subcategories WHERE id = ? AND status = ". self::ACTIVE;
        $stmt =  $this->conn->prepare($query);
        $stmt->bind_param('i',$this->id);
        $stmt->execute();
        return $stmt->get_result();
    }

}
