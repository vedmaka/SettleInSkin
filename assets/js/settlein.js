/* global $,mw */
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
        
        $('.add-new-article-popup-form select#new_pageLanguage').change(function(){
            verifyTitle();
        });

        $('.add-new-article-popup-form form input#new_pageTitle').keyup(function(){
            clearTimeout( keyuptimeout );
            keyuptimeout = setTimeout( function() {
                verifyTitle();
            }, 250 );
        });

        $('.add-new-article-popup-form #newpage_btn_submit').click(function(){

            if( $(this).hasClass('disabled') ) {
                return false;
            }

            var currentLanguageCode = mw.config.get('wgContentLanguage');
            var selectedLanguageCode = $('.add-new-article-popup-form #new_pageLanguage').val();
            var formUrl = mw.config.get('wgServer') + mw.config.get('wgScriptPath');
            if( currentLanguageCode != selectedLanguageCode ) {
                formUrl = '//' + mw.config.get('wgSettleTranslateDomains')[selectedLanguageCode];
            }
            formUrl += '/index.php/Special:FormEdit/Card/';
            $('.add-new-article-popup-form form').prop('action', formUrl);
            $('.add-new-article-popup-form form').submit();

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
    
    function verifyTitle()
    {
        var value = $('.add-new-article-popup-form form input#new_pageTitle').val();
        if( !value.length ) {
            return;
        }
        startLoader();
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
    }

    function queryTitleApi( page, callback )
    {
        var currentLanguageCode = mw.config.get('wgContentLanguage');
        var selectedLanguageCode = $('.add-new-article-popup-form #new_pageLanguage').val();
        var endpoint = mw.config.get('wgServer') + mw.config.get('wgScriptPath');
        if( currentLanguageCode != selectedLanguageCode ) {
            endpoint = '//' + mw.config.get('wgSettleTranslateDomains')[selectedLanguageCode];
        }
        endpoint += '/api.php?origin='+ mw.config.get('wgServer') + '&format=json&action=settlein&do=check_unique&page=' + page;
        
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