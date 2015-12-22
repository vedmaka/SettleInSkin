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
     * @return mixed
     */
    public static function formlink( $parser )
    {
        $params = func_get_args();
        array_shift( $params ); // We don't need the parser.

        $original = SFUtils::createFormLink( $parser, $params, 'formlink' );

        if( strpos($original, 'class="new"') !== false ) {
            $original = str_replace('class="new"', 'class="btn btn-primary pull-right"', $original);
        }else{
            $original = str_replace('href=', 'class="btn btn-primary pull-right" href=', $original);
        }

        $original = str_replace('self">', 'self"><i class="fa fa-edit"></i> ', $original);

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

        $html = '<ul class="page-editors-list">';

        foreach( $tEditors as $teditor ) {
            if( !array_key_exists( $teditor->getId(), $editors ) ) {
                $editors[] = $teditor;
            }
        }
        if( !array_key_exists( $page->getUser(), $editors ) ) {
            $editors[] = User::newFromId( $page->getUser() );
        }

        foreach( $editors as $editor ) {
            $html .= '<li>'
                . $parser->insertStripItem(
                    '<a href="' .$editor->getUserPage()->getFullURL()
                    . '" data-toggle="tooltip" data-placement="top" data-original-title="'.$editor->getName().'">' .
                    '<i class="fa fa-user"></i>' . '</a>'
                ) . '</li>';
        }

        $html .= '</ul>';

        return $html;

    }

}
