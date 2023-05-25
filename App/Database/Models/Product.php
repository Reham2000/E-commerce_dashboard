<?php
namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;

class Product extends Model implements Crud {
    private $id,$name_en,$name_ar,$price,$quantity,$status,$image
    ,$code,$details_ar,$detials_en,$brand_id,$subcategory_id,$category_id,$created_at,$updated_at,$user_id,$rate,$comment;
    private const ACTIVE = 1;
    private const NOT_ACTIVE = 0;
    public function create()
    {
        # code...
    }
    public function read()
    {
        $query = "SELECT id,name_en,price,image,details_en FROM products
        WHERE status = " . self::ACTIVE;
        return $this->conn->query($query);
    }
    public function update()
    {
        # code...
    }
    public function delete()
    {
        # code...
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
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

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
     * Get the value of details_ar
     */ 
    public function getDetails_ar()
    {
        return $this->details_ar;
    }

    /**
     * Set the value of details_ar
     *
     * @return  self
     */ 
    public function setDetails_ar($details_ar)
    {
        $this->details_ar = $details_ar;

        return $this;
    }

    /**
     * Get the value of detials_en
     */ 
    public function getDetials_en()
    {
        return $this->detials_en;
    }

    /**
     * Set the value of detials_en
     *
     * @return  self
     */ 
    public function setDetials_en($detials_en)
    {
        $this->detials_en = $detials_en;

        return $this;
    }

    /**
     * Get the value of brand_id
     */ 
    public function getBrand_id()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @return  self
     */ 
    public function setBrand_id($brand_id)
    {
        $this->brand_id = $brand_id;

        return $this;
    }

    /**
     * Get the value of subcategory_id
     */ 
    public function getSubcategory_id()
    {
        return $this->subcategory_id;
    }

    /**
     * Set the value of subcategory_id
     *
     * @return  self
     */ 
    public function setSubcategory_id($subcategory_id)
    {
        $this->subcategory_id = $subcategory_id;

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

    public function getProduct()
    {
        $query =  "SELECT * FROM product_data 
        WHERE status = " . self::ACTIVE . " AND id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i',$this->id);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getProductReview()
    {
        $query =  "SELECT * FROM product_review 
        WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        echo $this->conn->error;
        $stmt->bind_param('i',$this->id);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getAllProductsReview()
    {
        $query =  "SELECT * FROM product_review";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getProductById()
    {
        $query = "SELECT * FROM `product_data` WHERE status = ".self::ACTIVE." AND id =?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i',$this->id);
        $stmt->execute();
        return $stmt->get_result();
    }


    public function getProductsByBrandId()
    {
        $query =  "SELECT id,name_en,price,image,details_en FROM product_details 
        WHERE status = " . self::ACTIVE . " AND brand_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i',$this->brand_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getProductsByCategoryId()
    {
        $query =  "SELECT id,name_en,price,image,details_en FROM product_details 
        WHERE status = " . self::ACTIVE . " AND category_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i',$this->category_id);
        $stmt->execute();
        return $stmt->get_result();
    }
    

    public function getProductsBySubcategoryId()
    {
        $query =  "SELECT id,name_en,price,image,details_en FROM product_details 
        WHERE status = " . self::ACTIVE . " AND subcategory_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i',$this->subcategory_id);
        $stmt->execute();
        return $stmt->get_result();
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
    public function getLatestProducts()
    {
        $query = "SELECT
        id,
        name_en,
        price,
        image,
        details_en
    FROM
        products
    WHERE
    STATUS
        = ".self::ACTIVE." ORDER BY created_at
    DESC LIMIT 4";
        return $this->conn->query($query);
    }
    public function getBestSellerProduct()
    {
        $query = "SELECT
        products.id,
        products.name_en,
        products.price,
        products.image,
        products.details_en,
        sum(orders_products.quentity) as `quentity`
    FROM
        products
        JOIN orders_products
        ON
        products.id = orders_products.product_id
    WHERE
    STATUS =". self::ACTIVE ."
    GROUP BY products.id
    ORDER BY quentity DESC LIMIT 4";
        return $this->conn->query($query);
    }

    
    public function allReviews()
    {
        $query = "SELECT
                    `reviews`.*,
                    CONCAT(`users`.`first_name` , ' ' , `users`.`last_name`) AS `full_name`
                FROM
                    `reviews`
                JOIN `users`
                ON `users`.`id` = `reviews`.`user_id`
                WHERE
                    `product_id` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i',$this->id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function addReview(){
        $query="INSERT INTO `reviews`(`product_id`, `user_id`, `rate`, `comment`) VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss",$this->id,$this->user_id,$this->rate,
            $this->comment);
        return $stmt->execute();
    }

    /**
     * Get the value of user_id
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of rate
     */ 
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of rate
     *
     * @return  self
     */ 
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get the value of comment
     */ 
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of comment
     *
     * @return  self
     */ 
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }
}