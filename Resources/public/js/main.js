// content editable bundle
;(function(window, $, aloha, undefined){

    var contentEditable = window.contentEditable || {};
    window.contentEditable = contentEditable;

    contentEditable.init = function(baseUrl) {
        var editable = $('[data-content-editable-config-key]');
        var index = 1000;

        editable.addClass('content-editable');

        editable.mouseover(function() {
            $(this).addClass('hover');
        });
        editable.mouseout(function() {
            $(this).removeClass('hover');
        });

        editable.each(function () {
            if (!$(this).is("[tabindex]")) {
                $(this).attr('tabindex', index++);
            }
        });

        editable.focusin(function () {
            if (!$(this).hasClass('editing')) {
                $(this).addClass('editing');
                aloha(this);
            }
        });

        editable.focusout(function () {
            if ($(this).hasClass('editing')) {
                var configKey = $(this).data('content-editable-config-key');
                var dataField = $(this).data('content-editable-data-field');
                var objectId = $(this).data('content-editable-object-id');
                var content = $(this).html();

                $.ajax({
                    type: "PUT",
                    url: baseUrl + '/' + configKey + '/' + objectId + (dataField ? '?dataField=' + dataField : ''),
                    data: content,
                    contentType: "application/json; charset=utf-8;",
                    dataType: "text/plain",
                    success: function (data) {
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });

                $(this).removeClass('editing');
                aloha.mahalo(this);
            }
        });
    }
})(window, jQuery, aloha);