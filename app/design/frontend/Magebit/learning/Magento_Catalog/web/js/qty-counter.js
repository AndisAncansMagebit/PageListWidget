/**
 * Magebit/learning
 *
 * @category        Magebit
 * @package         Magebit/learning
 * @author          Andis Ancans <info@magebit.com>
 * @copyright       Copyright (c) 2021 Magebit, Ltd.
 * @license         http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

'use strict';

define([
    'ko',
    'uiElement'
], function (ko, Element) {
    return Element.extend({
        defaults: {
            template: 'Magento_Catalog/input-counter'
        },
        qty: ko.observable(),

        initialize: function(config){
            this._super();
            this.qty = ko.observable(this.qty);
            this.maxQty = config.maxQty;
            this.qty.subscribe(function(newQty){
                if (parseInt(newQty) > this.maxQty){
                    this.qty(this.maxQty);
                }
                if (parseInt(newQty) < 0){
                    this.qty(1);
                }
            }.bind(this))
        },

        decreaseQty: function() {
            let newQty = this.qty() - 1;
            if (newQty < 1)
            {
                newQty = 1;
            }
            this.qty(newQty);
        },

        increaseQty: function() {

            let newQty = this.qty() + 1;
            if (newQty > this.maxQty)
            {
                newQty = this.maxQty;
            }
            this.qty(newQty);
        }
    });

});