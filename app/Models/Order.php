<?php

namespace App\Models;

use RedBeanPHP\R;
use Exception;

class Order extends AppModel
{
    /**
     * @param $data
     * @return int|false
     */
    public static function saveOrder($data): int|false
    {
        R::begin();
        try {
            $order = R::dispense('orders');
            $order->user_id = $data['user_id'];
            $order->note = $data['note'];
            $order->total = $_SESSION['cart.sum'];
            $order->qty = $_SESSION['cart.qty'];
            $order_id = R::store($order);
            R::commit();

            return $order_id;
        } catch (Exception $e) {
            R::rollback();
            return false;
        }
    }
}