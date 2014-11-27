<?php

/**
 * Cart helper
 * @namespace System\Helper;
 * @package system.helper.cart
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Helper;

class Cart
{

    /**
     * Cart items
     * @property array
     */
    protected $cart = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cart =& $_SESSION['my_cart'];
    }

    /**
     * Check whether goods_id exists
     * @access protected
     * @param $goods_id
     * @return bool
     */
    protected function exist($goods_id)
    {
        return array_key_exists($goods_id, $this->cart);
    }

    /**
     * Get goods items
     * @param int $goods_id [optional]
     * @return array
     */
    public function get($goods_id = 0)
    {
        if (empty($goods_id)) {
            return $this->cart;
        } else {
            return $this->exist($goods_id) ? $this->cart[$goods_id] : array();
        }
    }

    /**
     * Add goods item
     * @access public
     * @param int $goods_id
     * @param string $goods_name
     * @param int $price
     * @param int $quantity [optional]
     * @param string $remark [optional]
     * @return array
     */
    public function add($goods_id, $goods_name, $price, $quantity = 1, $remark = '')
    {
        if ($this->exist($goods_id)) {
            $item =& $this->cart[$goods_id];
            $item['quantity'] = (int)$item['quantity'] + $quantity;
            $item['remark'] = (string)$remark;
        } else {
            $item = array(
                'goods_id' => (int)$goods_id,
                'goods_name' => (int)$goods_name,
                'price' => (int)$price,
                'quantity' => (int)$quantity,
                'remark' => (string)$remark
            );
            $this->cart[$goods_id] = $item;
        }
        return $this->cart;
    }

    /**
     * Update goods item
     * @access public
     * @param int $goods_id
     * @param int $quantity [optional]
     * @param string $remark [optional]
     * @return array
     */
    public function update($goods_id, $quantity = 1, $remark = '')
    {
        if ($this->exist($goods_id)) {
            $item =& $this->cart[$goods_id];
            $item['quantity'] = (int)$item['quantity'] + $quantity;
            $item['remark'] = (string)$remark;
        }
        return $this->cart;
    }

    /**
     * Delete cart item by goods_id
     * @param int $goods_id
     * @return array
     */
    public function delete($goods_id)
    {
        if ($this->exist($goods_id)) {
            unset($this->cart[$goods_id]);
        }
        return $this->cart;
    }

    /**
     * Empty cart items
     * @return array
     */
    public function trash()
    {
        return $this->cart = array();
    }

}