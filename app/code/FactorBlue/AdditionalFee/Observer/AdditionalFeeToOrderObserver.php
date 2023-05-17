<?php
declare(strict_types=1);
/**
 * @package   FactorBlue_AdditionalFee
 * @author    Nikola Tujković <tujkovicn@gmail.com>
 */

namespace FactorBlue\AdditionalFee\Observer;

use FactorBlue\AdditionalFee\Model\Config\Data;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Sales\Api\OrderRepositoryInterface;

class AdditionalFeeToOrderObserver implements ObserverInterface
{
    /**
     * @var Data
     */
    private Data $config;

    private OrderRepositoryInterface $orderRepository;

    /**
     * Constructor
     *
     * @param Data $config
     */
    public function __construct(
        Data $config,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->config = $config;
        $this->orderRepository = $orderRepository;
    }

    /**
     * Add fee to order
     *
     * @param EventObserver $observer
     * @return $this
     */
    public function execute(Observer $observer):AdditionalFeeToOrderObserver
    {
        $fee = $this->config->getConfigValue('additionalfee/general/amount');

        if ($fee) {
            $order = $observer->getOrder();
            $order->setData('fb_additional_fee', $fee);
            $order->save();
        }

        return $this;
    }
}
