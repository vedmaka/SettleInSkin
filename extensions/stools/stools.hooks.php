<?php

/**
 * Hooks for stools extension
 *
 * @file
 * @ingroup Extensions
 */
class stoolsHooks
{

	public static function onExtensionLoad()
	{
		
	}

	public static function onNameOfHook()
	{
		
	}

    /**
     * @param Parser $parser
     */
	public static function onParserFirstCallInit( $parser )
	{
        $parser->setFunctionHook('stoolsformlink', 'stools::formlink' );
	}

}
