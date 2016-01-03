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

        $html = '<span class="author-rating-wrapper">';

        // Add user link
        $html .= $parser->insertStripItem( ' <a target="_blank" href="' . $author->getUserPage()->getFullURL() . '">'
            . $author->getName() . '</a>' );

        $html .= ' <i style="display: none;" class="fa fa-thumbs-o-up author-thumbs-up" title="Click to rate author"></i>';
        $html .= ' <span class="label label-success">?</span>';
        $html .= '</span>';

        $parser->getOutput()->addModules('ext.authorrating.foo');

        return array(
            $html,
            'markerType' => 'nowiki'
        );

    }

    public static function isUserVoted( $user_id, $page_id, $author_id = null )
    {
        if( $author_id === null ) {
            $author_id = self::getPageAuthor( Title::newFromID( $page_id ) )->getId();
        }

        $dbr = wfGetDB(DB_SLAVE);
        $result = $dbr->select(
            'author_rating',
            'user_id',
            array(
                'user_id' => $user_id,
                'author_user_id' => $author_id,
                'page_id' => $page_id
            )
        );
        if( $result->numRows() ) {
            return true;
        }
        return false;

    }

    public static function getPageAuthorRating( $page_id, $author_id = null )
    {
        if( $author_id === null ) {
            $author_id = self::getPageAuthor( Title::newFromID( $page_id ) )->getId();
        }

        $dbr = wfGetDB(DB_SLAVE);
        $result = $dbr->execute( array( 'query' => 'SELECT COUNT(user_id) as count1 FROM author_rating WHERE author_user_id = ? AND page_id = ?' ), array( $author_id, $page_id ) );
        if( $result->numRows() ) {
            $count = $result->fetchRow();
            $count = $count['count1'];
            return (int) $count;
        }

        return 0;

    }

    public static function addVote( $page_id, $user_id, $author_id = null )
    {
        if( $author_id === null ) {
            $author_id = self::getPageAuthor( Title::newFromID( $page_id ) )->getId();
        }

        $dbw = wfGetDB(DB_MASTER);
        $dbw->insert(
            'author_rating',
            array(
                'user_id' => $user_id,
                'author_user_id' => $author_id,
                'page_id' => $page_id,
                'created_at' => time()
            )
        );
    }

}
