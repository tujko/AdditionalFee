<?php
declare(strict_types=1);
/**
 * @package   FactorBlue_AdditionalFee
 * @author    Nikola Tujković <tujkovicn@gmail.com>
 */

namespace FactorBlue\AdditionalFee\Model\Total;

use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use Magento\Quote\Model\QuoteValidator;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote\Address\Total;
use FactorBlue\AdditionalFee\Model\Config\Data;
use Magento\Framework\Phrase;

/**
 * AdditionalFee class for adding fee to total
 */
class AdditionalFee extends AbstractTotal
{
    /**
     * @var QuoteValidator|null
     */
    protected ?QuoteValidator $quoteValidator = null;

    /**
     * @var Data
     */
    private Data $config;

    /**
     * Constructor
     *
     * @param QuoteValidator $quoteValidator
     * @param Data $config
     */
    public function __construct(
        QuoteValidator $quoteValidator,
        Data $config
    ) {
        $this->quoteValidator = $quoteValidator;
        $this->config = $config;
    }

    /**
     * Collect totals process.
     *
     * @param Quote $quote
     * @param ShippingAssignmentInterface $shippingAssignment
     * @param Total $total
     * @return $this
     */
    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ):AdditionalFee {
        parent::collect($quote, $shippingAssignment, $total);

        if ($this->config->getConfigValue('additionalfee/general/enabled') &&
            count($shippingAssignment->getItems())) {
            $fee = (float)$this->config->getConfigValue('additionalfee/general/amount');

            if ($fee > 0) {
                $total->setTotalAmount('fb_additional_fee', $fee);
                $total->setBaseTotalAmount('fb_additional_fee', $fee);

                $total->setFbAdditionalFee($fee);
                $total->setBaseFbAdditionalFee($fee);
            }
        }

        return $this;
    }

    /**
     * Clearing of total values
     *
     * @param Total $total
     * @return void
     */
    protected function clearValues(Total $total):void
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }

    /**
     * Data retrieval
     *
     * @param Quote $quote
     * @param Total $total
     * @return array
     */
    public function fetch(Quote $quote, Total $total):array
    {
        return [
            'code' => 'fb_additional_fee',
            'title' => $this->getLabel(),
            'value' => (float)$this->config->getConfigValue('additionalfee/general/amount')
        ];
    }

    /**
     * Getting fee label
     *
     * @return Phrase
     */
    public function getLabel():Phrase
    {
        return __($this->config->getConfigValue('additionalfee/general/label'));
    }
}
