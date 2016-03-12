<?php

 use Goutte\Client;

class Google extends Service
{
	/*
	 * Function executed when the service is called
	 *
	 * @param Request
	 * @return Response
	 * */
	public function _main(Request $request)
	{
    /*
		// create a new client
		$client = new Client();
		$guzzle = $client->getClient();
		$guzzle->setDefaultOption('verify', false);
		$client->setClient($guzzle);

		// create a crawler
		$crawler = $client->request('GET', "https://google.com");

		// search for result
		$result = $crawler->filter('.health-topic-boost-wrapper')->text();
		*/

    $web = file_get_contents("http://google.com");
    echo $web;

    exit;

    $responses = array(
      array("title"=>"Page Title One", "url"=>"http://url.one", "note"=>"description of the page"),
      array("title"=>"Page Title Ten", "url"=>"http://url.one", "note"=>"description of the page"),
      array("title"=>"Page Title two", "url"=>"http://url.one", "note"=>"description of the page"),
      array("title"=>"Page Title Three", "url"=>"http://url.one", "note"=>"description of the page"),
      array("title"=>"Page Title Four", "url"=>"http://url.one", "note"=>"description of the page")
    );

		// create a json object to send to the template
		$responseContent = array(
			"query" => "racing cars",
			"responses" => $responses
		);

		// create the response
		$response = new Response();
		$response->setResponseSubject("[RESPONSE_EMAIL_SUBJECT]");
		$response->createFromTemplate("basic.tpl", $responseContent);
		return $response;
	}
}
