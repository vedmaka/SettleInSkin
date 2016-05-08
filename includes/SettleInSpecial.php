<?php

class SettleInSpecial extends UnlistedSpecialPage {

    public function __construct()
    {
        parent::__construct( 'SettleIn' );
    }

    public function execute( $subPage )
    {

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
        }

    }

    /**
     * About us special page
     * @throws Exception
     */
    private function aboutUs() {
        
        $this->getOutput()->setPageTitle('About Us | SettleIn');
        $this->getOutput()->addModules('skins.settlein.special.about');
        $data = array();
        $html = Views::forge( 'aboutus', $data );
        $this->getOutput()->addHTML( $html );

    }

    private function contact() {

        $this->getOutput()->setPageTitle('Contact Us | SettleIn');
        $this->getOutput()->addModules('skins.settlein.special.contact');
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

        $this->getOutput()->setPageTitle('Terms and conditions | SettleIn');
        $this->getOutput()->addModules('skins.settlein.special.tos');
        $data = array();
        $html = Views::forge('tos', $data);
        $this->getOutput()->addHTML( $html );

    }

}