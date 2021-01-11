define([
    'underscore',
    'Magento_Ui/js/grid/columns/select'
], function (_, Column) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'Suraj_AdminGrid/ui/grid/cells/text'
        },
        getStatusColor: function (row) {
            if (row.status == 0) {
                return '#d71717';
            }
            return '#25de12';
        }
    });
});
