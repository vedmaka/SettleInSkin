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

        return $parser->insertStripItem( $original );
    }

}
