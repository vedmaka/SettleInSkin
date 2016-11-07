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
    private $cleanPage;

	private $countriesList;
	private $connectedLanguagesList;
    private $categoriesList;

	/**
	 * Outputs the entire contents of the (X)HTML page
	 */
	public function execute() {

		global $wgSettleTranslateDomains, $wgLanguageCode;

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
	    $this->isLoggedIn = false;
	    if( $this->getSkin()->getUser() && !$this->getSkin()->getUser()->isAnon() ) {
	        $this->user = $this->getSkin()->getUser();
	        $this->isLoggedIn = true;
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

		$this->printSlideMenu();
		?>
		<main class="<?=($this->isCardPage) ? 'card-page' : '' ?>">
		<?

		$title = $this->getSkin()->getTitle();
		if( $title && $title->exists() && $title->getNamespace() == NS_MAIN ) {
		    if( $title->getArticleID() === Title::newMainPage()->getArticleID() ) {
		        $this->printMainPage(); // main page layout
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

	private function printSlideMenu() {
	    ?>
        <!-- Slideout menu start -->
        <div id="slideout">

            <? if( $this->isLoggedIn ): ?>
	        <div class="slide-userpanel">
		        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAAFOUlEQVR4Xu3YZ0ujURCG4YkgFuyoiGLBiiJi+f+/QLGBqNjLBwvG3sCyzIGIyeqSwTEks7dfXHGYN/PMtScnZrLZ7LvwRQJFJpABTJFJUZYSAAwQTAkAxhQXxYDBgCkBwJjiohgwGDAlABhTXBQDBgOmBABjiotiwGDAlABgTHFRDBgMmBIAjCkuigGDAVMCgDHFRTFgMGBKADCmuCgGDAZMCQDGFBfFgMGAKQHAmOKiGDAYMCUAGFNcFAMGA6YEAGOKi2LAYMCUAGBMcVEMGAyYEgCMKS6KAYMBUwKAMcVFMWAwYEoAMKa4KAYMBkwJAMYUF8WAwYApAcCY4qIYMBgwJQAYU1wUAwYDpgQAY4qLYsBgwJQAYExxUQwYDJgSAIwpLooBgwFTAoAxxUUxYDBgSgAwprgoBgwGTAkAxhQXxYDBgCkBwJjiohgwGDAlABhTXBQDBgOmBABjiotiwGDAlABgTHFRDBgMmBIAjCkuigGDAVMCgDHFRTFgMGBKoOLBPD4+ytLSUhp6dnZWamtr8wLY2NiQ4+NjGR4eloGBgfS7g4MD2d3dldfXV2lsbJSJiYn0vZivUj+vmNdUypqKBfP+/i7n5+eyubkpz8/PUl9f/xeYbDYrq6ur8vLy8gHm+vpaVlZWpLm5OQHSfyuW6elpyWQy32Zf6ueVEoHlWRUL5vb2VhYXF0UX+fb2lk6WzyeMnh6K4fLyMtXkThg9Xba2tmRkZET6+/tlfn5enp6eZGZmJgHUk6ejoyPVLy8vp1NoampKqqqq3J/X0NBg2VVZ1FYsmLu7u7T47u5u0bed6urqPDCHh4eys7MjLS0tcnFx8QFmbW1Nzs7OZHx8XLq6uj5QTU5OplpF+PDwIE1NTQmbnkJDQ0PyG89rb28vCwSWF1GxYHJD5k6az2By94y6urqEQOHkTphCMIU/n5ycyPr6ejpZ9ASYm5tLGH/reZZllUNtSDB64ugpom8lV1dXsr29XdQJo//j9b6zsLCQTpS+vj4ZHR3N29NXQH/yvHJAYHkN4cDo8Lm3lcIg9JTRi+13dxg9Ufb29tI9Ru89NTU1CZ1ekL87YX76PMuyyqE2HJjCj9X7+/t5J4zeS/Qy3NraKoODg+liq1D0U9L9/X36iK6oOjs75ejoSNra2vI+QX11wnxepOV5//pUVg44vnoN/x0YDUEh6L1G335yf4dRNHqfOT09TZB6e3sTppubGxkbG5Oenp6UnxXMd88r9u8+5Qan4sGUW6DRXw9gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/Yeb4/HZAutcoP83oAAAAASUVORK5CYII="
		             class="img-circle user-avatar"
		        />
		        <div class="user-name">
                    <b><?=$this->user->getName()?></b>
                    <a title="<?=wfMessage( 'settlein-skin-header-usermenu-profile' )->plain()?>" style="color: white;" href="<?=SpecialPage::getSafeTitleFor('Preferences')->getFullURL()?>">
                        <i class="glyphicon glyphicon-cog"></i>
                    </a>
                </div>
                <a class="badge badge-berry mobile-notifications-badge" href="#">
                    15 <i class="glyphicon glyphicon-bell"></i></a>
	        </div>

            <ul class="nav nav-pills nav-stacked">
                <li>
                    <a href="#" class="add-new-article-btn"><i class="glyphicon glyphicon-plus"></i> <?=wfMessage('settlein-skin-add-new-article-button')->plain()?></a>
                </li>

                <? if( $this->isCardPage): ?>
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

<div class="comments-popup-form mobile-form-popup">
    <h3>
        <?=wfMessage('settlein-skin-modal-comments-title')->plain()?>
    </h3>

    <div class="comments-list">

        <ul>
            <li class="well well-primary">
                <div class="row">
                    <div class="col-md-3">
                        <a href="#">
                            <i class="fa fa-user-secret fa-inverse"></i>
                            Anonymous
                        </a>
                        Anonymous
                        10 Jan 2015
                    </div>
                    <div class="col-md-9">
                        Fly technically like a clear captain.
                        It is a colorful understanding, sir.
                        Revolutionary avoid a particle.
                    </div>
                </div>
            </li>
            <li class="well well-primary">
                <div class="row">
                    <div class="col-md-3">
                        <a href="#">
                            <i class="fa fa-user-secret fa-inverse"></i>
                            Anonymous
                        </a>
                        at
                        9 Jan 2015
                    </div>
                    <div class="col-md-9">
                        The courage is a small admiral.
                        Countless protons arrest ancient, gravimetric emitters.
                        Oddly experience a cosmonaut.
                    </div>
                </div>
            </li>
            <li class="well well-primary">
                <div class="row">
                    <div class="col-md-3">
                        <a href="#">
                            <i class="fa fa-user-secret fa-inverse"></i>
                            Anonymous
                        </a>
                        at
                        8 Jan 2015
                    </div>
                    <div class="col-md-9">
                        It is a collective core, sir.
                        The tragedy is a fantastic space.
                        Flight, shield, and attitude.
                    </div>
                </div>
            </li>
        </ul>

    </div>

    <form class="form-inline" id="comment-form">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="<?=wfMessage('settlein-skin-modal-comments-input-placeholder')->plain()?>"/>
            <input type="submit" class="btn btn-primary" value="<?=wfMessage('settlein-skin-modal-comments-input-submit')->plain()?>"/>
        </div>
    </form>
</div>

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
                <a class="navbar-brand" href="<?=Title::newMainPage()->getFullURL()?>">
                    <img src="<?=$this->getSkin()->getSkinStylePath('/img/logo50h.png')?>" />
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
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAAFOUlEQVR4Xu3YZ0ujURCG4YkgFuyoiGLBiiJi+f+/QLGBqNjLBwvG3sCyzIGIyeqSwTEks7dfXHGYN/PMtScnZrLZ7LvwRQJFJpABTJFJUZYSAAwQTAkAxhQXxYDBgCkBwJjiohgwGDAlABhTXBQDBgOmBABjiotiwGDAlABgTHFRDBgMmBIAjCkuigGDAVMCgDHFRTFgMGBKADCmuCgGDAZMCQDGFBfFgMGAKQHAmOKiGDAYMCUAGFNcFAMGA6YEAGOKi2LAYMCUAGBMcVEMGAyYEgCMKS6KAYMBUwKAMcVFMWAwYEoAMKa4KAYMBkwJAMYUF8WAwYApAcCY4qIYMBgwJQAYU1wUAwYDpgQAY4qLYsBgwJQAYExxUQwYDJgSAIwpLooBgwFTAoAxxUUxYDBgSgAwprgoBgwGTAkAxhQXxYDBgCkBwJjiohgwGDAlABhTXBQDBgOmBABjiotiwGDAlABgTHFRDBgMmBIAjCkuigGDAVMCgDHFRTFgMGBKoOLBPD4+ytLSUhp6dnZWamtr8wLY2NiQ4+NjGR4eloGBgfS7g4MD2d3dldfXV2lsbJSJiYn0vZivUj+vmNdUypqKBfP+/i7n5+eyubkpz8/PUl9f/xeYbDYrq6ur8vLy8gHm+vpaVlZWpLm5OQHSfyuW6elpyWQy32Zf6ueVEoHlWRUL5vb2VhYXF0UX+fb2lk6WzyeMnh6K4fLyMtXkThg9Xba2tmRkZET6+/tlfn5enp6eZGZmJgHUk6ejoyPVLy8vp1NoampKqqqq3J/X0NBg2VVZ1FYsmLu7u7T47u5u0bed6urqPDCHh4eys7MjLS0tcnFx8QFmbW1Nzs7OZHx8XLq6uj5QTU5OplpF+PDwIE1NTQmbnkJDQ0PyG89rb28vCwSWF1GxYHJD5k6az2By94y6urqEQOHkTphCMIU/n5ycyPr6ejpZ9ASYm5tLGH/reZZllUNtSDB64ugpom8lV1dXsr29XdQJo//j9b6zsLCQTpS+vj4ZHR3N29NXQH/yvHJAYHkN4cDo8Lm3lcIg9JTRi+13dxg9Ufb29tI9Ru89NTU1CZ1ekL87YX76PMuyyqE2HJjCj9X7+/t5J4zeS/Qy3NraKoODg+liq1D0U9L9/X36iK6oOjs75ejoSNra2vI+QX11wnxepOV5//pUVg44vnoN/x0YDUEh6L1G335yf4dRNHqfOT09TZB6e3sTppubGxkbG5Oenp6UnxXMd88r9u8+5Qan4sGUW6DRXw9gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/YeT7AOAcavR1gom/Yeb4/HZAutcoP83oAAAAASUVORK5CYII="
                                        class="img-circle user-avatar"
                                        />
                                <span class="user-name">
                                    <b><?=$this->user->getName()?></b>
                                </span>
                            <b class="caret"></b>
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
                            <a href="#" class="add-new-article-btn"><b><?=wfMessage('settlein-skin-add-new-article-button')->plain()?></b></a>
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

            <div class="navbar-header col-md-5">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=Title::newMainPage()->getFullURL()?>">
                    <img src="<?=$this->getSkin()->getSkinStylePath("/img/i.png")?>" width="30"/>
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

            <div class="col-md-7" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav navbar-right" id="right-side-actions">

                    <? if( $this->isLoggedIn ) :?>

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
                        <a href="#" class="add-new-article-btn"><b><?=wfMessage('settlein-skin-add-new-article-button')->plain()?></b></a>
                    </li>

                    <? else: ?>

                    <li>
                        <a class="faq-menu" href="#" data-toggle="modal" data-target="#myModal" >
		                    <?=wfMessage( 'settlein-skin-header-help-link' )->plain()?>
                        </a>
                    </li>

                    <li class="btn-group-nav login-selector" id="login-selector">
                        <a href="#">
                            <!--<i class="fa fa-lock"></i>-->
                            <?=wfMessage( 'settlein-skin-header-login' )->plain()?>
                        </a>
                    </li>

                    <? endif; ?>

                    <!-- TODO: Disabled temporary -->
                    <!--<li class="dropdown" id="language-selector">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-right: 0;">En <b
                                class="caret"></b></a>
                        <ul class="dropdown-menu primary-back">
                            <li><a href="#">English</a></li>
                            <li><a href="#">Russian</a></li>
                        </ul>
                    </li>-->

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
<div id="add-new-article-popup-wrapper">
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
                $shiftedLangs = array_splice($this->connectedLanguagesList, 1);
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

<?
	}

}
