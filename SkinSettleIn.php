<?php
/**
 * Created by PhpStorm.
 * User: Jon Anderton
 * Date: 22.11.2015
 * Time: 21:06
 */

class SkinSettleIn extends SkinTemplate {
    public $skinname = 'settlein';
    public $stylename = 'SettleIn';
    public $template = 'SettleInTemplate';
    /**
     * @var Config
     */
    private $settleinConfig;

    public function __construct() {
        $this->settleinConfig = ConfigFactory::getDefaultInstance()->makeConfig( 'settlein' );

    }

    /**
     * Initializes output page and sets up skin-specific parameters
     * @param OutputPage $out Object to initialize
     */
    public function initPage( OutputPage $out ) {
        parent::initPage( $out );

        $title = $out->getTitle();

        $isCard = false;
        if( $title && $title->exists() ) {
            $categoris = SFUtils::getCategoriesForPage( $title );
            if( in_array('Card', $categoris) ) {
                if( !$out->getRequest()->getVal('action') || $out->getRequest()->getVal('action') == 'view' ) {
                    $isCard = true;
                }
            }
        }

	    if( $this->getSkin()->getTitle()->isSpecialPage() && $this->getSkin()->getTitle()->isSpecial('SettleCategorySearch') && count(explode('/',$this->getRequest()->getVal('title'))) > 1 ) {
		    $isCard = true;
	    }

        if( $title && $title->exists() && $title->getNamespace() == NS_MAIN ) {
            if( $title->getArticleID() === Title::newMainPage()->getArticleID() ) {
                $scripts = array( 'skins.settlein.js', 'skins.settlein.landing.js' );
            }else{
                if( $isCard ) {
                    $scripts = array( 'skins.settlein.page.js' );
                }else{
                    $scripts = array( 'skins.settlein.js' );
                }
            }
        }else{
            if( $isCard ) {
                $scripts = array( 'skins.settlein.page.js' );
            }else{
                $scripts = array( 'skins.settlein.js' );
            }
        }

        $out->addModules( $scripts );

	    if( $this->getUser() && $this->getUser()->isLoggedIn() ) {
	    	$out->addModules( 'ext.settlegeoforminput.foo' );
	    }

	    $out->addModules( SettleGeoSearch::getModules() );

        $out->addMeta('viewport','width=device-width, initial-scale=1');
    }

    /**
     * Loads skin and user CSS files.
     * @param OutputPage $out
     */
    function setupSkinUserCss( OutputPage $out ) {
        parent::setupSkinUserCss( $out );

        $title = $out->getTitle();

        $isCard = false;
        if( $title && $title->exists() ) {
            $categoris = SFUtils::getCategoriesForPage( $title );
            if( in_array('Card', $categoris) ) {
                if( !$out->getRequest()->getVal('action') || $out->getRequest()->getVal('action') == 'view' ) {
                    $isCard = true;
                }
            }
        }
	    if( $this->getSkin()->getTitle()->isSpecialPage() && $this->getSkin()->getTitle()->isSpecial('SettleCategorySearch') && count(explode('/',$this->getRequest()->getVal('title'))) > 1 ) {
		    $isCard = true;
	    }

        if( $title && $title->exists() && $title->getNamespace() == NS_MAIN ) {
            if( $title->getArticleID() === Title::newMainPage()->getArticleID() ) {
                $styles = array( 'skins.settlein.styles', 'skins.settlein.landing.css' );
            }else{
                if( $isCard ) {
                    $styles = array( 'skins.settlein.page.styles' );
                }else{
                    $styles = array( 'skins.settlein.styles' );
                }
            }
        }else{
            if( $isCard ) {
                $styles = array( 'skins.settlein.page.styles' );
            }else{
                $styles = array( 'skins.settlein.styles' );
            }
        }

        /*if( $out->getRequest()->getVal('color') ) {
            global $wgServer, $wgScriptPath;
            $color = htmlspecialchars( $out->getRequest()->getVal('color') );
            $out->addStyle( $wgServer . $wgScriptPath . '/skins/SettleIn/assets/colors/'.$color.'.css' );
        }

        if( $out->getRequest()->getVal('beta_font') ) {
            global $wgServer, $wgScriptPath;
            $font = htmlspecialchars( $out->getRequest()->getVal('beta_font') );
            $out->addStyle( $wgServer . $wgScriptPath . '/skins/SettleIn/assets/fonts/'.$font.'.css' );
        }*/

	    if( $this->getUser() && $this->getUser()->isLoggedIn() ) {
		    $out->addModuleStyles( 'ext.settlegeoforminput.foo' );
	    }

        $out->addModuleStyles( $styles );
    }

    /**
     * Override to pass our Config instance to it
     * @param string $classname
     * @param bool $repository
     * @param bool $cache_dir
     * @return QuickTemplate
     */
    public function setupTemplate( $classname, $repository = false, $cache_dir = false ) {
        return new $classname( $this->settleinConfig );
    }
    
    public static function onResourceLoaderTestModules( &$testModules, &$resourceLoader ){
        $testModules['qunit']['skin.settlein.tests'] = array(
        	'scripts' => array( 'tests/qunit/skins.settlein.js' ),
        	'dependencies' => array( 'skins.settlein.js' ),
        	'localBasePath' => __DIR__,
        	'remoteSkinPath' => 'SettleIn'
        );
    }
    
}
