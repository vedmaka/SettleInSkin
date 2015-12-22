<?php

/**
 * stools SpecialPage for stools extension
 *
 * @file
 * @ingroup Extensions
 */
class Specialstools extends SpecialPage
{
    public function __construct()
    {
        parent::__construct( 'stools' );
    }

    /**
     * Show the page to the user
     *
     * @param string $sub The subpage string argument (if any).
     *  [[Special:stools/subpage]].
     */
    public function execute( $sub )
    {
        $out = $this->getOutput();

        $out->setPageTitle( $this->msg( 'stools-helloworld' ) );

        $out->addHelpLink( 'How to become a MediaWiki hacker' );

        $out->addWikiMsg( 'stools-helloworld-intro' );
    }

    protected function getGroupName()
    {
        return 'other';
    }
}
