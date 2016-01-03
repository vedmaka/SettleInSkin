( function () {

    var apiUrl = mw.config.get('wgServer') + mw.config.get('wgScriptPath') + '/api.php?action=authorrating&format=json';

    /**
     * @class mw.Authorrating.Foo
     *
     * @constructor
     */
    function Authorrating( element ) {
        this.$element = element;
        this.$rateBtn = this.$element.find('.author-thumbs-up');
        this.$rateCount = this.$element.find('span.label');
        this.pageId = mw.config.get('wgArticleId');
        this.init();
    }

    /**
     * Initialization function
     */
    Authorrating.prototype.init = function()
    {
        if( !mw.config.get('wgUserId') || mw.config.get('wgUserId') == null ) {
            return false;
        }

        // Check if user already voted or not and load votes information
        $.get( apiUrl + '&do=info&page_id=' + this.pageId, function(data){

            var rating = data.authorrating.rating;
            var canvote = data.authorrating.canvote;

            this.$rateCount.text( rating );

            if( canvote ) {
                this.initRateBtn();
            }

        }.bind(this));

    };

    Authorrating.prototype.initRateBtn = function()
    {
        this.$rateBtn.click(function(){
            this.$rateBtn.hide();
            var currentRating = parseInt( this.$rateCount.text() ) || 0;
            currentRating += 1;
            this.$rateCount.text( currentRating );
            $.get( apiUrl + '&do=vote&page_id=' + this.pageId, function(){
               // Vote saved
            });
        }.bind(this));
        // Show rate button
        this.$rateBtn.show();
    };

    mw.Authorrating = Authorrating;

}() );
