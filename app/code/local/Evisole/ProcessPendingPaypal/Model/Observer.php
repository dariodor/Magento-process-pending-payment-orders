<?php

class Evisole_ProcessPendingPaypal_Model_Observer
{
	public function processPendingOrders()
	{

            $orderCollection = Mage::getModel('sales/order')->getCollection()->addAttributeToFilter('status','pending_payment');
            $orderIds = array();
            $IncrementIds = array();

            // Mage::log($orderCollection);

            foreach($orderCollection as $order) {

                // Mage::log('ordine ' .$order->getEntityId());  // stampa l'ID dell'ordine

                $orderModel = Mage::getModel('sales/order');
                $orderModel->load($order['entity_id']);

                $orderModel->setState(Mage_Sales_Model_Order::STATE_NEW, true);
                $orderModel->setStatus('pending_paypal_payment');
                $orderModel->save();
                $orderModel->sendNewOrderEmail();

            }

	}

}

?>