<?php

/**
 * Class for stools extension
 *
 * @file
 * @ingroup Extensions
 */
class stools
{

    /**
     * @param Parser $parser
     * @return mixed
     */
    public static function formlink( $parser )
    {
        $params = func_get_args();
        array_shift( $params ); // We don't need the parser.

        $original = SFUtils::createFormLink( $parser, $params, 'formlink' );

        if( strpos($original, 'class="new"') !== false ) {
            //$original = str_replace('class="new"', 'class="btn btn-primary pull-right"', $original);
            $original = str_replace('class="new"', 'class="card-special-skin-link"', $original);
        }else{
            //$original = str_replace('href=', 'class="btn btn-primary pull-right" href=', $original);
            $original = str_replace('href=', 'class="card-special-skin-link" href=', $original);
        }

        $original = str_replace('self">', 'self"> ', $original);

        return $parser->insertStripItem( $original );
    }

    /**
     * @param Parser $parser
     * @return string
     */
    public static function moddate( $parser )
    {
        $title = $parser->getTitle();
        if( !$title || !$title->exists() ) {
            return '';
        }

        $lastRev = Revision::newFromId( $title->getLatestRevID() );
        return date("j M Y", wfTimestamp(TS_UNIX, $lastRev->getTimestamp()));

    }

    /**
     * @param Parser $parser
     * @return string
     */
    public static function editorlist( $parser )
    {

        $title = $parser->getTitle();
        if( !$title || !$title->exists() ) {
            return '';
        }

        $page = WikiPage::factory( $title );
        $tEditors = $page->getContributors();
        $editors = array();

        $html = '<ul class="page-editors-list">';

        foreach( $tEditors as $teditor ) {
            if( !array_key_exists( $teditor->getId(), $editors ) ) {
                $editors[] = $teditor;
            }
        }
        if( !array_key_exists( $page->getUser(), $editors ) ) {
            $editors[] = User::newFromId( $page->getUser() );
        }

        foreach( $editors as $editor ) {
            $html .= '<li>'
                . $parser->insertStripItem(
                    '<a href="' .$editor->getUserPage()->getFullURL()
                    . '" data-toggle="tooltip" data-placement="top" data-original-title="'.$editor->getName().'">' .
                    '<i class="fa fa-user"></i>' . '</a>'
                ) . '</li>';
        }

        $html .= '</ul>';

        return $html;

    }

	/**
	 * @param Parser $parser
	 *
	 * @return string
	 */
    public static function pageauthor( $parser ) {
    	$html = '';

    	$title = $parser->getTitle();
	    if( !$title || !$title->exists() ) {
		    return 'Unknown';
	    }

	    $author = $title->getFirstRevision()->getUserText();

	    $html .= $author;

	    return $html;
    }

    /**
     * @param Parser $parser
     * @return string
     */
    public static function sprintbtn( $parser )
    {

        $html = '';

        $title = $parser->getTitle();
        $link = $title->getFullURL('printable=yes');

        $link = '#';

        $parser->getOutput()->addModules( 'ext.stools.foo' );

        /*$html .= $parser->insertStripItem('<a id="print-button" href="'.$link.'" type="button" class="btn btn-primary"><i class="fa fa-print"></i> '.
            wfMessage( 'stools-button-print' )->plain().'</a>');*/

	    $html .= $parser->insertStripItem('<a id="print-button" class="card-special-skin-link" href="'.$link.'">'.
			wfMessage( 'stools-button-print' )->plain().'</a>');

        return $html;

    }

    public static function getPropertyAllowedValues( $propertyName )
    {

        $arValues = array();

        $store = \SMW\StoreFactory::getStore();
        $prop = new SMWDIWikiPage( str_replace(' ', '_', $propertyName), SMW_NS_PROPERTY );

        $pValues = $store->getPropertyValues( $prop, new SMWDIProperty('_PVAL') );

        if( $pValues ) {
            /** @var SMWDIBlob $arValue */
            foreach ( $pValues as $value ) {
                $arValues[] = $value->getString();
            }
        }

        return $arValues;

    }

    public static function makebtn( &$parser )
    {

    	//<div class="btn btn-large btn-yellow">APPLY</div>

	    $params = func_get_args();
	    array_shift( $params ); // We don't need the parser.

	    $html = '';

	    $text = 'Button';
	    $class = 'btn-primary';
	    $link = '#';

	    if( count($params) ) {
	    	$text = $params[0];
		    if( count($params) > 1 ) {
			    $link = $params[1];
		    }
		    if( count($params) > 2 ) {
		    	$class = $params[2];
		    }
	    }

	    $html .= $parser->insertStripItem('<a href="'.$link.'" type="button" class="btn '.$class.'">'.$text.'</a>', $parser->mStripState );

	    return $html;

    }

    public static function langlinks( $parser ) {

    	$html = '<ul class="col-right-languages"><li><a href="#">German</a></li><li><a href="#">Russian</a></li><li><a href="#">French</a></li><li><a href="#">Turkish</a></li><li><a href="#">Kazakh</a></li></ul>';
		return array(
			$html,
			'isHTML' => true,
			'markerType' => 'nowiki'
		);

    }

    public static function sociallinks( $parser ) {

    	$html = '<ul class="col-right-social-links">' .
	            '<li><a href="#" class="social-link-twitter"></a></li>' .
	            '<li><a href="#" class="social-link-facebook"></a></li>' .
	            '<li><a href="#" class="social-link-google"></a></li>' .
	            '<li><a href="#" class="social-link-some"></a></li>' .
	            '</ul>';
	    return array(
		    $html,
		    'isHTML' => true,
		    'markerType' => 'nowiki'
	    );

    }

    public static function footerlinks( $parser ) {

	    $html = '<ul class="col-right-footer-links">' .
	            '<li><a href="#">Our Story</a></li>' .
	            '<li><a href="#">Contact Us</a></li>' .
	            '<li><a href="#">Help Out</a></li>' .
	            '<li><a href="#">Terms of Use</a></li>' .
	            '</ul>';
	    return array(
		    $html,
		    'isHTML' => true,
		    'markerType' => 'nowiki'
	    );

    }

}
