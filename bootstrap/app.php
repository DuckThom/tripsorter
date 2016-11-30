<?php

use \App\Objects\Trip;

class Application
{

    /**
     * Run the application.
     */
    public function run()
    {
        // Test data in JSON format
        $json = file_get_contents(base_path('data.json'));

        $trip = new Trip($json);

        return $trip->generate();
    }

}