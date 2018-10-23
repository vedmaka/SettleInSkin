<?php

class stoolsapi extends ApiBase {

	public function execute() {

		global $wgPasswordSender;

		// TODO: Implement execute() method.
		$params = $this->extractRequestParams();
		$this->mustBePosted();

		$user = User::newFromId( $params['user'] );

		if( $user->getEmail() ) {
			UserMailer::send(
				new MailAddress( $user->getEmail(), $user->getName() ),
				new MailAddress( $wgPasswordSender ),
				'Thank you from SettleIn user',
				$params['message']
			);
		}

	}

	public function getAllowedParams() {
		return array(
			'user' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => 'integer'
			),
			'message' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => 'string'
			)
		);
	}

}
