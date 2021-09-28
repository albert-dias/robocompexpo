<?php
namespace App\Controller;

use App\Controller\AppController;
use RestApi\Controller\ApiController;

/**
 * Subcategories Controller
 *
 * @property \App\Model\Table\SubcategoriesTable $Subcategories
 *
 * @method \App\Model\Entity\Subcategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubcategoriesController extends ApiController
{

    public function getAll()
    {
        $subcategories = $this->Subcategories->find('list')->where([
            'active' => true,
        ])
            ->order(['name']);
        $this->apiResponse = $subcategories;
    }

    public function getCategoriesId()
    {
        $categories_id = $this->request->data('category_id');
        
        $subcategories = $this->Subcategories->find('list')->where([
            'active' => true,
            'category_id' => $categories_id
        ])
        ->order(['name']);

        $this->apiResponse = $subcategories;
    }
}
