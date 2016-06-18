$(function(){

    if( $('#add-new-article-btn').length ) {

        var keyuptimeout = null;

        $('#newpage_btn_cancel').click(function(){
            $('.add-new-article-popup-form form').get(0).reset();
            $('.add-new-article-popup-form .new_page_suggestions').hide();
            $('.add-new-article-popup-form').hide();
            $('#add-new-article-popup-wrapper').hide();
        });

        $('#add-new-article-btn').click(function(){
            $('.add-new-article-popup-form').show();
            $('#add-new-article-popup-wrapper').show();
        });

        $('.add-new-article-popup-form form input[name="pageTitle"]').keyup(function(){
            var value = $('.add-new-article-popup-form form input[name="pageTitle"]').val();
            if( !value.length ) {
                return;
            }
            clearTimeout( keyuptimeout );
            keyuptimeout = setTimeout( function() {
                queryTitleApi( value, function(  exists, suggestions ){

                    var pText = '';

                    if( exists == 1 ) {
                        // Show exists warning
                        pText = mw.msg('settlein-skin-add-new-article-text-exists');
                    }else{
                        $('#newpage_btn_submit').removeClass('disabled');
                        pText = mw.msg('settlein-skin-add-new-article-text-not-exists');
                    }

                    if( suggestions.length ) {
                        // Display similar pages
                        $('.add-new-article-popup-form p').text(pText);
                        var ul = $('.add-new-article-popup-form ul');
                        ul.html('');
                        $.each(suggestions, function(i,v){
                            var li = $('<li />');
                            var a = $('<a />');
                            a.text( v.title );
                            a.prop('href', v.link);
                            a.prop('target', '_blank');
                            li.append(a);
                            ul.append(li);
                        });
                        $('.add-new-article-popup-form .new_page_suggestions').fadeIn();
                    }

                });
            }, 250 );
            startLoader();
        });

    }

    function startLoader() {
        //$('#newpage_btn_submit').addClass('disabled');
        if( !$('#newpage_btn_submit').hasClass('disabled') ) {
            $('#newpage_btn_submit').addClass('disabled');
        }

        if( !$('#newpage_btn_submit').hasClass('btn-native-loader') ) {
            $('#newpage_btn_submit').addClass('btn-native-loader');
        }
        $('.add-new-article-popup-form .new_page_suggestions').hide();
    }

    function stopLoader() {
        //$('#newpage_btn_submit').removeClass('disabled');
        $('#newpage_btn_submit').removeClass('btn-native-loader');
    }

    function queryTitleApi( page, callback )
    {
        var endpoint = mw.config.get('wgServer') + mw.config.get('wgScriptPath') + '/api.php?format=json&action=settlein&do=check_unique&page=' + page;
        $.get( endpoint, function( response ){
            if( response ) {
                if( response.settlein ) {
                    var exists = response.settlein.exists;
                    var suggestions = response.settlein.suggestions;
                    callback( exists, suggestions );
                    stopLoader();
                }
            }
        });
    }

});