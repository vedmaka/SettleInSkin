( function ( mw, $ ) {
    
    QUnit.module( 'skins.settlein.js', QUnit.newMwEnvironment() );
    QUnit.test( "hello test", 3, function( assert ) {
        assert.ok( 1 == "1", "Passed!" );
        assert.ok( 1 == "1", "Passed!" );
        assert.ok( 1 == "1", "Passed!" );
    });
    
})( mediaWiki, jQuery );