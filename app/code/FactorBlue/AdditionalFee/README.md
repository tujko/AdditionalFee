# Factor Blue Assessment

The assessment is to make a small backend module (M2 module) whose initial idea is to add a fee for every transaction made on the webshop.
The backend part should have configuration fields:
1. Enabled [yes/no dropdown]
2. Amount (in current webshop currency) [text field]
3. Label to describe the fee [text field]

If the module is enabled and the amount is larger than 0 that amount should be applied to every transaction. 
In cart totals, the label and the amount should be present.

## Compatibility
Tested on Magento 2 version 2.4.5p1 and PHP version 8.1.

## Installation
- ``php bin/magento module:enable Atwix_CustomerMod``
- ``php bin/magento setup:upgrade``
- ``php bin/magento setup:di:compile``
- ``php bin/magento c:f``

## Instructions
- Enable extension: *STORE->Settings->Configuration->Factor Blue->Additional Fee->Enabled*
- Label: *STORE->Settings->Configuration->Factor Blue->Additional Fee->Label*
- Fee amount: *STORE->Settings->Configuration->Factor Blue->Additional Fee->Amount*

## Author
Nikola Tujković
