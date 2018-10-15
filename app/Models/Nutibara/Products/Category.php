<?php

namespace App\Models\Nutibara\Products;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_prod_categoria_general';
	public $timestamps  = false;
}
