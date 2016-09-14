<?php

class SettleInSpecial extends UnlistedSpecialPage {

    public function __construct()
    {
        parent::__construct( 'SettleIn' );
    }

    public function execute( $subPage )
    {

        $this->getOutput()->enableClientCache(false);

        switch ( $subPage ) {
            case "about":
                $this->aboutUs();
                break;
            case "contact":
                $this->contact();
                break;
            case "tos":
                $this->tos();
                break;
            case "tester":
                $this->tester();
                break;
        }

    }
    
    private function tester() {
        //error_reporting(E_ALL);ini_set('display_errors', 'on');
        $search = new SettleGeoSearch();
        $this->getOutput()->addModules( SettleGeoSearch::getModules() );
        $this->getOutput()->addHTML( $search->getHtml() );
    }

    /**
     * About us special page
     * @throws Exception
     */
    private function aboutUs() {

        $this->getOutput()->addModules('skins.settlein.special.about');
        $this->getOutput()->setPageTitle('About Us | SettleIn');
        $data = array(
        	'img_placeholder' => $this->getSkin()->getSkinStylePath('img/point_m_placeholder.png')
        );
        $html = Views::forge( 'aboutus_new', $data );
        $this->getOutput()->addHTML( $html );

    }

    private function contact() {

    	global $wgEmergencyContact;

        $this->getOutput()->addModules('skins.settlein.special.contact');
        $this->getOutput()->setPageTitle('Contact Us | SettleIn');
        $data = array();

        if( $this->getRequest()->wasPosted() ) {

            $name = $this->getRequest()->getVal('name');
            $email = $this->getRequest()->getVal('email');
            $message = $this->getRequest()->getVal('message');
            $reason = $this->getRequest()->getVal('reason');
            $reason = wfMessage('settlein-skin-project-page-contact-field-reason-value-'.((int)$reason + 1) )->plain();

            $to = new MailAddress( $wgEmergencyContact );
            $from = new MailAddress( $email, $name );
            $subject = "New request from SettleIn website";
            $body = "Reason: " .$reason ."\n\n" . $message;

            UserMailer::send( $to, $from, $subject, $body );

            $this->getOutput()->redirect( $this->getFullTitle()->getFullURL('success=yes') );
            return false;

        }else {
        	if( $this->getRequest()->getVal('success') ) {
		        $html = Views::forge( 'contactpost_new', $data );
	        }else {
		        $html = Views::forge( 'contact_new', $data );
	        }
        }

        $this->getOutput()->addHTML( $html );

    }

    private function tos() {

        $this->getOutput()->addModules('skins.settlein.special.tos');
        $this->getOutput()->setPageTitle('Terms and conditions | SettleIn');
        $data = array();
        $html = Views::forge('tos_new', $data);
        $this->getOutput()->addHTML( $html );

    }

}