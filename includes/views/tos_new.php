<div class="container tos-about-page-container">

    <div class="row">
        <div class="col-md-12">
            <div class="about-us-section-heading">
                <div class="about-us-header-wrapper">
                    <span><?=wfMessage('settlein-skin-project-page-tos-title')->plain()?></span>
                </div>
                <div class="about-us-header-text-wrapper">
                    <?=wfMessage('settlein-skin-project-page-tos-title-text')->plain()?>
                </div>
            </div>
        </div>
    </div>

	<section class="tos-about-items-wrapper">
	<div class="row tos-about-item">
		<div class="col-md-6 tos-item-legal">
			<h2><?=wfMessage('settlein-skin-project-page-tos-heading-left')->plain()?></h2>
			<p id="tos-height-scroll">
				<?=wfMessage('settlein-skin-project-page-tos-item-1-left-text')->plain()?>
			</p>
		</div>
		<div class="col-md-6 tos-item-short">
			<h2><?=wfMessage('settlein-skin-project-page-tos-heading-right')->plain()?></h2>
			<ol>
				<?=wfMessage('settlein-skin-project-page-tos-item-1-right-text')->plain()?>
			</ol>
		</div>
	</div>
	</section>

</div>

<script>
    /* Make boxes have same height - not so elegant solution though */
    $(function() {

        function fixBlockHeight() {
            var height = $('.tos-item-short > ol').height() + 40;
            $('#tos-height-scroll').css('height', height + 'px');
        }

        setTimeout( fixBlockHeight, 0 );

        $(window).on('resize', fixBlockHeight);

    });
</script>