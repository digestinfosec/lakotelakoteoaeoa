
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
    }

    public function get_tree_categories()
    {
        $categories = $this->category_model->get_category_tree();
        echo json_encode($categories);
    }

}
/* End of file 'Category.php' */
/* Location: ./application/controllers/Category.php */
