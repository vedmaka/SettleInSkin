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
        $data = array();
        $html = Views::forge( 'aboutus', $data );
        $this->getOutput()->addHTML( $html );

    }

    private function contact() {

        $this->getOutput()->addModules('skins.settlein.special.contact');
        $this->getOutput()->setPageTitle('Contact Us | SettleIn');
        $data = array();

        if( $this->getRequest()->wasPosted() ) {

            $name = $this->getRequest()->getVal('name');
            $email = $this->getRequest()->getVal('email');
            $message = $this->getRequest()->getVal('message');
            $reason = $this->getRequest()->getVal('reason');
            //TODO: send email

            $html = Views::forge( 'contactpost', $data );
        }else {
            $html = Views::forge( 'contact', $data );
        }

        $this->getOutput()->addHTML( $html );

    }

    private function tos() {

        $this->getOutput()->addModules('skins.settlein.special.tos');
        $this->getOutput()->setPageTitle('Terms and conditions | SettleIn');
        $data = array();
        $html = Views::forge('tos', $data);
        $this->getOutput()->addHTML( $html );

    }

}