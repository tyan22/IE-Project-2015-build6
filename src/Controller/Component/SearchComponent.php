<?php
namespace App\Controller\Component;
use Cake\Controller\Component;

class SearchComponent extends Component
{
    public function findLastAccessedCust($model)
    {
        $recent = $model->find('all')
            ->order(['accessed' => 'DESC'])
            ->limit(8);
        return $recent;
    }

    public function findLastAccessedVendor($model)
    {
        $recent = $model->find('all')
            ->order(['accessed' => 'DESC'])
            ->limit(3);
        return $recent;
    }

    public function findLastAccessedOrder($model)
    {
        $recent = $model->find('all')
            ->order(['Orders.accessed' => 'DESC'])
            ->contain(['Customers'])
            ->limit(8);
        return $recent;
    }


}