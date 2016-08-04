<div class="container about-us-page-container">

	<div class="row">
		<div class="col-md-12">

			<div class="about-us-section-heading">

				<div class="about-us-header-wrapper">
					<span><?=wfMessage('settlein-skin-project-page-about-title')->plain()?></span>
				</div>

				<div class="about-us-header-text-wrapper">
					<?=wfMessage('settlein-skin-project-page-about-title-text')->plain()?>
				</div>

			</div>

		</div>
	</div>

	<? global $wgServer, $wgScriptPath; ?>

	<section id="timeline">

		<div class="container">

			<ul class="timeline">

				<div class="ul-timeline-arrow-up"></div>

				<li class="timeline-inverted timeline-item-orange">
					<div class="timeline-badge"></div>
					<div class="timeline-panel">
						<div class="timeline-heading">
							<div class="timeline-title">
								<?=wfMessage('settlein-skin-project-page-about-record-1-title')->plain()?>
								<span class="timeline-date"><?=wfMessage('settlein-skin-project-page-about-record-1-date')->plain()?></span>
							</div>
						</div>
						<div class="timeline-body">
							<p>
								<?=wfMessage('settlein-skin-project-page-about-record-1-text')->plain()?>
							</p>
						</div>
					</div>
				</li>

				<li class="timeline-item-green">
					<div class="timeline-badge primary"></div>
					<div class="timeline-panel">
						<div class="thumbnail">
							<a rel="group" href="<?= $wgServer . $wgScriptPath .'/skins/SettleIn/assets/special/about/img1.jpg' ?>" class="fancybox" >
								<img src="<?= $wgServer . $wgScriptPath .'/skins/SettleIn/assets/special/about/img1.jpg' ?>" />
							</a>
							<a rel="group" href="<?= $wgServer . $wgScriptPath .'/skins/SettleIn/assets/special/about/img2.jpg' ?>" class="fancybox">
							</a>
							<a rel="group" href="<?= $wgServer . $wgScriptPath .'/skins/SettleIn/assets/special/about/img3.jpg' ?>" class="fancybox">
							</a>
						</div>
						<div class="timeline-heading">
							<div class="timeline-title">
								<span class="timeline-date"><?=wfMessage('settlein-skin-project-page-about-record-2-date')->plain()?></span>
								<?=wfMessage('settlein-skin-project-page-about-record-2-title')->plain()?>
							</div>
						</div>
						<div class="timeline-body">
							<p>
								<?=wfMessage('settlein-skin-project-page-about-record-2-text')->plain()?>
							</p>
						</div>
					</div>
				</li>

				<li class="timeline-inverted timeline-item-blue">
					<div class="timeline-badge"></div>
					<div class="timeline-panel">
						<div class="timeline-heading">
							<div class="timeline-title">
								<?=wfMessage('settlein-skin-project-page-about-record-3-title')->plain()?>
								<span class="timeline-date"><?=wfMessage('settlein-skin-project-page-about-record-3-date')->plain()?></span>
							</div>
						</div>
						<div class="timeline-body">
							<p>
								<?=wfMessage('settlein-skin-project-page-about-record-3-text')->plain()?>
							</p>
						</div>
					</div>
				</li>

				<li class="timeline-inverted timeline-item-orange-outline">
					<div class="timeline-badge"></div>
					<div class="timeline-panel">
						<div class="timeline-heading">
							<div class="timeline-title">
								<?=wfMessage('settlein-skin-project-page-about-record-4-title')->plain()?>
								<span class="timeline-date"><?=wfMessage('settlein-skin-project-page-about-record-4-date')->plain()?></span>
							</div>
						</div>
						<div class="timeline-body">
							<p>
								<?=wfMessage('settlein-skin-project-page-about-record-4-text')->plain()?>
							</p>
						</div>
					</div>
				</li>

				<li class="timeline-item-green-full">
					<div class="timeline-badge primary"></div>
					<div class="timeline-panel">
						<div class="thumbnail">
							<iframe src="https://player.vimeo.com/video/90429499" width="100%" height="240" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
						</div>
						<div class="timeline-heading">
							<div class="timeline-title">
								<span class="timeline-date"><?=wfMessage('settlein-skin-project-page-about-record-5-date')->plain()?></span>
								<?=wfMessage('settlein-skin-project-page-about-record-5-title')->plain()?>
							</div>
						</div>
						<div class="timeline-body">
							<p>
								<?=wfMessage('settlein-skin-project-page-about-record-5-text')->plain()?>
							</p>
						</div>
					</div>
				</li>

				<div class="ul-timeline-arrow-down"></div>

			</ul>
		</div>
	</section>

</div>

<section id="contributors-about-list">

	<div class="container">

		<div class="about-us-contributions-section-heading">

			<div class="about-us-header-wrapper">
				<span><?=wfMessage('settlein-skin-project-page-about-contributors-title')->plain()?></span>
			</div>

		</div>

		<div class="row">

			<div class="col-md-3 col-contributions">

				<div class="sprite sprite-kz"></div>

				<div class="contrib-content">

					<div class="contrib-photo">
						<img src="<?=$img_placeholder?>" />
					</div>
					<div class="contrib-name">
						<?=wfMessage('settlein-skin-project-page-about-contributions-name-1')->plain()?>
					</div>
					<div class="contrib-title">
						<?=wfMessage('settlein-skin-project-page-about-contributions-title-1')->plain()?>
					</div>
					<div class="contrib-text">
						<?=wfMessage('settlein-skin-project-page-about-contributions-text-1')->plain()?>
					</div>
					<div class="contrib-link">
						<a target="_blank" href="<?=wfMessage('settlein-skin-project-page-about-contributions-link-1')->plain()?>"><?=wfMessage('settlein-skin-project-page-about-contributions-link-text-1')->plain()?></a>
					</div>

				</div>

			</div>

			<div class="col-md-3 col-contributions">

				<div class="sprite sprite-ru"></div>

				<div class="contrib-content">

					<div class="contrib-photo">
						<!--<img src="<?/*=$img_placeholder*/?>" />-->
					</div>
					<div class="contrib-name">
						<?=wfMessage('settlein-skin-project-page-about-contributions-name-2')->plain()?>
					</div>
					<div class="contrib-title">
						<?=wfMessage('settlein-skin-project-page-about-contributions-title-2')->plain()?>
					</div>
					<div class="contrib-text">
						<?=wfMessage('settlein-skin-project-page-about-contributions-text-2')->plain()?>
					</div>
					<div class="contrib-link">
						<a target="_blank" href="<?=wfMessage('settlein-skin-project-page-about-contributions-link-2')->plain()?>"><?=wfMessage('settlein-skin-project-page-about-contributions-link-text-2')->plain()?></a>
					</div>

				</div>

			</div>

			<div class="col-md-3 col-contributions">

				<div class="sprite sprite-au"></div>

				<div class="contrib-content">

					<div class="contrib-photo">
						<!--<img src="<?/*=$img_placeholder*/?>" />-->
					</div>
					<div class="contrib-name">
						<?=wfMessage('settlein-skin-project-page-about-contributions-name-3')->plain()?>
					</div>
					<div class="contrib-title">
						<?=wfMessage('settlein-skin-project-page-about-contributions-title-3')->plain()?>
					</div>
					<div class="contrib-text">
						<?=wfMessage('settlein-skin-project-page-about-contributions-text-3')->plain()?>
					</div>
					<div class="contrib-link">
						<a target="_blank" href="<?=wfMessage('settlein-skin-project-page-about-contributions-link-3')->plain()?>"><?=wfMessage('settlein-skin-project-page-about-contributions-link-text-3')->plain()?></a>
					</div>

				</div>

			</div>

			<div class="col-md-3 col-contributions">

				<div class="sprite sprite-sw"></div>

				<div class="contrib-content">

					<div class="contrib-photo">
						<!--<img src="<?/*=$img_placeholder*/?>" />-->
					</div>
					<div class="contrib-name">
						<?=wfMessage('settlein-skin-project-page-about-contributions-name-4')->plain()?>
					</div>
					<div class="contrib-title">
						<?=wfMessage('settlein-skin-project-page-about-contributions-title-4')->plain()?>
					</div>
					<div class="contrib-text">
						<?=wfMessage('settlein-skin-project-page-about-contributions-text-4')->plain()?>
					</div>
					<div class="contrib-link">
						<a target="_blank" href="<?=wfMessage('settlein-skin-project-page-about-contributions-link-4')->plain()?>"><?=wfMessage('settlein-skin-project-page-about-contributions-link-text-4')->plain()?></a>
					</div>

				</div>

			</div>

		</div>

	</div>

</section>

<section id="about-us-special-thanks">

	<div class="container">

		<div class="about-us-thanks-section-heading">

			<div class="about-us-header-wrapper">
				<span><?=wfMessage('settlein-skin-project-page-about-special-thanks-title')->plain()?></span>
			</div>

		</div>

		<div class="row">

			<div class="col-md-4 col-thanks col-yellow">

				<div class="contrib-content">

					<div class="contrib-photo">
						<!--<img src="<?/*=$img_placeholder*/?>" />-->
					</div>
					<div class="contrib-name">
						<?=wfMessage('settlein-skin-project-page-about-special-thanks-name-1')->plain()?>
					</div>
					<div class="contrib-title">
						<?=wfMessage('settlein-skin-project-page-about-special-thanks-title-1')->plain()?>
					</div>
					<div class="contrib-text">
						<?=wfMessage('settlein-skin-project-page-about-special-thanks-text-1')->plain()?>
					</div>
					<div class="contrib-link">
						<a target="_blank" href="<?=wfMessage('settlein-skin-project-page-about-special-thanks-link-1')->plain()?>"><?=wfMessage('settlein-skin-project-page-about-special-thanks-link-text-1')->plain()?></a>
					</div>
					<div class="sprite sprite-kz"></div>

				</div>

			</div>

			<div class="col-md-4 col-thanks col-blue">

				<div class="contrib-content">

					<div class="contrib-photo">
						<!--<img src="<?/*=$img_placeholder*/?>" />-->
					</div>
					<div class="contrib-name">
						<?=wfMessage('settlein-skin-project-page-about-special-thanks-name-2')->plain()?>
					</div>
					<div class="contrib-title">
						<?=wfMessage('settlein-skin-project-page-about-special-thanks-title-2')->plain()?>
					</div>
					<div class="contrib-text">
						<?=wfMessage('settlein-skin-project-page-about-special-thanks-text-2')->plain()?>
					</div>
					<div class="contrib-link">
						<a target="_blank" href="<?=wfMessage('settlein-skin-project-page-about-special-thanks-link-2')->plain()?>"><?=wfMessage('settlein-skin-project-page-about-special-thanks-link-text-2')->plain()?></a>
					</div>
					<div class="sprite sprite-ru"></div>

				</div>

			</div>

			<div class="col-md-4 col-thanks col-green">

				<div class="contrib-content">

					<div class="contrib-photo">
						<!--<img src="<?/*=$img_placeholder*/?>" />-->
					</div>
					<div class="contrib-name">
						<?=wfMessage('settlein-skin-project-page-about-special-thanks-name-3')->plain()?>
					</div>
					<div class="contrib-title">
						<?=wfMessage('settlein-skin-project-page-about-special-thanks-title-3')->plain()?>
					</div>
					<div class="contrib-text">
						<?=wfMessage('settlein-skin-project-page-about-special-thanks-text-3')->plain()?>
					</div>
					<div class="contrib-link">
						<a target="_blank" href="<?=wfMessage('settlein-skin-project-page-about-special-thanks-link-3')->plain()?>"><?=wfMessage('settlein-skin-project-page-about-special-thanks-link-text-3')->plain()?></a>
					</div>
					<div class="sprite sprite-au"></div>

				</div>

			</div>

		</div>

	</div>

</section>