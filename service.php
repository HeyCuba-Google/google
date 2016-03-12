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

		// create a new client
		$client = new Client();
		$guzzle = $client->getClient();
		$guzzle->setDefaultOption('verify', false);
		$client->setClient($guzzle);

		// create a crawler
		$crawler = $client->request('GET', "https://www.google.com/?q=blah");

    $responses = array();

		// search for result
		$crawler->filter('.g .rc')->each(function($resultdiv) use (&$responses) {
      $responses[] = array(
        "title" => $resultdiv->filter('a')->text(),
        "url" => $resultdiv->filter('a')->attr("href"),
        "note" => $resultdiv->filter('.st')->text()
      );
    });

    // $web = file_get_contents("http://google.com");
    // echo $web;
    //
    // exit;
    //
    // foreach ($responses as $key => $value) {
    //   echo "Value: $value\n";
    // }

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
