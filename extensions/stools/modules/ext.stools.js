( function () {

    /**
     * @class mw.stools
     * @singleton
     */
    mw.stools = {};

}() );

$(function(){

    $('#print-button').click(function(e){
        window.print();
        return false;
    });

});