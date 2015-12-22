<?php

/**
 * Class for authorRating extension
 *
 * @file
 * @ingroup Extensions
 */
class authorRating
{

    /**
     * Retrieves
     * @param Title $title
     * @return bool|User
     */
    public static function getPageAuthor( Title $title )
    {

        if( !$title->exists() ) {
            return false;
        }

        $firstRev = $title->getFirstRevision();
        if( !$firstRev ) {
            return false;
        }

        $user = User::newFromId( $firstRev->getUser() );
        if( !$user ) {
            return false;
        }

        return $user;

    }

    /**
     * @param Parser $parser
     * @return string
     */
    public static function render( $parser )
    {

        $user = $parser->getUser();
        $title = $parser->getTitle();

        if( !$title || !$title->exists() ) {
            return '';
        }

        $author = self::getPageAuthor( $title );

        if( !$author ) {
            return '';
        }

        $html = '<div class="author-rating-wrapper">';
        // Add user link
        $html .= $parser->insertStripItem( '<a target="_blank" href="' . $author->getUserPage()->getFullURL() . '">'
            . $author->getName() . '</a>' );
        $html .= '</div>';

        return array(
            $html,
            'markerType' => 'nowiki'
        );

    }

}
