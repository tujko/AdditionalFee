/**
 * @package   FactorBlue_AdditionalFee
 * @author    Nikola Tujković <tujkovicn@gmail.com>
 */
define(
    [
        'FactorBlue_AdditionalFee/js/view/checkout/summary/additionalfee'
    ],
    function (Component) {
        'use strict';

        return Component.extend({

            /**
             * @override
             */
            isDisplayed: function () {
                return true;
            }
        });
    }
);
