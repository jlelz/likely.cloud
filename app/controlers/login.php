<?php

namespace App\controlers;

use App\controlers\controler;

use Respect\Validation\Validator as v;

use App\models\service;

use App\controlers\lists\feed;

class login extends controler {

	/**
	 * 	Gets the login view
	 *
	 *	@param 	object 	$REQUEST
	 * 	@param 	object 	$RESPONSE
	 *
	 * 	@return object
	 */
	public function get( $REQUEST, $RESPONSE ) {

		//
		//	Fetch active service
		//
		$ACTIVE_SERVICES	= service::fetchActive();
		
		
		//
		//	Setup view
		//
		# @todo: make feed read from cache
		$FEED_DATA	= feed::getRecentRegistries();

		$this->view->getEnvironment()->addGlobal( 'SERVICE_REGISTRIES', $FEED_DATA['SERVICE_REGISTRIES'] );

		return $this->view->render( $RESPONSE, 'login.twig' );

	}


	/**
	 * 	Submits the login view
	 *
	 *	@param 	object 	$REQUEST
	 * 	@param 	object 	$RESPONSE
	 *
	 * 	@return bool
	 */
	public function post( $REQUEST, $RESPONSE ) {

		//
		//	Switch requested service
		//
		if( empty( $REQUEST->getParam( 'service' ) ) ) {

			return $RESPONSE->withRedirect( $this->router->pathFor( 'home' ) );

		}

		switch( $REQUEST->getParam( 'service' ) ) {

			case 'tumblr':

				$SERVICE 	= new services\tumblr( $this->CONTAINER );

				return $SERVICE->login( $REQUEST, $RESPONSE );

			break;

			case 'username':

				$SERVICE 	= new services\email( $this->CONTAINER );

				return $SERVICE->login( $REQUEST, $RESPONSE );

			break;

			default:

				return $RESPONSE->withRedirect( $this->router->pathFor( 'home' ) );

			break;

		}

	}

}