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
/*
$url = "https://www.google.com/search?hl=es&q=" .$request->query;
$text = file_get_contents($url);
echo $text;
exit;
*/
		// create a crawler
		$crawler = $client->request('GET', "https://www.google.com/search?hl=es&q=".$request->query);

    $responses = array();

		// search for result
		$crawler->filter('.g')->each(function($obj) use (&$responses) {
      // $title = $obj->filter('.r')->text();
      // $title = $obj->filter('.r')->text();

      // echo "<br/><br/>";
      //
      $responses[] = array(
        "title" => $obj->filter('a')->text(),
        "url" => $obj->filter('a')->attr("href"),
        "note" => $obj->filter('.st')->text()
      );
    });

  //  print_r($responses);
  //   exit;

     //$web = file_get_contents("http://google.com");
     //echo $web;

     //exit;

     //foreach ($responses as $key => $value) {
     //echo "Value: $value\n";
     //}

		// create a json object to send to the template
    // echo $request -> query;
		$responseContent = array(
			"query" => $request->query,
			"responses" => $responses
		);

		// create the response
		$response = new Response();
		$response->setResponseSubject("[RESPONSE_EMAIL_SUBJECT]");
		$response->createFromTemplate("basic.tpl", $responseContent);
		return $response;
	}
}
