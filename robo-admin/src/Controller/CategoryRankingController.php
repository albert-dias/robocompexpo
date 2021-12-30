<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use DateTime;

/**
 * CategoryRanking Controller
 *
 *
 * @method \App\Model\Entity\CategoryRanking[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoryRankingController extends AppController
{
    public function initialize() {
        $this->loadModel('ServiceOrders');
        parent::initialize();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $conditions = [];

        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $date_start_search_orders  = $this->request->getData('date_start_search_orders');
            $date_end_search_orders    = $this->request->getData('date_end_search_orders');

            if($date_start_search_orders && $this->validateDate($date_start_search_orders)){
                $date_start_search_orders = str_replace("/", "-", $date_start_search_orders);
                $date_start = new Time($date_start_search_orders);
                $conditions['ServiceOrders.date_service_ordes >='] = $date_start;
            }
    
            if($date_end_search_orders && $this->validateDate($date_end_search_orders)){
                $date_end_search_orders = str_replace("/", "-", $date_end_search_orders);
                $date_end = new Time($date_end_search_orders);
                $conditions['ServiceOrders.date_service_ordes <='] = $date_end;
            }
        }

        $query = $this->ServiceOrders->find();
        $categories =  $query->select([
            'count' => $query->func()->count('categories_id'),
            'categories_id',
            'name' => 'Categories.name'
            //'published_date' => 'DATE(created)'
        ])
            ->contain([
                'Categories'
            ])
            ->group('categories_id')
            ->where($conditions)
            ->order([
                'count' => 'DESC'
            ]);

        $this->set(compact('categories'));
    }

    private function validateDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        
        return $d && $d->format($format) === $date;
    }
}
