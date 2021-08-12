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