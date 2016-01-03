<?php

/**
 * Hooks for authorRating extension
 *
 * @file
 * @ingroup Extensions
 */
class authorRatingHooks
{

	public static function onExtensionLoad()
	{
		global $wgResourceModules;

		$wgResourceModules['ext.authorrating.foo']['localBasePath'] = __DIR__;
		$wgResourceModules['ext.authorrating.foo']['remoteBasePath'] = '/skins/SettleIn/extensions/authorRating';
	}

	public static function onNameOfHook()
	{
		
	}

	/**
	 * @param Parser $parser
	 */
	public static function onParserFirstCallInit( $parser )
	{
		$parser->setFunctionHook('authorrating', 'authorRating::render');
	}

	/**
	 * @param DatabaseUpdater $updater
	 */
	public static function onLoadExtensionSchemaUpdates( $updater )
	{
		$updater->addExtensionTable(
			'author_rating',
			dirname( __FILE__ ) . '/schema/author_rating.sql'
		);
	}

}
