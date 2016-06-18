<section>
    <div class="jumbotron">
        <div id="jumbo-about-backlay"></div>
        <div class="jumbo-content">

            <div class="i-jumbotext">
                <h1><?=wfMessage('settlein-skin-project-page-about-title')->plain()?></h1>
                <p>
                    <?=wfMessage('settlein-skin-project-page-about-title-text')->plain()?>
                </p>
            </div>

        </div>
</section>

<div class="container">

    <div class="about-us-quoted-title">
        <?=wfMessage('settlein-skin-project-page-about-second-title')->plain()?>
    </div>

    <div class="about-us-quoted-text">
        <?=wfMessage('settlein-skin-project-page-about-second-title-text')->plain()?>
    </div>

</div>

<? global $wgServer, $wgScriptPath; ?>

<section id="timeline">

    <div class="container">

        <ul class="timeline">
            <li class="timeline-inverted">
                <div class="timeline-badge warning"><i class="fa fa-check"></i>
                </div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4 class="timeline-title"><?=wfMessage('settlein-skin-project-page-about-record-1-title')->plain()?></h4>
                        <p class="timeline-date"><small class="text-muted"><i class="fa fa-clock-o"></i> <?=wfMessage('settlein-skin-project-page-about-record-1-date')->plain()?></small>
                        </p>
                    </div>
                    <div class="timeline-body">
                        <p>
                            <?=wfMessage('settlein-skin-project-page-about-record-1-text')->plain()?>
                        </p>
                    </div>
                </div>
            </li>

            <li>
                <div class="timeline-badge primary"><i class="fa fa-file-image-o"></i>
                </div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4 class="timeline-title"><?=wfMessage('settlein-skin-project-page-about-record-2-title')->plain()?></h4>
                        <p class="timeline-date"><small class="text-muted"><i class="fa fa-clock-o"></i> <?=wfMessage('settlein-skin-project-page-about-record-2-date')->plain()?></small>
                        </p>
                    </div>
                    <div class="timeline-body">
                        <div class="thumbnail">
                            <a rel="group" href="<?= $wgServer . $wgScriptPath .'/skins/SettleIn/assets/special/about/img1.jpg' ?>" class="fancybox" >
                                <img src="<?= $wgServer . $wgScriptPath .'/skins/SettleIn/assets/special/about/img1.jpg' ?>" />
                            </a>
                            <a rel="group" href="<?= $wgServer . $wgScriptPath .'/skins/SettleIn/assets/special/about/img2.jpg' ?>" class="fancybox">
                            </a>
                            <a rel="group" href="<?= $wgServer . $wgScriptPath .'/skins/SettleIn/assets/special/about/img3.jpg' ?>" class="fancybox">
                            </a>
                        </div>
                        <p>
                            <?=wfMessage('settlein-skin-project-page-about-record-2-text')->plain()?>
                        </p>
                    </div>
                </div>
            </li>

            <li class="timeline-inverted">
                <div class="timeline-badge danger"><i class="fa fa-diamond"></i>
                </div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4 class="timeline-title"><?=wfMessage('settlein-skin-project-page-about-record-3-title')->plain()?></h4>
                        <p class="timeline-date"><small class="text-muted"><i class="fa fa-clock-o"></i> <?=wfMessage('settlein-skin-project-page-about-record-3-date')->plain()?></small>
                        </p>
                    </div>
                    <div class="timeline-body">
                        <p>
                            <?=wfMessage('settlein-skin-project-page-about-record-3-text')->plain()?>
                        </p>
                    </div>
                </div>
            </li>

            <li>
                <div class="timeline-badge warning"><i class="fa fa-group"></i>
                </div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4 class="timeline-title"><?=wfMessage('settlein-skin-project-page-about-record-4-title')->plain()?></h4>
                        <p class="timeline-date"><small class="text-muted"><i class="fa fa-clock-o"></i> <?=wfMessage('settlein-skin-project-page-about-record-4-date')->plain()?></small>
                        </p>
                    </div>
                    <div class="timeline-body">
                        <p>
                            <?=wfMessage('settlein-skin-project-page-about-record-4-text')->plain()?>
                        </p>
                    </div>
                </div>
            </li>

            <li class="timeline-inverted">
                <div class="timeline-badge primary"><i class="fa fa-video-camera"></i>
                </div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4 class="timeline-title"><?=wfMessage('settlein-skin-project-page-about-record-5-title')->plain()?></h4>
                        <p class="timeline-date"><small class="text-muted"><i class="fa fa-clock-o"></i> <?=wfMessage('settlein-skin-project-page-about-record-5-date')->plain()?></small>
                        </p>
                    </div>
                    <div class="timeline-body">
                        <div class="thumbnail">
                            <iframe src="https://player.vimeo.com/video/90429499" width="100%" height="250" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </div>
                        <p>
                            <?=wfMessage('settlein-skin-project-page-about-record-5-text')->plain()?>
                        </p>
                    </div>
                </div>
            </li>

        </ul>

    </div>

</section>

<div class="container">

    <div class="about-us-quoted-title">
        <?=wfMessage('settlein-skin-project-page-about-contributors-title')->plain()?>
    </div>

    <div class="about-us-quoted-text">
        <?=wfMessage('settlein-skin-project-page-about-contributors-title-text')->plain()?>
    </div>

    <div id="contributors-about-list">
        <ul>
            <li>
                <a class="contributor-about-image" href="#">
                    <img class="img-circle" src="holder.js/100x100" />
                </a>
                <a class="contributor-about-name" href="#">
                    John Doe
                </a>
            </li>

            <li>
                <a class="contributor-about-image" href="#">
                    <img class="img-circle" src="holder.js/100x100" />
                </a>
                <a class="contributor-about-name" href="#">
                    John Doe
                </a>
            </li>

            <li>
                <a class="contributor-about-image" href="#">
                    <img class="img-circle" src="holder.js/100x100" />
                </a>
                <a class="contributor-about-name" href="#">
                    John Doe
                </a>
            </li>

            <li>
                <a class="contributor-about-image" href="#">
                    <img class="img-circle" src="holder.js/100x100" />
                </a>
                <a class="contributor-about-name" href="#">
                    John Doe
                </a>
            </li>

            <li>
                <a class="contributor-about-image" href="#">
                    <img class="img-circle" src="holder.js/100x100" />
                </a>
                <a class="contributor-about-name" href="#">
                    John Doe
                </a>
            </li>

            <li>
                <a class="contributor-about-image" href="#">
                    <img class="img-circle" src="holder.js/100x100" />
                </a>
                <a class="contributor-about-name" href="#">
                    John Doe
                </a>
            </li>

            <li>
                <a class="contributor-about-image" href="#">
                    <img class="img-circle" src="holder.js/100x100" />
                </a>
                <a class="contributor-about-name" href="#">
                    John Doe
                </a>
            </li>

            <li>
                <a class="contributor-about-image" href="#">
                    <img class="img-circle" src="holder.js/100x100" />
                </a>
                <a class="contributor-about-name" href="#">
                    John Doe
                </a>
            </li>

            <li>
                <a class="contributor-about-image" href="#">
                    <img class="img-circle" src="holder.js/100x100" />
                </a>
                <a class="contributor-about-name" href="#">
                    John Doe
                </a>
            </li>

            <li>
                <a class="contributor-about-image" href="#">
                    <img class="img-circle" src="holder.js/100x100" />
                </a>
                <a class="contributor-about-name" href="#">
                    John Doe
                </a>
            </li>

        </ul>
    </div>

</div>