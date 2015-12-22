<?php

/**
 * authorRating SpecialPage for authorRating extension
 *
 * @file
 * @ingroup Extensions
 */
class SpecialauthorRating extends SpecialPage
{
    public function __construct()
    {
        parent::__construct( 'authorRating' );
    }

    /**
     * Show the page to the user
     *
     * @param string $sub The subpage string argument (if any).
     *  [[Special:authorRating/subpage]].
     */
    public function execute( $sub )
    {
        $out = $this->getOutput();

        $out->setPageTitle( $this->msg( 'authorrating-helloworld' ) );

        $out->addHelpLink( 'How to become a MediaWiki hacker' );

        $out->addWikiMsg( 'authorrating-helloworld-intro' );
    }

    protected function getGroupName()
    {
        return 'other';
    }
}
