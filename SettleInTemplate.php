<?php
/**
 * QuickTemplate class for SettleIn skin
 * @ingroup Skins
 */
class SettleInTemplate extends BaseTemplate {
	/* Functions */

    /** @var boolean */
    private $isLoggedIn;

    /** @var User */
    private $user;

    /** @var boolean */
    private $isCardPage;

    /** @var boolean */
    private $isMainPage;

    /** @var boolean */
    private $cleanPage;

	private $countriesList;

	/** @var array Contains list of connected languages including current one */
	private $connectedLanguagesList;

	private $categoriesList;

	private $profile_image;

	/**
	 * Outputs the entire contents of the (X)HTML page
	 */
	public function execute() {

		global $wgSettleTranslateDomains, $wgLanguageCode;

		$this->isMainPage = $this->getSkin()->getTitle()->getArticleID() === Title::newMainPage()->getArticleID();

        $this->isCardPage = false;
        if( $this->getSkin()->getTitle() ) {
            if( $this->getSkin()->getTitle()->exists() ) {
                $categories = SFUtils::getCategoriesForPage( $this->getSkin()->getTitle() );
                if( in_array('Card', $categories) ) {
                    if( !$this->getSkin()->getRequest()->getVal('action') || $this->getSkin()->getRequest()->getVal('action') == 'view' ) {
                        $this->isCardPage = true;
                    }
                }
            }
        }

        $this->cleanPage = false;
        if( $this->getSkin()->getTitle() ) {
            if( $this->getSkin()->getTitle()->getNamespace() == NS_SPECIAL ) {
                if( in_array( $this->getSkin()->getTitle()->getBaseText(), array(
                    'SettleIn/about',
                    'SettleIn/contact',
                    'SettleIn/tos'
                )) ) {
                    $this->cleanPage = true;
                }
            }
        }

	    // Init
		$this->profile_image = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAAFOUlEQVR4Xu3YZ0ujURCG4YkgFuyoiGLBiiJi+f+/QLGBqNjLBwvG3sCyzIGIyeqSwTEks7dfXHGYN/PMtScnZrLZ7LvwRQJFJpABTJFJUZYSAAwQTAkAxhQXxYDBgCkBwJjiohgwGDAlABhTXBQDBgOmBABjiotiwGDAlABgTHFRDBgMmBIAjCkuigGDAVMCgDHFRTFgMGBKADCmuCgGDAZMCQDGFBfFgMGAKQHAmOKiGDAYMCUAGFNcFAMGA6YEAGOKi2LAYMCUAGBMcVEMGAyYEgCMKS6KAYMBUwKAMcVFMWAwYEoAMKa4KAYMBkwJAMYUF8WAwYApAcCY4qIYMBgwJQAYU1wUAwYDpgQAY4qLYsBgwJQAYExxUQwYDJgSAIwpLooBgwFTAoAxxUUxYDBgSgAwprgoBgwGTAkAxhQXxYDBgCkBwJjiohgwGDAlABhTXBQDBgOmBABjiotiwGDAlABgTHFRDBgMmBIAjCkuigGDAVMCgDHFRTFgMGBKoOLBPD4+ytLSUhp6dnZWamtr8wLY2NiQ4+NjGR4eloGBgfS7g4MD2d3dldfXV2lsbJSJiYn0vZivUj+vmNdUypqKBfP+/i7n5+eyubkpz8/PUl9f/xeYbDYrq6ur8vLy8gHm+vpaVlZWpLm5OQHSfyuW6elpyWQy32Zf6ueVEoHlWRUL5vb2VhYXF0UX+fb2lk6WzyeMnh6K4fLyMtXkThg9Xba2tmRkZET6+/tlfn5enp6eZGZmJgHUk6ejoyPVLy8vp1NoampKqqqq3J/X0NBg2VVZ1FYsmLu7u7T47u5u0bed6urqPDCHh4eys7MjLS0tcnFx8QFmbW1Nzs7OZHx8XLq6uj5QTU5OplpF+PDwIE1NTQmbnkJDQ0PyG89rb28vCwSWF1GxYHJD5k6az2By94y6urqEQOHkTphCMIU/n5ycyPr6ejpZ9ASYm5tLGH/reZZllUNtSDB64ugpom8lV1dXsr29XdQJo//j9b6zsLCQTpS+vj4ZHR3N29NXQH/yvHJAYHkN4cDo8Lm3lcIg9JTRi+13dxg9Ufb29tI9Ru89NTU1CZ1ekL87YX76PMuyyqE2HJjCj9X7+/t5J4zeS/Qy3NraKoODg+liq1D0U9L9/X36iK6oOjs75ejoSNra2vI+QX11wnxepOV5//pUVg44vnoN/x0YDUEh6L1G335yf4dRNHqfOT09TZB6e3sTppubGxkbG5Oenp6UnxXMd88r9u8+5Qan4sGUW6DRXw9gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/Yeb4/HZAutcoP83oAAAAASUVORK5CYII=';
        $this->isLoggedIn = false;
	    if( $this->getSkin()->getUser() && !$this->getSkin()->getUser()->isAnon() ) {
	        $this->user = $this->getSkin()->getUser();
	        $this->isLoggedIn = true;
		    if( OpauthProfile::exists( $this->getSkin()->getUser()->getId() ) ) {
			    $profile = new OpauthProfile( $this->getSkin()->getUser()->getId() );
			    if( $profile->image ) {
				    $this->profile_image = $profile->image;
			    }
		    }
	    }

	    $nav = $this->data['content_navigation'];
	    $this->data['namespace_urls'] = $nav['namespaces'];
		$this->data['view_urls'] = $nav['views'];
		$this->data['action_urls'] = $nav['actions'];
		$this->data['variant_urls'] = $nav['variants'];

		// Prepare some data
		$this->countriesList = SettleGeoTaxonomy::getInstance()->getEntities( SettleGeoTaxonomy::TYPE_COUNTRY, null, $wgLanguageCode );

		$this->connectedLanguagesList = array(
			$wgLanguageCode => Language::fetchLanguageName($wgLanguageCode)
		);
		if( $wgSettleTranslateDomains && count($wgSettleTranslateDomains) ) {
			foreach ($wgSettleTranslateDomains as $langKey => $domain) {
				$this->connectedLanguagesList[$langKey] = Language::fetchLanguageName($langKey);
			}
		}

		$this->categoriesList = array();
        //TODO: this should be reworked once fixed list of categories will be introduced
        $this->categoriesList = stools::getPropertyAllowedValues( 'Tags' );

		// Output HTML Page
		$this->html( 'headelement' );

		$this->getSkin()->getOutput()->addHeadItem(
	        'fonts',
	        '<link href=\'http://fonts.googleapis.com/css?family=Oswald:400,300\' rel=\'stylesheet\' type=\'text/css\'>' .
            '<link href=\'http://fonts.googleapis.com/css?family=Oxygen:400,300,700\' rel=\'stylesheet\' type=\'text/css\'>' .
            '<link href=\'http://fonts.googleapis.com/css?family=PT+Sans\' rel=\'stylesheet\' type=\'text/css\'>' .
            '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="'.$this->getSkin()->getSkinStylePath("img/favicon_precomposed.jpg").'">' .
            '<link rel="icon" type="image/png" href="'.$this->getSkin()->getSkinStylePath("img/favicon.jpg").'">'
		);

		if( !$this->isMainPage ) {
			$this->printSlideMenu();
		}
		?>
		<main class="<?=($this->isMainPage) ? 'main-page-landing' : ''?> <?=($this->isCardPage) ? 'card-page' : '' ?>">
		<?

		$title = $this->getSkin()->getTitle();
		if( $title && $title->exists() && $title->getNamespace() == NS_MAIN ) {
		    if( $this->isMainPage ) {
		        //$this->printMainPage(); // main page layout
                $this->printMainPageLanding();
		    }else{
		        $this->printNormalPage(); // normal page layout
		    }
		}else{
		    $this->printNormalPage(); // normal page layout
		}

		$this->printFooterThings(); // footer on all pages

		$this->printTrail(); // system trail
		?>
		</main>
	</body>
</html>
<?php
	}

	private function printMainPageLanding() {

	    $data = array();

	    // Geo-search html
		$settlesearch = new SettleGeoSearch();
        $data['geosearch'] = $settlesearch->getHtml( SettleGeoSearch::SGS_MODE_TEXT, 'geo_id' );
        $data['img_logo'] = $this->getSkin()->getSkinStylePath('/img/logo50h.png');
        $data['isloggedin'] = $this->isLoggedIn;
        $data['register_link'] = SpecialPage::getSafeTitleFor('Userlogin')->getFullURL('type=signup');
        $data['login_link'] = SpecialPage::getSafeTitleFor('Userlogin')->getFullURL();
        $data['root_link'] = Title::newMainPage()->getFullURL();
        if( $this->isLoggedIn ) {
	        $data['username']         = $this->user->getName();
	        $data['logout_link']      = SpecialPage::getSafeTitleFor( 'UserLogout' )->getFullURL();
	        $data['preferences_link'] = SpecialPage::getSafeTitleFor( 'UserProfile' )->getFullURL();
	        $data['new_article_link'] = SpecialPage::getSafeTitleFor( 'SettleNewArticle' )->getFullURL();
        }
		$data['geosearchurl']     = SettleGeoSearch::getSearchPageUrl();
        $data['img_car'] = $this->getSkin()->getSkinStylePath("/img/slices/slice_car.png");
        $data['img_home'] = $this->getSkin()->getSkinStylePath("/img/slices/slice_home.png");
        $data['img_help'] = $this->getSkin()->getSkinStylePath("/img/slices/slice_help.png");

        $data['categories_links'] = '';
        $categories = SettleGeoCategories::getAllCategories();
        foreach ($categories as $category) {
            $data['categories_links'] .= '<span class="label"><a href="'
                                         .SpecialPage::getTitleFor('Category')->getFullURL().'/'.$category->getId()
                                         .'">'.$category->getTitleKey().'</a></span> ';
        }
        $data['categories_heading'] = wfMessage('settlein-skin-mainpage-section-categories-heading', count($categories), SiteStats::articles())->plain();

        $requests_count = count( SettleArticleRequest::find(array(
                'request_status' => SettleArticleRequest::STATUS_OPEN
        )) );
        $data['requests_heading'] = wfMessage('settlein-skin-mainpage-section-requests-heading', $requests_count)->plain();
        $data['requests_link'] = SpecialPage::getTitleFor('SettleRequestsList')->getFullURL();

        // Format statistics string
        $pages = SiteStats::pagesInNs(NS_MAIN);
        $countries = 0;
        $languages = 2;
        $users = SiteStats::users();

        // Special handling for countries
        // TODO: imported from SpecialSettleCategorySearch, remove duplication
        // TODO: cache this
		$query = SphinxStore::getInstance()->getQuery();
        foreach ($this->countriesList as $country) {
	        $result = $query->query( 'SELECT id, IN( properties.country_code, ' . $country['geonamesCode'].' ) AS p FROM '.SphinxStore::getInstance()->getIndex().' WHERE p = 1')->execute();
            if( $result->count() ) {
                $countries++;
            }
        }

        $data['statistics_string_formatted'] = wfMessage('settlein-skin-mainpage-section-statistics-formatted')
            ->params( $pages, $countries, $languages, $users )
            ->plain();

        $templater = new TemplateParser( dirname(__FILE__).'/templates', true );
        $html = $templater->processTemplate('landing', $data);
        echo $html;

    }

	private function printSlideMenu() {
	    ?>
        <!-- Slideout menu start -->
        <div id="slideout">

            <? if( $this->isLoggedIn ): ?>
	        <div class="slide-userpanel">
		        <img src="<?=$this->profile_image?>"
		             class="img-circle user-avatar"
		        />
		        <div class="user-name">
                    <b><?=$this->user->getName()?></b>
                    <a title="<?=wfMessage( 'settlein-skin-header-usermenu-profile' )->plain()?>" style="color: white;" href="<?=SpecialPage::getSafeTitleFor('UserProfile')->getFullURL()?>">
                        <i class="glyphicon glyphicon-cog"></i>
                    </a>
                </div>
                <a class="badge badge-berry mobile-notifications-badge" href="#">
                    15 <i class="glyphicon glyphicon-bell"></i></a>
	        </div>

            <ul class="nav nav-pills nav-stacked">
                <li>
                    <a href="<?=SpecialPage::getTitleFor('SettleNewArticle')->getFullURL()?>" class="add-new-article-btn"><i class="glyphicon glyphicon-plus"></i> <?=wfMessage('settlein-skin-add-new-article-button')->plain()?></a>
                </li>

                <? if( $this->isCardPage): ?>
                    <? if($this->isLoggedIn): ?>
                        <li class="user-panel-watchlist-action">
                            <a href="#" title="<?=wfMessage('customwatchlist-add')->plain()?>">
                                <i class="glyphicon glyphicon-eye-open"></i>
                                <?=wfMessage('customwatchlist-add')->plain()?>
                            </a>
                        </li>
                    <? endif; ?>
                    <li>
                        <a class="faq-menu" href="#" data-toggle="modal" data-target="#myModal" >
                            <i class="glyphicon glyphicon-question-sign"></i>
                            <?=wfMessage( 'settlein-skin-header-help-link' )->plain()?>
                        </a>
                    </li>
                <? else: ?>

                <!--<li>
		            <a href="#">Page actions</a>
	            </li>-->

                <div class="panel panel-default">
                    <div class="panel-heading">Page actions</div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">

                        <!-- Views actions -->
                        <? if( count($this->data['view_urls']) ): ?>
                            <?php
                            foreach ( $this->data['view_urls'] as $link ) {
                                ?>
                                <li id="<?=$link['id']?>">
                                    <a href="<?php echo htmlspecialchars( $link['href'] )?>"><?php echo htmlspecialchars( $link['text'] )?></a>
                                </li>
                                <?php
                            }
                            ?>
                        <? endif; ?>

                        <!-- Modify actions -->
                        <? if(count($this->data['action_urls'])): ?>
                            <?php
                            foreach ( $this->data['action_urls'] as $link ) {
                                ?>
                                <li id="<?=$link['id']?>">
                                    <a href="<?php echo htmlspecialchars( $link['href'] )?>"><?php echo htmlspecialchars( $link['text'] )?></a>
                                </li>
                                <?php
                            }
                            ?>
                        <? endif; ?>

                        <!-- Toolbox -->
                        <? foreach( $this->getToolbox() as $key => $item ) {
                            echo $this->makeListItem( $key, $item );
                        }?>

                        </ul>
                    </div>
                </div>

                <? endif; ?>

                <li>
                    <a role="button" data-toggle="collapse" href="#side-language-selector" aria-expanded="false" aria-controls="side-language-selector">
                        <i class="glyphicon glyphicon-font"></i>
                        <?=wfMessage('settlein-skin-side-panel-change-language')->plain()?>
                    </a>
                    <div class="collapse language-selection-action" id="side-language-selector">
                        <ul>
                            <?php
                            global $wgSettleTranslateDomains;
                            $shiftedLangs = array_slice($this->connectedLanguagesList, 1); // Exclude current language
                            ?>
	                        <? foreach ( $shiftedLangs as $langCode => $langText ): ?>
                                <li>
                                    <a target="_blank" href="//<?=$wgSettleTranslateDomains[$langCode]?>"><?=$langText?></a>
                                </li>
	                        <? endforeach; ?>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="<?=SpecialPage::getSafeTitleFor('UserLogout')->getFullURL()?>">
                        <i class="glyphicon glyphicon-log-in"></i>
                        <?=wfMessage( 'settlein-skin-header-usermenu-logout' )->plain()?>
                    </a>
                </li>
            </ul>

            <? else: ?>

                <ul class="nav nav-pills nav-stacked">
                    <li class="login-selector">
                        <a href="<?=SpecialPage::getSafeTitleFor('Userlogin')->getFullURL()?>" ><b>
                                <?=wfMessage( 'settlein-skin-header-login' )->plain()?>
                            </b></a>
                    </li>
                    <li class="register-selector">
                        <a href="<?=SpecialPage::getSafeTitleFor('Userlogin')->getFullURL('type=signup')?>" ><b>
                                <?=wfMessage( 'settlein-skin-header-signup' )->plain()?>
                            </b></a>
                    </li>
                    <li id="why_signup">
                        <a href="#">
                            <?=wfMessage( 'settlein-skin-header-why-signup' )->plain()?>
                        </a>
                    </li>
                    <? if( $this->isCardPage): ?>
                        <li>
                            <a class="faq-menu" href="#" data-toggle="modal" data-target="#myModal" >
                                <i class="glyphicon glyphicon-question-sign"></i>
                                <?=wfMessage( 'settlein-skin-header-help-link' )->plain()?>
                            </a>
                        </li>
                    <? endif; ?>
                </ul>

            <? endif; ?>

        </div>
        <!-- /Slideout menu end -->
        <?
    }

	private function printMainPage() {

	    $this->printHeader();

	?>

    <!-- Wrapper     ----------------------------------------------------------------------------------------------  -->
    <div id="main-wrapper">

    <!-- Main start -->
    <section>

            <div class="jumbotron">

                <!-- Dynamic slider for main page background -->
                <div class="jumbo-slider-backlay">
                    <div class="slider-backlay-slide">
                        <img src="<?=$this->getSkin()->getSkinStylePath("/img/slider/1.jpg")?>" />
                    </div>
                    <div class="slider-backlay-slide">
                        <img src="<?=$this->getSkin()->getSkinStylePath("/img/slider/2.jpg")?>" />
                    </div>
                    <div class="slider-backlay-slide">
                        <img src="<?=$this->getSkin()->getSkinStylePath("/img/slider/3.jpg")?>" />
                    </div>
                </div>
                <!-- /Dynamic slider -->

                <div class="jumbo-content">

                    <div class="i-jumbotext">
                        <h1><?=wfMessage( 'settlein-skin-mainpage-jumbotron-title' )->plain()?></h1>
                    </div>

                    <form role="search" action="<?=SettleGeoSearch::getSearchPageUrl()?>" id="searchform_smw" method="post">

                    <div class="jumbo-search">
                        <? $settlesearch = new SettleGeoSearch(); ?>
                        <?=$settlesearch->getHtml( SettleGeoSearch::SGS_MODE_TEXT, 'geo_id' ); ?>
                        <input type="text" placeholder="<?=wfMessage('sil-search-form-field-label-search')->plain()?>" name="geo_text" class="form-control selectize-search-appendix" />
                        <a href="#" class="search-submit fa fa-search"></a>
                    </div>

                    <input type="hidden" name="query" value="true" />
                    <input type="hidden" value="" name="sf_free_text">
                    <input type="hidden" value="Search" name="wpRunQuery">

                    </form>

                    <div class="i-jumbotext">
                    <p>
                        <?=wfMessage( 'settlein-skin-mainpage-jumbotron-text' )->plain()?>
                    </p>
                    </div>


                </div>

            </div>

            <div class="jumbo-addition">
                <div class="container">

                    <ul class="pull-left">
                        <li>
                            <a id="faq-menu" href="#" data-toggle="modal" data-target="#myModal" style="" >
                                <?=wfMessage('settlein-skin-mainpage-faq')->plain()?>
                            </a>
                        </li>
                    </ul>
                    <ul class="pull-right">
                        <li><a href="#" id="menu-hiw">
                                <?=wfMessage('settlein-skin-mainpage-howitworks')->plain()?>
                                <b class="caret"></b></a></li>
                    </ul>

                    <div class="play-video-button">
                        <a href="#" data-toggle="modal" data-target="#videoModal" style="font-size: 20px; font-family: Arial; " >
                            <img src="<?=$this->getSkin()->getSkinStylePath("/img/pl3_1.png")?>" width="31" />
                        </a>
                    </div>
                </div>

                <div class="">
                    <!-- hiw -->
                    <div id="megamenu">
                        <div class="container">

                            <div class="row">

                                <div class="col-md-4">

                                    <span class="fa-stack fa">
                                        <i class="fa fa-circle-thin fa-stack-2x"></i>
                                        <i class="fa fa-stack-1x">1</i>
                                    </span>

                                    <div class="step-text">
                                        <span><?=wfMessage('settlein-skin-mainpage-howitworks-section-1-title')->plain()?></span>
                                        <p><?=wfMessage('settlein-skin-mainpage-howitworks-section-1-text')->plain()?></p>
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <span class="fa-stack fa">
                                        <i class="fa fa-circle-thin fa-stack-2x"></i>
                                        <i class="fa fa-stack-1x">2</i>
                                    </span>

                                    <div class="step-text">
                                        <span><?=wfMessage('settlein-skin-mainpage-howitworks-section-2-title')->plain()?></span>
                                        <p><?=wfMessage('settlein-skin-mainpage-howitworks-section-2-text')->plain()?></p>
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <span class="fa-stack fa">
                                        <i class="fa fa-circle-thin fa-stack-2x"></i>
                                        <i class="fa fa-stack-1x">3</i>
                                    </span>

                                    <div class="step-text">
                                        <span><?=wfMessage('settlein-skin-mainpage-howitworks-section-3-title')->plain()?></span>
                                        <p><?=wfMessage('settlein-skin-mainpage-howitworks-section-3-text')->plain()?></p>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div><!-- hiw -->
                </div>

            </div>

            <div class="container-fluid" id="home-icons">
                <div class="row hidden-xs">
                    <div class="home-col col-md-12">

                    </div>
                </div>
                <div class="row hidden-sm hidden-md hidden-lg">
                    <div class="col-home-mobile col-xs-12">
                        <img src="<?=$this->getSkin()->getSkinStylePath("/img/slices/slice_car.png");?>" />
                    </div>
                    <div class="col-home-mobile col-xs-12">
                        <img src="<?=$this->getSkin()->getSkinStylePath("/img/slices/slice_home.png");?>" />
                    </div>
                    <div class="col-home-mobile col-xs-12">
                        <img src="<?=$this->getSkin()->getSkinStylePath("/img/slices/slice_help.png");?>" />
                    </div>
                </div>
                <div class="row">

                </div>
            </div>

            <div class="jumbotron jumbotron-middle">
                <h3><?=wfMessage('settlein-skin-mainpage-bottom-title')->plain()?></h3>
                <p>
                    <?=wfMessage( 'settlein-skin-mainpage-bottom-text' )->plain()?>
                </p>
                <a href="<?=SpecialPage::getSafeTitleFor('Userlogin')->getFullURL('type=signup')?>" class="btn btn-settle-orange">
                    <?=wfMessage( 'settlein-skin-mainpage-bottom-button-text' )->plain() ?>
                </a>
            </div>

            <!-- content end -->

        </section>
        <!-- Main end -->

    </div>

    <!-- Modal ? -->
    <div class="modal fade container fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none; margin-top: -73px;">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myLargeModalLabel">
                <?=wfMessage( 'settlein-skin-modal-faq-title' )->plain()?>
            </h4>
        </div>
        <div class="modal-body">
            <?=wfMessage('settlein-skin-modal-faq-text')->plain()?>
        </div>
    </div>

    <!-- Video modal -->

    <div class="modal fade container fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoLargeModalLabel" aria-hidden="true" style="display: none; margin-top: -73px;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="videoLargeModalLabel">
                <?=wfMessage('settlein-skin-modal-video-title')->plain()?>
            </h4>
        </div>
        <div class="modal-body">
            <div class="fluid-width-video-wrapper">
                <iframe height="500" src="http://www.youtube.com/embed/41QFL4QB3NE" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>

	<?
        $this->printFooter();
	}

	private function printNormalPage() {

        if( $this->isCardPage ) {
            $this->printHeaderForm();
            ?>
                <? print $this->data['bodycontent']; ?>
            <?
            $this->printFooterForm();
        }else{
            $this->printHeader(); // print header same for all pages
            ?>
            <? if( $this->cleanPage ): ?>
                <?
                print $this->data['bodycontent']; // page content itself
                ?>
            <? else: ?>
            <div id="normal-wrapper" class="container">
            <?
                print $this->data['bodycontent']; // page content itself
            ?>
            </div>
            <? endif; ?>
            <?
            $this->printFooter();
        }
	}

	private function printFooterForm() {
	    ?>
<!--<div id="bottom-footer">
    <div class="bottom-footer-badge">
        <i class="fa fa-chevron-up"></i>
    </div>
    <div class="bottom-footer-content">
        <div class="container">
            <ul class="nav navbar-nav footer-menu-items">
                <li>
                    <a href="<?=SpecialPage::getTitleFor('SettleIn')->getFullURL()?>/about">
                        <?=wfMessage('settlein-skin-footer-about-us')->plain()?>
                    </a>
                </li>
                <li>
                    <a href="<?=SpecialPage::getTitleFor('SettleIn')->getFullURL()?>/contact">
                        <?=wfMessage('settlein-skin-footer-contact')->plain()?>
                    </a>
                </li>
                <li>
                    <a href="<?=Title::newFromText('Help Out', NS_PROJECT)->getFullURL()?>">
                        <?=wfMessage('settlein-skin-footer-helpout')->plain()?>
                    </a>
                </li>
                <li>
                    <a href="<?=SpecialPage::getTitleFor('SettleIn')->getFullURL()?>/tos">
                        <?=wfMessage('settlein-skin-footer-tos')->plain()?>
                    </a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right col-xs-12 col-sm-2 footer-social-icons">
                <li class="col-xs-4">
                    <a target="_blank" href="<?=$this->config->get('SettleinTwitterURL')?>">
                        <i class="fa fa-twitter"></i>
                    </a>
                </li>
                <li class="col-xs-4">
                    <a target="_blank" href="<?=$this->config->get('SettleinFacebookURL')?>">
                        <i class="fa fa-facebook"></i>
                    </a>
                </li>
                <li class="col-xs-4">
                    <a target="_blank" href="<?=$this->config->get('SettleinGoogleURL')?>">
                        <i class="fa fa-google-plus"></i>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>-->

<!-- Modal ? -->
<div class="modal fade container fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none; margin-top: -150px;">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myLargeModalLabel">
            <?=wfMessage('settlein-skin-modal-help-title')->plain()?>
        </h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <h2>
                    <?=wfMessage('settlein-skin-modal-help-title-col-1')->plain()?>
                </h2>
                <?=wfMessage('settlein-skin-modal-help-text-col-1')->plain()?>

            </div>
            <div class="col-md-6">
                <h2>
                    <?=wfMessage('settlein-skin-modal-help-title-col-2')->plain()?>
                </h2>
                <?=wfMessage('settlein-skin-modal-help-text-col-2')->plain()?>

            </div>
        </div>
    </div>
</div>
	    <?
	}

    private function printFooter() {
?>
<!-- footer -->
    <footer class="footer">
        <div class="container">
            <ul class="nav navbar-nav footer-menu-items">
                <li>
                    <a href="<?=SpecialPage::getTitleFor('SettleIn')->getFullURL()?>/about">
                        <?=wfMessage('settlein-skin-footer-about-us')->plain()?>
                    </a>
                </li>
                <li>
                    <a href="<?=SpecialPage::getTitleFor('SettleIn')->getFullURL()?>/contact">
                        <?=wfMessage('settlein-skin-footer-contact')->plain()?>
                    </a>
                </li>
                <li>
                    <a href="<?=Title::newFromText('Help Out', NS_PROJECT)->getFullURL()?>">
                        <?=wfMessage('settlein-skin-footer-helpout')->plain()?>
                    </a>
                </li>
                <li>
                    <a href="<?=SpecialPage::getTitleFor('SettleIn')->getFullURL()?>/tos">
                        <?=wfMessage('settlein-skin-footer-tos')->plain()?>
                    </a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right col-xs-12 col-sm-2 footer-social-icons">
                <li class="col-xs-4 text-center">
                    <a target="_blank" href="<?=$this->config->get('SettleinTwitterURL')?>">
                        <i class="fa fa-twitter"></i>
                    </a>
                </li>
                <li class="col-xs-4 text-center">
                    <a target="_blank" href="<?=$this->config->get('SettleinFacebookURL')?>">
                        <i class="fa fa-facebook"></i>
                    </a>
                </li>
                <li class="col-xs-4 text-center">
                    <a target="_blank" href="<?=$this->config->get('SettleinGoogleURL')?>">
                        <i class="fa fa-google-plus"></i>
                    </a>
                </li>
            </ul>

        </div>
    </footer>
    <?
    }

    private function printHeader() {
    ?>
    <!-- Navigation -----------------------------------------------------------------------------------------------  -->
    <div id="nav">
    <div class="container">
        <nav class="navbar">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand normal-logo" href="<?=Title::newMainPage()->getFullURL()?>">
                    <svg id="lettermark_normal_logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 164 41">
                        <style>
                            .st0{opacity:0;fill:#FFFFFF;} .st1{fill:#27AAE1;} .st2{fill:#3EB649;} .st3{fill-rule:evenodd;clip-rule:evenodd;fill:#FEE400;}
                        </style>
                        <path class="st0" d="M0 0h164v41H0z"/>
                        <path class="st1" d="M57.1 26.9H31.3c.3 2.9 1.5 5.3 3.7 7.1 2.1 1.9 4.7 2.8 7.6 2.8 4.5-.1 7.8-2.2 9.7-6.3h4.1c-1.1 3.1-2.9 5.5-5.4 7.3-2.6 1.8-5.4 2.7-8.5 2.8-3.9.1-7.4-1.4-10.4-4.3s-4.6-6.4-4.6-10.5c-.1-4.3 1.4-8 4.6-11.1 3.1-3.1 6.8-4.5 11.1-4.3 3.8.2 7.1 1.8 10 4.7 2.7 2.9 4.1 6.1 4.1 9.7v2.1zm-3.8-3.5c-.5-2.7-1.8-4.9-3.8-6.5-2-1.7-4.3-2.5-7.1-2.5s-5.2.8-7.2 2.5c-2.1 1.7-3.4 3.9-3.9 6.6h22zM71 40.5c-7 0-10.5-3-10.5-8.9V1.2h3.8v10H71v3.6h-6.6V31c0 4.3 2.2 6.4 6.6 6.4v3.1zM84.8 40.5c-7 0-10.5-3-10.5-8.9V1.2h3.8v10h6.6v3.6h-6.6V31c0 4.3 2.2 6.4 6.6 6.4v3.1zM126.1 26.9h-25.8c.3 2.9 1.5 5.3 3.7 7.1 2.1 1.9 4.7 2.8 7.6 2.8 4.5-.1 7.8-2.2 9.7-6.3h4.1c-1.1 3.1-2.9 5.5-5.4 7.3-2.6 1.8-5.4 2.7-8.5 2.8-3.9.1-7.4-1.4-10.4-4.3s-4.6-6.4-4.6-10.5c-.1-4.3 1.4-8 4.6-11.1 3.1-3.1 6.8-4.5 11.1-4.3 3.8.2 7.1 1.8 10 4.7 2.7 2.9 4.1 6.1 4.1 9.7v2.1zm-3.8-3.5c-.5-2.7-1.8-4.9-3.8-6.5-2-1.7-4.3-2.5-7.1-2.5s-5.2.8-7.2 2.5c-2.1 1.7-3.4 3.9-3.9 6.6h22z"/>
                        <path class="st2" d="M129.5 11.2h3.8v29.4h-3.8zM162.8 40.6H159V23.2c0-2.4-.9-4.5-2.7-6.2-1.8-1.7-3.8-2.6-6.2-2.6-2.4 0-4.5.9-6.3 2.6-1.8 1.7-2.7 3.8-2.7 6.2v17.4h-3.8v-17c0-3.7 1.2-6.8 3.6-9.3 2.4-2.5 5.5-3.7 9.1-3.7 3.6 0 6.6 1.2 9.1 3.7 2.4 2.5 3.6 5.6 3.6 9.3v17z"/>
                        <path class="st3" d="M133.6 1.1c-.1 0-.1 0 0 0-.5-.5-1.2-.9-2.1-.9h-.2c-.9 0-1.5.4-2 .8l-.1.1c-.4.5-.8 1.1-.8 2v.1c0 .8.3 1.2.6 1.8l.9 1.5c.6 1 1.2 2 1.5 3.2.3-1.3.9-2.3 1.5-3.2.3-.5.6-.9.9-1.4.1-.2.3-.5.4-.8.1-.3.2-.6.2-1v-.1c0-1-.4-1.6-.8-2.1zM131.4 4c-.5 0-.9-.4-.9-.9s.4-.9.9-.9.9.4.9.9-.4.9-.9.9z"/>
                        <path class="st1" d="M13.8 40.8c-2.7 0-4.9-.4-6.7-1.2-1.8-.8-3.2-2-4.3-3.5-1-1.6-1.6-3.4-1.6-5.3l3.7-.3c.2 1.5.6 2.7 1.2 3.6.6.9 1.6 1.7 3 2.3 1.3.6 2.9.9 4.5.9 1.5 0 2.8-.2 4-.7 1.1-.4 2-1.1 2.6-1.8.6-.8.8-1.6.8-2.5 0-.9-.3-1.7-.8-2.4s-1.4-1.3-2.7-1.7c-.8-.3-2.6-.8-5.3-1.4-2.7-.6-4.6-1.3-5.7-1.8-1.4-1-2.4-1.9-3.1-3-.7-1.1-1-2.3-1-3.7 0-1.5.4-2.9 1.3-4.2.8-1.3 2.1-2.3 3.7-3 1.6-.7 3.5-1 5.4-1 2.2 0 4.1.4 5.8 1.1 1.7.7 3 1.8 3.9 3.1.9 1.4 1.4 2.9 1.5 4.7l-3.8.3c-.2-1.9-.9-3.3-2-4.2-1.2-1-2.9-1.4-5.2-1.4-2.4 0-4.1.4-5.2 1.3-1.1.9-1.6 1.9-1.6 3.1 0 1.1.4 1.9 1.2 2.6.7.7 2.7 1.4 5.9 2.1 3.2.7 5.4 1.4 6.5 1.9 1.7.8 3 1.8 3.8 3 .8 1.2 1.2 2.6 1.2 4.2s-.5 3.1-1.4 4.5c-.9 1.4-2.2 2.5-3.9 3.3-1.7.7-3.6 1.1-5.7 1.1zM88.2 1.1H92v39.4h-3.8z"/>
                    </svg>
                </a>

                <!-- Header search block for "normal" pages -->
                <!-- This block should be excluded on Search page to prevent conflicts -->
                <? if( $this->getSkin()->getTitle()->equals( SpecialPage::getTitleFor('SettleGeoSearch')->getBaseTitle() ) || $this->getSkin()->getTitle()->isMainPage() ): ?>
                    <!-- No search block on Search results page -->
                <? else: ?>
                <ul class="nav navbar-nav normal-page-country-block" id="country-select-wrapper">
                    <form role="search" action="<?=SettleGeoSearch::getSearchPageUrl()?>" id="searchform_smw" method="post">
                        <?php
                        $search = new SettleGeoSearch();
                        echo $search->getHtml( SettleGeoSearch::SGS_MODE_VALUE, 'geo_id' );
                        ?>
                        <input type="text" placeholder="<?=wfMessage('sil-search-form-field-label-search')->plain()?>" name="geo_text" class="form-control selectize-search-appendix" />
                        <a href="#" class="search-submit fa fa-search"></a>
                    </form>
                </ul>
                <? endif; ?>

            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav navbar-right">

                    <? if( $this->isLoggedIn ) :?>
                        <li id="userpanel" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?=$this->profile_image?>"
                                        class="img-circle user-avatar"
                                        />
                                <span class="user-name">
                                    <b><?=$this->user->getName()?></b>
                                </span>
                            <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu primary-back">
                                <li><a href="<?=SpecialPage::getSafeTitleFor('UserProfile')->getFullURL()?>">
                                        <?=wfMessage( 'settlein-skin-header-usermenu-profile' )->plain()?>
                                    </a></li>
                                <li><a href="<?=SpecialPage::getSafeTitleFor('UserLogout')->getFullURL()?>">
                                        <?=wfMessage( 'settlein-skin-header-usermenu-logout' )->plain()?>
                                    </a></li>
                            </ul>
                        </li>
                        <li id="useractions" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span>
                                <?=wfMessage( 'settlein-skin-header-menu-page' )->plain()?> <i class="caret"></i>
                            </span>
                            </a>
                            <ul class="dropdown-menu primary-back">
                                <? if( count($this->data['view_urls'])): ?>
                                <li class="dropdown-header">
                                    <?=wfMessage( 'settlein-skin-header-menu-page-section-primary' )->plain()?>
                                </li>
                                <?php
								foreach ( $this->data['view_urls'] as $link ) {
									?>
									<li id="<?=$link['key']?>">
										<a href="<?php echo htmlspecialchars( $link['href'] )?>"><?php echo htmlspecialchars( $link['text'] )?></a>
									</li>
								<?php
								}
								?>
								<? endif; ?>
								<? if(count($this->data['action_urls'])): ?>
								<li class="dropdown-header">
                                    <?=wfMessage( 'settlein-skin-header-menu-page-section-secondary' )->plain()?>
                                </li>
								<?php
								foreach ( $this->data['action_urls'] as $link ) {
									?>
									<li id="<?=$link['key']?>">
										<a href="<?php echo htmlspecialchars( $link['href'] )?>"><?php echo htmlspecialchars( $link['text'] )?></a>
									</li>
								<?php
								}
								?>
								<? endif; ?>
								<li class="dropdown-header">
                                    <?=wfMessage( 'settlein-skin-header-menu-page-section-tools' )->plain()?>
                                </li>
								<? foreach( $this->getToolbox() as $key => $item ) {
								    echo $this->makeListItem( $key, $item );
								}?>
                            </ul>
                        </li>
                        <li>
                            <a href="<?=SpecialPage::getTitleFor('SettleNewArticle')->getFullURL()?>" class="add-new-article-btn"><b><?=wfMessage('settlein-skin-add-new-article-button')->plain()?></b></a>
                        </li>
                    <? else: ?>
                        <li id="why_signup">
                            <a href="#">
                                <?=wfMessage( 'settlein-skin-header-why-signup' )->plain()?>
                            </a>
                        </li>
                        <li class="btn-group-nav" id="login-selector">
                            <a href="<?=SpecialPage::getSafeTitleFor('Userlogin')->getFullURL()?>" ><b>
                                    <?=wfMessage( 'settlein-skin-header-login' )->plain()?>
                                </b></a>
                        </li>

                        <li class="header-menu-divider hidden-xs">
                            |
                        </li>

                        <li class="btn-group-nav" id="register-selector">
                            <a href="<?=SpecialPage::getSafeTitleFor('Userlogin')->getFullURL('type=signup')?>" ><b>
                                    <?=wfMessage( 'settlein-skin-header-signup' )->plain()?>
                                </b></a>
                        </li>
                    <? endif; ?>

                </ul>

            </div>

            </nav>
        </div>

    </div>
    <?
    }

	private function printHeaderForm() {
?>
<div id="nav">
    <div class="container-fluid">
        <nav class="navbar row">

            <div class="navbar-header col-md-6">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=Title::newMainPage()->getFullURL()?>">
                    <svg id="mark_svg_logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 37">
                        <style>
                            .st0{opacity:0;} .st1{fill:#FFFFFF;} .st2{fill:#3EB649;} .st3{fill:#FEE400;}
                        </style>
                        <path class="st0 st1" d="M0 0h30v37H0z"/>
                        <path class="st2" d="M16.7 18.8c-2 .3-4.4-.2-5.2-2.6-.3-1-.2-2.1.3-3 .5-.9 1.3-1.6 2.3-1.9 2.1-.7 4.3.5 5 2.6 0 .1 0 .2.1.3l2.5-1v-.1c-1.1-3.5-4.8-5.4-8.3-4.3-1.7.5-3.1 1.7-3.9 3.2-.8 1.6-1 3.4-.5 5 1 3.3 4.2 5 8.1 4.4 2-.4 4.4.3 5.1 2.6 2.2 6.6-5.4 9.3-7.1 10-2.9-2.2-5.3-4.6-7.3-7.1l-2.2 1.6c2.2 2.8 5.1 5.6 8.5 8.1l.2.1c.2.1.4.1.6.1.3 0 .5-.1.8-.2l-.2.1c4.1-1.3 11.9-5.7 9.1-13.5-1-3.3-4.2-5.1-7.9-4.4z"/>
                        <path class="st2" d="M15 .2C6.9.2.3 6.8.3 14.9c0 2.7.7 5.4 2 8.2L4.7 22c-1.2-2.4-1.8-4.8-1.8-7.1C2.9 8.2 8.3 2.8 15 2.8c6.7 0 12.1 5.4 12.1 12.1 0 .8-.1 1.6-.2 2.4.8.8 1.5 1.8 2 2.9.6-1.8.9-3.6.9-5.4C29.8 6.8 23.1.2 15 .2z"/>
                        <circle class="st3" cx="5" cy="25.3" r="1.8"/>
                    </svg>
                </a>
                <ul class="nav navbar-nav" id="country-select-wrapper">
                    <form role="search" action="<?=SettleGeoSearch::getSearchPageUrl()?>" id="searchform_smw" method="post">
                        <?php
                        $search = new SettleGeoSearch();
                        echo $search->getHtml( SettleGeoSearch::SGS_MODE_VALUE, 'geo_id' );
                        ?>
                        <input type="text" placeholder="<?=wfMessage('sil-search-form-field-label-search')->plain()?>" name="geo_text" class="form-control selectize-search-appendix" />
                        <a href="#" class="search-submit fa fa-search"></a>
                    </form>
                </ul>
                <!--<ul class="nav navbar-nav navbar-faq-menu">
                    <li>
                        <a id="faq-menu" href="#" data-toggle="modal" data-target="#myModal" style="" >
                            <?/*=wfMessage( 'settlein-skin-header-help-link' )->plain()*/?>
                        </a>
                    </li>
                </ul>-->
            </div>

            <div class="col-md-6" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav navbar-right" id="right-side-actions">

                    <? if( $this->isLoggedIn ) :?>

                    <!-- Watchlist icon -->
                    <li class="btn-group-nav user-panel-watchlist-action" id="user-panel-watchlist">
                        <a href="#">
                            <!--<span class="fa-stack">
                                <i class="fa fa-list fa-stack-1x"></i>
                                <i class="fa fa-plus fa-stack-1x"></i>
                            </span>-->
                        </a>
                    </li>

                    <li class="btn-group-nav" id="user-panel-bell">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <!--<span class="fa-add-count">3</span>-->
                        </a>
                        <div class="dropdown-menu primary-back">
                            <!--<b>You have 3 unread notifications:</b>
                            <ul>
                                <li>
                                    <a href="#">
                                        Sample notification one
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Sample notification two
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Sample notification three
                                    </a>
                                </li>
                            </ul>
                            <a href="#" class="pull-right">
                                Click to see all..
                            </a>-->
                            <?=wfMessage( 'settlein-skin-header-notifications-empty' )->plain()?>
                        </div>
                    </li>
                    <? endif; ?>

                    <li>
                        <a class="faq-menu" href="#" data-toggle="modal" data-target="#myModal" >
			                <?=wfMessage( 'settlein-skin-header-help-link' )->plain()?>
                        </a>
                    </li>

                    <? if( $this->isLoggedIn ): ?>

                    <li class="btn-group-nav" id="user-panel-selector">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user"></i>
                            <?=$this->user->getName()?>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu primary-back">
                            <li><a href="<?=SpecialPage::getSafeTitleFor('Preferences')->getFullURL()?>">
                                    <?=wfMessage( 'settlein-skin-header-usermenu-profile' )->plain()?>
                                </a></li>
                            <li><a href="<?=SpecialPage::getSafeTitleFor('UserLogout')->getFullURL()?>">
                                    <?=wfMessage( 'settlein-skin-header-usermenu-logout' )->plain()?>
                                </a></li>
                        </ul>
                    </li>

                    <li class="btn-group-nav">
                        <a href="<?=SpecialPage::getTitleFor('SettleNewArticle')->getFullURL()?>" class="add-new-article-btn"><b><?=wfMessage('settlein-skin-add-new-article-button')->plain()?></b></a>
                    </li>

                    <? else: ?>

                    <li class="btn-group-nav login-selector" id="login-selector">
                        <a href="#">
                            <!--<i class="fa fa-lock"></i>-->
                            <?=wfMessage( 'settlein-skin-header-login' )->plain()?>
                        </a>
                    </li>

                    <? endif; ?>

                    <li class="dropdown language-selection-action" id="language-selector">
	                    <?php
	                    global $wgSettleTranslateDomains;
	                    $shiftedLangs = array_slice($this->connectedLanguagesList, 1); // Exclude current language
	                    ?>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?=array_keys($this->connectedLanguagesList)[0]?>
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu primary-back">
	                        <? foreach ( $shiftedLangs as $langCode => $langText ): ?>
                                <li>
                                    <a target="_blank" href="//<?=$wgSettleTranslateDomains[$langCode]?>"><?=$langText?></a>
                                </li>
	                        <? endforeach; ?>
                        </ul>
                    </li>

                </ul>

                <? if( !$this->isLoggedIn ) :?>
                    <!--<div id="why_signup">
                        <a href="#">
                            <?/*=wfMessage( 'settlein-skin-header-why-signup' )->plain()*/?>
                        </a>
                    </div>-->
                <? endif; ?>

            </div>

        </nav>
    </div>

</div>
<?
	}

	private function printFooterThings() {

	    if ( $this->isMainPage ) {
	        return false;
        }

	    // prepare login token:
	    $loginToken = MWCryptRand::generateHex( 32 );
	    if( $this->getSkin()->getTitle()->getText() != 'UserLogin' ) {
	    // Skin userlogin page to avoid collision
            if( session_id() == '' ) {
                wfSetupSession();
            }
	        $this->getSkin()->getRequest()->setSessionData( 'wsLoginToken', $loginToken );
	    }

	?>

<div class="why-sign-up-popup mobile-form-popup">
    <h3>
        <?=wfMessage( 'settlein-skin-modal-whysignup-title' )->plain()?>
    </h3>

    <?=wfMessage( 'settlein-skin-modal-whysignup-text' )->plain()?>

</div>

<!-- Login popup form & wrapper -->
<div id="login-popup-wrapper">
</div>

<div class="login-popup-form mobile-form-popup">
    <h3>
        <?=wfMessage( 'settlein-skin-modal-login-title' )->plain()?>
    </h3>

    <div class="row login-popup-form-social-block">
        <div class="col-xs-12">
            <?php echo OpauthLogin::getButtonsMarkup() ?>
        </div>
    </div>

    <p>
        <?=wfMessage( 'settlein-skin-modal-login-subtitle' )->plain()?>
    </p>

    <form class="" method="post" action="<?=SpecialPage::getSafeTitleFor('UserLogin')->getFullURL('action=submitlogin&type=login')?>">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="<?=wfMessage( 'settlein-skin-modal-login-email-placeholder' )->plain()?>" name="wpName" />
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="<?=wfMessage( 'settlein-skin-modal-login-password-placeholder' )->plain()?>" name="wpPassword" />
        </div>
        <input type="hidden" name="wpLoginToken" value="<?=$loginToken?>" />
        <input type="hidden" name="wpRemember" value="1" />
        <div class="form-group">
            <input type="submit" name="wpLoginAttempt" class="btn btn-primary" value="<?=wfMessage( 'settlein-skin-modal-login-login-button' )->plain()?>"/>
            <a href="<?=SpecialPage::getSafeTitleFor('Userlogin')->getFullURL('type=signup')?>" class="btn btn-cyanide">
                <?=wfMessage( 'settlein-skin-modal-login-signup-button' )->plain()?>
            </a>
            <a href="<?=SpecialPage::getSafeTitleFor('PasswordReset')->getFullURL()?>" class="pull-right">
                <?=wfMessage( 'settlein-skin-modal-login-reset-password' )->plain()?>
            </a>
        </div>
    </form>
</div>

<!-- Add new article popup form & wrapper -->
<!--<div id="add-new-article-popup-wrapper">
</div>

<div class="add-new-article-popup-form">
    <h3>
	    <?=wfMessage('settlein-skin-add-new-article-window-title')->plain()?>
    </h3>
	<p>
		<?=wfMessage('settlein-skin-add-new-article-window-description')->plain()?>
	</p>
	<form class="" method="post" action="" >
		<div class="form-group">
			<label for="new_pageTitle"><?=wfMessage('settlein-skin-add-new-article-window-form-field-title')->plain()?></label>
			<input type="text" class="form-control" placeholder="" name="Card[Title]" id="new_pageTitle" />
		</div>
		<div class="form-group">
			<label for="new_pageCategory"><?=wfMessage('settlein-skin-add-new-article-window-form-field-category')->plain()?></label>
			<select class="form-control" name="Card[Tags]" id="new_pageCategory">
                <option></option>
				<? foreach ( $this->categoriesList as $category ): ?>
                    <option value="<?=$category?>"><?=$category?></option>
                <? endforeach; ?>
			</select>
		</div>
		<div class="form-group settle-geo-input" data-geo-type="country" data-state-input-name="new_pageState" data-city-input-name="new_pageCity">
			<label for="new_pageCountry"><?=wfMessage('settlein-skin-add-new-article-window-form-field-country')->plain()?></label>
			<select class="form-control" name="Card[Country]" id="new_pageCountry">
                <option></option>
				<?
				foreach ($this->countriesList as $val) {
					?>
					<option data-geo-id="<?=$val['geonamesCode']?>" value="<?=$val['name']?>"><?=$val['name']?></option>
					<?
				}
				?>
			</select>
		</div>
        <div class="form-group settle-geo-input" data-geo-type="state" data-city-input-name="new_pageCity">
            <label for="new_pageState"><?=wfMessage('settlein-skin-add-new-article-window-form-field-state')->plain()?></label>
            <select class="form-control" name="Card[State]" id="new_pageState"></select>
        </div>
        <div class="form-group settle-geo-input" data-geo-type="city">
            <label for="new_pageCity"><?=wfMessage('settlein-skin-add-new-article-window-form-field-city')->plain()?></label>
            <select class="form-control" name="Card[City]" id="new_pageCity"></select>
        </div>
		<div class="form-group">
			<label for="new_pageLanguage"><?=wfMessage('settlein-skin-add-new-article-window-form-field-language')->plain()?></label>
            <select class="form-control" name="pageLanguage" id="new_pageLanguage" style="display: none;">
	            <?
	            foreach ($this->connectedLanguagesList as $langCode => $langText) {
	            	?>
		            <option value="<?=$langCode?>"><?=$langText?></option>
		            <?
	            }
	            ?>
            </select>
            <span style="display: block;">
				<?=wfMessage('settlein-skin-add-new-article-window-form-other-languages')->plain()?>
                <?
                global $wgSettleTranslateDomains;
                $shiftedLangs = array_slice($this->connectedLanguagesList, 1); // Exclude current language
                ?>
                <? foreach ( $shiftedLangs as $langCode => $langText ): ?>
                    <a target="_blank" href="//<?=$wgSettleTranslateDomains[$langCode]?>"><?=$langText?></a>&nbsp;
                <? endforeach; ?>
            </span>
		</div>
		<div class="new_page_suggestions">
			<p></p>
			<ul>

			</ul>
		</div>
		<div class="form-group pull-right">
			<a id="newpage_btn_cancel" href="#" class="btn btn-concrete"><?=wfMessage('settlein-skin-add-new-article-window-form-btn-cancel')->plain()?></a>
			<a href="#" id="newpage_btn_submit" class="disabled btn btn-primary"><?=wfMessage('settlein-skin-add-new-article-window-form-btn-submit')->plain()?></a>
		</div>
	</form>
</div>
-->

<?
	}

}
