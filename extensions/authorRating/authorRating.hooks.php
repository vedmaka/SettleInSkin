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

	}

	public static function onNameOfHook()
	{
		
	}

	/**
	 * @param ResourceLoader $resourceLoader
	 */
	public static function onResourceLoaderRegisterModules( &$resourceLoader  )
	{
		$resourceLoader->register( 'ext.authorrating.foo',
			array(
				'scripts' => array(
					"modules/ext.authorRating.foo.js",
					"modules/ext.authorRating.js"
				),
				'styles' => array(
					"modules/ext.authorRating.foo.css"
				),
				'remoteExtPath' => '../skins/SettleIn/extensions/authorRating/',
			)
		);
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
