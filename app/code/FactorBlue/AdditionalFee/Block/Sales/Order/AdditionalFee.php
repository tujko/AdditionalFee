<?php
declare(strict_types=1);
/**
 * @package   FactorBlue_AdditionalFee
 * @author    Nikola Tujković <tujkovicn@gmail.com>
 */

namespace FactorBlue\AdditionalFee\Block\Sales\Order;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\Store;
use Magento\Tax\Model\Config ;
use Magento\Framework\DataObject;
use FactorBlue\AdditionalFee\Model\Config\Data;
use Magento\Sales\Model\Order;

class AdditionalFee extends Template
{
    /**
     * Tax configuration model
     * @var Config
     */
    protected Config $_config;

    /**
     * @var Order
     */
    protected Order $_order;

    /**
     * @var DataObject
     */
    protected DataObject $_source;

    /**
     * @var Data
     */
    private Data $config;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Config $taxConfig
     * @param Data $config
     * @param array $data
     */
    public function __construct(
        Context $context,
        Config $taxConfig,
        Data $config,
        array $data = []
    ) {
        $this->_config = $taxConfig;
        $this->config = $config;
        parent::__construct($context, $data);
    }

    /**
     * Get data (totals) source model
     *
     * @return DataObject
     */
    public function getSource():DataObject
    {
        return $this->getParentBlock()->getSource();
    }

    /**
     * Check if we need to display full totals info
     *
     * @return bool
     */
    public function displayFullSummary():bool
    {
        return true;
    }

    /**
     * Get Store
     *
     * @return Store
     */
    public function getStore():Store
    {
        return $this->_order->getStore();
    }

    /**
     * Get Order
     *
     * @return Order
     */
    public function getOrder():Order
    {
        return $this->_order;
    }

    /**
     * Get Label Properties
     *
     * @return array
     */
    public function getLabelProperties():array
    {
        return $this->getParentBlock()->getLabelProperties();
    }

    /**
     * Get Value Properties
     *
     * @return array
     */
    public function getValueProperties():array
    {
        return $this->getParentBlock()->getValueProperties();
    }

    /**
     * Initialize all order totals relates with tax
     *
     * @return AdditionalFee
     */
    public function initTotals():AdditionalFee
    {
        if ($this->config->getConfigValue('additionalfee/general/enabled')) {
            $parent = $this->getParentBlock();
            $this->_order = $parent->getOrder();
            $this->_source = $parent->getSource();
            if ($this->_source->getFbAdditionalFee() > 0) {
                $fee = new DataObject(
                    [
                        'code' => 'fb_additional_fee',
                        'strong' => false,
                        'value' => $this->_source->getFbAdditionalFee(),
                        'label' => __($this->config->getConfigValue('additionalfee/general/label')),
                    ]
                );
                $parent->addTotal($fee, 'fb_additional_fee');
            }
        }

        return $this;
    }
}
