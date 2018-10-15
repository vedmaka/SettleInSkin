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
        $parser->setFunctionHook('stoolsmoddate', 'stools::moddate' );
        $parser->setFunctionHook('stoolseditorlist', 'stools::editorlist' );
        $parser->setFunctionHook('stoolsprintbtn', 'stools::sprintbtn' );
        $parser->setFunctionHook('stoolsmakebtn', 'stools::makebtn' );
        $parser->setFunctionHook('stoolspageauthor', 'stools::pageauthor' );
        $parser->setFunctionHook('stoolslanglinks', 'stools::langlinks' );
        $parser->setFunctionHook('stoolssociallinks', 'stools::sociallinks' );
        $parser->setFunctionHook('stoolsfooterlinks', 'stools::footerlinks' );
        $parser->setFunctionHook('stoolsuserpic', 'stools::userpic' );
        $parser->setFunctionHook('pageinfocontributors', 'stools::pageinfocontributors' );
	}

}
