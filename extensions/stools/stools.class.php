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
	 *
	 * @return string
	 */
	public static function userpic( $parser )
	{

		$params = func_get_args();
		array_shift( $params ); // We don't need the parser.

		$html = '';

		$user = User::newFromName( $params[0] );
		if( !$user || $user->getId() === 0 ) {
			return '';
		}

		if( !OpauthProfile::exists( $user->getId() ) ) {
			return '';
		}

		$profile = new OpauthProfile( $user->getId() );
		if( !$profile->image ) {
			return '';
		}

		$html = '<img src="'.$profile->image.'" class="user-profile-image" />';

		return $parser->insertStripItem( $html );

	}

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

        $html = '<ul>';

        foreach( $tEditors as $teditor ) {
            if( !array_key_exists( $teditor->getId(), $editors ) ) {
                $editors[] = $teditor;
            }
        }
        if( !array_key_exists( $page->getUser(), $editors ) ) {
            $editors[] = User::newFromId( $page->getUser() );
        }

        /** @var User $editor */
	    foreach( $editors as $editor ) {

	    	$image = '';
		    if( OpauthProfile::exists($editor->getId()) ) {
			    $profile = new OpauthProfile($editor->getId());
			    if( $profile->image ) {
					$image = '<img src="'.$profile->image.'" class="user-profile-image" />';
			    }
		    }

            $html .= $parser->insertStripItem(
                    '<li><a href="' .$editor->getUserPage()->getFullURL()
                    . '" data-toggle="tooltip" data-placement="top" data-original-title="'.$editor->getName().'">'
                    .$image.'</a></li>'
                );
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

	    $html .= $parser->insertStripItem('<a target="_blank" href="'.$link.'" type="button" class="btn '.$class.'">'.$text.'</a>', $parser->mStripState );

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
	            //'<li><a href="#" class="social-link-google"></a></li>' .
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
	            //'<li><a href="'.SpecialPage::getTitleFor('SettleIn')->getFullURL().'/about">'.wfMessage('settlein-skin-footer-about-us')->plain().'</a></li>' .
	            '<li><a href="'.SpecialPage::getTitleFor('SettleIn')->getFullURL().'/contact">'.wfMessage('settlein-skin-footer-contact')->plain().'</a></li>' .
	            '<li><a href="'.Title::newFromText('Help Out', NS_PROJECT)->getFullURL().'">'.wfMessage('settlein-skin-footer-helpout')->plain().'</a></li>' .
	            //'<li><a href="'.SpecialPage::getTitleFor('SettleIn')->getFullURL().'/tos">'.wfMessage('settlein-skin-footer-tos')->plain().'</a></li>' .
	            '</ul>';
	    return array(
		    $html,
		    'isHTML' => true,
		    'markerType' => 'nowiki'
	    );

    }

}
