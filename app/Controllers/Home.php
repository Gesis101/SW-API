<?php namespace App\Controllers;

use CodeIgniter\HTTP\Request;
use function MongoDB\BSON\toJSON;

class Home extends BaseController
{
	public function index()
	{
	    $swapiData = $this->swapiDataFilter($this->getAllSwapiCharacters());

        $data = ['characters' => $swapiData];

		return view('Home', $data);
	}

	//------------------------------------------------------------------

    //Curl GET request to retrieve all SWAPI characters.
    public function getAllSwapiCharacters()
    {
        $curl = curl_init();

        $url = 'https://swapi.dev/api/people/';

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        $result = json_decode($result);
     //ß   var_dump($result);

        curl_close($curl);

        if (isset($error_msg)) {
            var_dump($error_msg);
        }
        return $result;

    }

    //Filters data to return only name and url
    public function swapiDataFilter($array)
    {
        $name = Array(
            'data' => [
                'name'=> [],
                'url'=> []
            ]
        );
        foreach ($array->results as $key => $value)
        {
            array_push($name['data']['name'], $value->name);
            array_push($name['data']['url'], $value->url  );
        }
        return $name;
    }
}
