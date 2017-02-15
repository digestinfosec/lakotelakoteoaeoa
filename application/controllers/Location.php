<?php
require_once APPPATH . "libraries/Public_Controller.php";
class Location extends Public_Controller
{
    public function index()
    {
        $address = $this->input->get('address');
        $city = $this->input->get('city');
        $country = $this->input->get('country');
        $result = $this->get_location($address);
//        $address = $city . ', ' . $country;
//        $result = $this->get_location($address);

        $this->output->set_content_type('application/json');
        echo json_encode($result);
    }

    protected function get_location($query)
    {
        $apiKey = 'AIzaSyCo75EldXjvZDsgDAeWckqKcQ-LV1qOlvM';
        $googlePlaces = new Mills\GooglePlaces\googlePlaces($apiKey);

        $googlePlaces->setQuery(urldecode($query));

        $result = $googlePlaces->textSearch();
        return $result;
    }

    public function change_location($location = '')
    {
        $language = $this->input->get("lang") ? $this->input->get("lang") : $location;
        if ($language) {
            if (in_array($language, ['ID', 'SG'])) {
                $this->set_location($language, true);
            }
        }
        redirect_back();
    }
}
