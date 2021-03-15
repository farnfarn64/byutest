<?php

namespace App\Controllers;

use CodeIgniter\Controller;


class Items extends BaseController {
    public function index() {
        echo view('templates/header');

        echo view('pages/home');
	    echo view('templates/footer');
    }

    public function load() {
    	$byu_api = new \App\ThirdParty\Byu();

    	//try to get an item from the api
    	$item = $byu_api->get_item();

    	//if an id is not set then an error was returned
    	if (! isset($item['id'])) {
    		echo view('templates/header');
    		echo view('errors/html/error_404');
    		echo view('templates/footer');
    	} else {
    		$item = $byu_api->format_item($item);
    		$item['base_url'] = "http://localhost:8080/";

	        echo view('templates/header');

	        $parser = \Config\Services::parser();
	        echo $parser->setData($item)
	        		->render('pages/item');
		    echo view('templates/footer');
    	}
    }

    public function rate() {
    	$post_data = $this->request->getPost();

    	if ($post_data['rating'] == "1") {
    		$rating = TRUE;
    	} else {
    		$rating = FALSE;
    	}

    	$byu_api = new \App\ThirdParty\Byu();

    	//rate the item
    	$result = $byu_api->send_review($post_data['item_id'], $rating);

    	if ($result) {
    		echo "success";
    	} else {
    		echo "failure";
    	}
    }
}