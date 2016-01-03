<?php

class AuthorRatingApi extends ApiBase {

    private $formattedData = array();
    private $params = array();

    /**
     * @var User
     */
    private $user = null;

    public function execute()
    {

        // Detect user
        $this->user = $this->getUser();
        if( $this->user->isAnon() || !$this->user ) {
            return false;
        }

        $this->params = $this->extractRequestParams();

        switch( $this->params['do'] ) {

            case 'info':
                $this->fetchInformation();
                break;

            case 'vote':
                $this->doVote();
                break;

        }

        $this->getResult()->addValue(
            null,
            $this->getModuleName(),
            $this->formattedData
        );

    }

    private function fetchInformation()
    {
        $rating = authorRating::getPageAuthorRating( $this->params['page_id'] );
        $this->formattedData['rating'] = (int)$rating;
        $this->formattedData['canvote'] = 0;
        if( !authorRating::isUserVoted( $this->user->getId(), $this->params['page_id'] ) ) {
            $this->formattedData['canvote'] = 1;
        }
    }

    private function doVote()
    {
        if( !authorRating::isUserVoted( $this->user->getId(), $this->params['page_id'] ) ) {
            authorRating::addVote( $this->params['page_id'], $this->user->getId() );
        }
    }

    public function getAllowedParams( /* $flags = 0 */ )
    {
        return array(
            'page_id' => array(
                ApiBase::PARAM_TYPE => 'integer'
            ),
            'do' => array(
                ApiBase::PARAM_TYPE => 'string',
                ApiBase::PARAM_REQUIRED => true
            )
        );
    }

}