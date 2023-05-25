<?php

namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;


class Product_review extends Model implements Crud 
{
    private $product_id,$name,$rate_count,$rate_avg,$comment,$created_at;
    public function create(){

    }
    public function read(){
        $query = "SELECT * FROM `testimonial` ORDER BY RAND() LIMIT 3";
        return $this->conn->query($query);
    }
    public function update(){

    }
    public function delete(){

    }

    

    /**
     * Get the value of product_id
     */ 
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */ 
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

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
     * Get the value of rate_count
     */ 
    public function getRate_count()
    {
        return $this->rate_count;
    }

    /**
     * Set the value of rate_count
     *
     * @return  self
     */ 
    public function setRate_count($rate_count)
    {
        $this->rate_count = $rate_count;

        return $this;
    }

    /**
     * Get the value of rate_avg
     */ 
    public function getRate_avg()
    {
        return $this->rate_avg;
    }

    /**
     * Set the value of rate_avg
     *
     * @return  self
     */ 
    public function setRate_avg($rate_avg)
    {
        $this->rate_avg = $rate_avg;

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
}