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

    $g_tags = $crawler->filter('.g');

		// search for result
		$g_tags->each(function($obj, $i) use (&$responses) {
      $a_tags = $obj->filter('a');

      if (!empty($a_tags->count())){
        $address = parse_url($a_tags->attr("href"));
        parse_str($address["query"], $address);
        $address = $address["q"];

        $result = array(
          "title" => $a_tags->text(),
          "url" => $address,
          "note" => "",
          "characters" => round(strlen(file_get_contents($address))/1024)
        );

        $st_tag = $obj->filter('.st');

        if (!empty($st_tag->count())) {
          $result["note"] = $st_tag->text();
        }
        if($result["characters"] != 0){
        $responses[] = $result;
      }
      }
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

    if (empty($responses)) {
      $template = "empty.tpl";
    } else {
      $template = "basic.tpl";
    }

		// create the response
		$response = new Response();
		$response->setResponseSubject(" Respuesta del servicio google");
		$response->createFromTemplate($template, $responseContent);
		return $response;
	}
}
