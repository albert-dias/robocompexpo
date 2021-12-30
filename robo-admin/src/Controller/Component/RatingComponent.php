<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
/**
 * Rating component
 */
class RatingComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    
    public function ratingProvider($provider_id){
        $t = TableRegistry::get('Ratings');

        $q = $t->find()->where([
            'type' => 'provider',
            'providers_id' => $provider_id
        ]);

        $stars = 0;
        $count = 0;
        
        foreach ($q as $value) {
            $stars += $value->stars;
            $count++;
        }
        
        if($count == 0 ){
            return $count;
        }

        return $stars/$count;
    }
    
    public function ratingClients($client_id){
        $t = TableRegistry::get('Ratings');

        $q = $t->find()->where([
            'type' => 'client',
            'clients_id' => $client_id
        ]);

        $stars = 0;
        $count = 0;
        
        foreach ($q as $value) {
            $stars += $value->stars;
            $count++;
        }
        
        if($count == 0 ){
            return $count;
        }

        return $stars/$count;
    }
}
