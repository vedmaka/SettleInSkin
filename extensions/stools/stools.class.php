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

}
