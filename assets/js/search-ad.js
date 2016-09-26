(jQuery.noConflict())(function($){
    var delayAction = (function(){
        var timer = 0;
        return function(callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        }
    })();

    var doSearch = function(elem) {
        elem.parent().addClass('isSearching');
        var results = elem.parent().next('.search-active-directory-results');
        results.fadeOut(250);
        $.ajax({
            url: cfSearchActiveDirectory.ajaxUrl,
            async: true,
            data: {'search_string': elem.val(), 'action': 'cfSADsearch'},
            dataType: 'json',
            //dataType: 'html',
            method: 'POST'
        }).always(function(data, status, error) {
            elem.parent().removeClass('isSearching');
            if(status == 'success') {
                var ul = $('<ul/>').append(data.list);
                results.html('')
                    .append($('<div/>', {
                        'class': 'msg',
                        'html':  data.message
                    }))
                    .append(ul)
                    .fadeIn(250);
            }
        });
    };

    $('.search-active-directory').keyup(function() {
        var that = $(this);
        delayAction(function() {
            doSearch(that);
        }, 500);
    })
    .focus(function(){
        var results = $(this).parent().next('.search-active-directory-results');
        if(results.html() != '') {
            results.fadeIn(250);
        } else {
            if($(this).val() != '') {
                $(this).trigger('keyup');
            }
        }
    });

    $(document).on('click', ':not(.search-active-directory-results)', function(){
        if(!$('.search-active-directory').is(':focus')) {
            $('.search-active-directory-results').fadeOut();
        }
    });

    $('.search-active-directory-results').on('click', 'ul a', function(e) {
        e.preventDefault();

        var results = $(this).parents('.search-active-directory-results'),
            keys = results.data('keys');
        if((keys != '') && (typeof keys != 'undefined')) {
            keys = keys.split(';');
            var fieldad = '',
                fieldcf = '',
                valad = '';
            for(var i in keys) {
                fieldad = results.data(keys[i]+'fieldad');
                fieldcf = results.data(keys[i]+'fieldcfid');
                valad = $(this).data(fieldad);
                if($('#'+fieldcf).length) {
                    $('#' + fieldcf).val(valad);
                }
            }
            results.fadeOut(250);
        }

        return false;
    });
});