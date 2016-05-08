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

	/**
	 * Outputs the entire contents of the (X)HTML page
	 */
	public function execute() {

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
	</body>
</html>
<?php
	}

	private function printMainPage() {

	    $this->printHeader();

	?>

    <!-- Wrapper     ----------------------------------------------------------------------------------------------  -->
    <div id="main-wrapper">

    <!-- Main start -->
    <section>

            <div class="jumbotron">

                <div id="jumbo-backlay"></div>

                <div class="jumbo-content">

                    <div class="i-jumbotext">
                        <h1><?=wfMessage( 'settlein-skin-mainpage-jumbotron-title' )->plain()?></h1>
                        <p>
                            <?=wfMessage( 'settlein-skin-mainpage-jumbotron-text' )->plain()?>
                        </p>
                    </div>

                    <!--<div class="i-logo">
                        <img src="<?/*=$this->getSkin()->getSkinStylePath("/img/i.png")*/?>" />
                    </div>-->


                    <!--<div class="jumbo-search" id="p-search">
                        <form role="search" action="<?php /*$this->text( 'wgScript' ) */?>" id="searchform">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                <input type="hidden" name="title" value="<?/*=$this->get( 'searchtitle' )*/?>" />
                            </div>
                        </form>
                    </div>-->

                    <div class="jumbo-country center-block">
                        <!-- Single button -->
                        <div class="btn-group">
                            <select name="Search[Country]">
                                <option></option>
                                <?
                                $propVals = stools::getPropertyAllowedValues('Country');
                                foreach ($propVals as $val) {
                                    ?>
                                    <option value="<?=$val?>"><?=$val?></option>
                                    <?
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <form role="search" action="<?=SpecialPage::getSafeTitleFor('RunQuery')->getFullURL().'/Search'?>" id="searchform_smw" method="post">

                    <div class="jumbo-search" id="p-search_smw">
                            <div class="form-group">
                                <a href="#" class="search-submit fa fa-search"></a>
                                <input type="text" class="form-control" placeholder="<?=wfMessage('settlein-skin-mainpage-jumbotron-search-placeholder')->plain()?>" name="Search[Title]" id="searchInput_smw">
                            </div>
                    </div>

                    <input type="hidden" name="query" value="true" />
                    <input type="hidden" value="" name="sf_free_text">
                    <input type="hidden" value="Search" name="wpRunQuery">

                    </form>


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
                            <img src="<?=$this->getSkin()->getSkinStylePath("/img/pl3.png")?>" width="31" />
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

            <!-- Content start -->
            <div class="container">

                <div class="row" id="promo-blocks-row">

                    <div class="col-lg-4">

                        <div class="promo-block-item">
                            <div class="promo-block-img">
                                <img src="<?=$this->getSkin()->getSkinStylePath("/img/house_green.png")?>" />
                            </div>
                            <div class="promo-block-text">
                                <div class="promo-block-text-content">
                                    <h3><?=wfMessage('settlein-skin-mainpage-section-1-title')->plain()?></h3>
                                    <?=wfMessage('settlein-skin-mainpage-section-1-text')->plain()?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="promo-block-item">
                            <div class="promo-block-img">
                                <img src="<?=$this->getSkin()->getSkinStylePath("/img/suitcase_blue.png")?>" />
                            </div>
                            <div class="promo-block-text">
                                <div class="promo-block-text-content">
                                    <h3><?=wfMessage('settlein-skin-mainpage-section-2-title')->plain()?></h3>
                                    <?=wfMessage('settlein-skin-mainpage-section-2-text')->plain()?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="promo-block-item">
                            <div class="promo-block-img">
                                <img src="<?=$this->getSkin()->getSkinStylePath("/img/chat_green.png")?>" />
                            </div>
                            <div class="promo-block-text">
                                <div class="promo-block-text-content">
                                    <h3><?=wfMessage('settlein-skin-mainpage-section-3-title')->plain()?></h3>
                                    <?=wfMessage('settlein-skin-mainpage-section-3-text')->plain()?>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="jumbotron jumbotron-middle">
                <h3><?=wfMessage('settlein-skin-mainpage-bottom-title')->plain()?></h3>
                <p>
                    <?=wfMessage( 'settlein-skin-mainpage-bottom-text' )->plain()?>
                </p>
                <a href="<?=SpecialPage::getSafeTitleFor('Userlogin')->getFullURL('type=signup')?>" class="btn btn-primary">
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
<div id="bottom-footer">
    <div class="bottom-footer-badge">
        <i class="fa fa-chevron-up"></i>
    </div>
    <div class="bottom-footer-content">
        <div class="container">
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?=Title::newFromText('About Us', NS_PROJECT)->getFullURL()?>">
                        <?=wfMessage('settlein-skin-footer-about-us')->plain()?>
                    </a>
                </li>
                <li>
                    <a href="<?=Title::newFromText('Contact', NS_PROJECT)->getFullURL()?>">
                        <?=wfMessage('settlein-skin-footer-contact')->plain()?>
                    </a>
                </li>
                <li>
                    <a href="<?=Title::newFromText('Help Out', NS_PROJECT)->getFullURL()?>">
                        <?=wfMessage('settlein-skin-footer-helpout')->plain()?>
                    </a>
                </li>
                <li>
                    <a href="<?=Title::newFromText('Terms and Conditions', NS_PROJECT)->getFullURL()?>">
                        <?=wfMessage('settlein-skin-footer-tos')->plain()?>
                    </a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a target="_blank" href="<?=$this->config->get('SettleinTwitterURL')?>">
                        <i class="fa fa-twitter"></i>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="<?=$this->config->get('SettleinFacebookURL')?>">
                        <i class="fa fa-facebook"></i>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="<?=$this->config->get('SettleinGoogleURL')?>">
                        <i class="fa fa-google-plus"></i>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>

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
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?=Title::newFromText('About Us', NS_PROJECT)->getFullURL()?>">
                        <?=wfMessage('settlein-skin-footer-about-us')->plain()?>
                    </a>
                </li>
                <li>
                    <a href="<?=Title::newFromText('Contact', NS_PROJECT)->getFullURL()?>">
                        <?=wfMessage('settlein-skin-footer-contact')->plain()?>
                    </a>
                </li>
                <li>
                    <a href="<?=Title::newFromText('Help Out', NS_PROJECT)->getFullURL()?>">
                        <?=wfMessage('settlein-skin-footer-helpout')->plain()?>
                    </a>
                </li>
                <li>
                    <a href="<?=Title::newFromText('Terms and Conditions', NS_PROJECT)->getFullURL()?>">
                        <?=wfMessage('settlein-skin-footer-tos')->plain()?>
                    </a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a target="_blank" href="<?=$this->config->get('SettleinTwitterURL')?>">
                        <i class="fa fa-twitter"></i>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="<?=$this->config->get('SettleinFacebookURL')?>">
                        <i class="fa fa-facebook"></i>
                    </a>
                </li>
                <li>
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
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <!--<form action="<?/*=SpecialPage::getSafeTitleFor('RunQuery')->getFullURL().'/Search'*/?>" method="post" role="search">

                <ul class="nav navbar-nav" id="top-search">

                        <div class="form-group navbar-form navbar-left ">
                            <input type="text" class="form-control" placeholder="Search" name="Search[Title]">
                        </div>

                </ul>

                <ul class="nav navbar-nav" id="country-select-wrapper">
                    <select id="country-select" name="Search[Country]">
                        <option></option>
                        <?/*
                            $propVals = SFUtils::getAllValuesForProperty('Country');
                            foreach ($propVals as $val) {
                                */?>
                                <option value="<?/*=$val*/?>"><?/*=$val*/?></option>
                                <?/*
                            }
                        */?>
                    </select>
                </ul>

                <input type="hidden" name="query" value="true" />
                <input type="hidden" value="" name="sf_free_text">
                <input type="hidden" value="Search" name="wpRunQuery">

                </form>-->

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
                    <? else: ?>
                        <li id="why_signup">
                            <a href="#">
                                <?=wfMessage( 'settlein-skin-header-why-signup' )->plain()?>
                            </a>
                        </li>
                        <li class="btn-group-nav" id="login-selector">
                            <a href="<?=SpecialPage::getSafeTitleFor('Userlogin')->getFullURL()?>" class="btn btn-concrete" style="margin-right: 10px;"><b>
                                    <?=wfMessage( 'settlein-skin-header-login' )->plain()?>
                                </b></a>
                        </li>

                        <li class="btn-group-nav">
                            <a href="<?=SpecialPage::getSafeTitleFor('Userlogin')->getFullURL('type=signup')?>" class="btn btn-primary" style="margin-right: 5px;"><b>
                                    <?=wfMessage( 'settlein-skin-header-signup' )->plain()?>
                                </b></a>
                        </li>
                    <? endif; ?>

                    <!--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-right: 0;">En <b class="caret"></b></a>
                        <ul class="dropdown-menu primary-back">
                            <li><a href="#">English</a></li>
                            <li><a href="#">Russian</a></li>
                        </ul>
                    </li>-->

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
        <nav class="navbar">

            <div class="navbar-header">
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
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <form action="<?=SpecialPage::getSafeTitleFor('RunQuery')->getFullURL().'/Search'?>" class="" role="search" method="post" id="form-top-search">

                <ul class="nav navbar-nav" id="country-select-wrapper">
                    <select id="country-select" name="Search[Country]">
                        <option></option>
                        <?
                            $propVals = stools::getPropertyAllowedValues('Country');
                            foreach ($propVals as $val) {
                                ?>
                                <option value="<?=$val?>"><?=$val?></option>
                                <?
                            }
                        ?>
                    </select>
                </ul>

                <ul class="nav navbar-nav" id="top-search">

                    <div class="form-group navbar-form navbar-left">
                        <a href="#" class="search-submit fa fa-search"></a>
                        <input type="text" class="form-control" placeholder="<?=wfMessage( 'settlein-skin-header-search-placeholder' )->plain()?>" name="Search[Title]">
                    </div>

                </ul>

                <input type="hidden" name="query" value="true" />
                <input type="hidden" value="" name="sf_free_text">
                <input type="hidden" value="Search" name="wpRunQuery">

                </form>

                <ul class="nav navbar-nav">
                    <li>
                        <a id="faq-menu" href="#" data-toggle="modal" data-target="#myModal" style="" >
                            <?=wfMessage( 'settlein-skin-header-help-link' )->plain()?>
                        </a>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right" id="right-side-actions">

                    <? if( $this->isLoggedIn ) :?>

                    <li class="btn-group-nav login-selector" id="user-panel-bell">
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

                    <li class="btn-group-nav login-selector" id="user-panel-selector">
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

                    <? else: ?>

                    <li class="btn-group-nav login-selector" id="login-selector">
                        <a href="#">
                            <i class="fa fa-lock"></i>
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
                    <div id="why_signup">
                        <a href="#">
                            <?=wfMessage( 'settlein-skin-header-why-signup' )->plain()?>
                        </a>
                    </div>
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

<?
	}

}
