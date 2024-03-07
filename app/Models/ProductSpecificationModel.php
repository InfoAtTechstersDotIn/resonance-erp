<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductSpecificationModel extends Model
{
    public function get_product_specifications()
    {
        $db = db_connect();
        // $query = $db->query('SELECT product_specifications.*, product_category.name AS category_name FROM product_specifications JOIN product_category ON product_specifications.category_id = product_category.id;');
        $query = $db->query('SELECT product_specifications.*, product_category.name AS category_name, product_type.name as product_type FROM product_specifications JOIN product_category ON product_specifications.category_id = product_category.id JOIN product_type ON product_specifications.product_type_id = product_type.id;');
        return $query->getResult();
    }

    public function add_product_specification($data)
    {
        $db = db_connect();
        $builder = $db->table('product_specifications');
        $builder->insert($data);

        $db->close();
    }

    public function update_product_specification($specification_id, $data)
    {
        $db = db_connect();
        $builder = $db->table('product_specifications');
        $builder->where('id', $specification_id);
        $builder->update($data);
        $db->close();
    }

    public function delete_product_specification($id)
    {
        $db = db_connect();
        $builder = $db->table('product_specifications');
        $builder->where('id', $id);
        $builder->delete();
        $db->close();
    }
    

}
