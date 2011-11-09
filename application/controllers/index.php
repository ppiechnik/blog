<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller
{
	private $data = array();
    private $postPerPage;

    public function __construct()
    {        
        parent::__construct();

        $this->load->model('post');
        $this->load->model('tag');
        $this->load->helper('translate_month');

        $this->postPerPage = 6;
        
        $this->data['tags'] = $this->tag->getAllTags();
        $queryResult = $this->post->getPostPublicationDate();
        
        $month = array();
        foreach ($queryResult->row as $p) {
            $month[] = $p->date;
        }
        $this->data['month'] = $month;
    }

    public function post($id)
	{
		$this->data['post'] = $this->post->get_where(array('id' => (int)$id));

		$this->load->view('post', $this->data);
	}

    
    public function tag($name, $offset = 0)
    {
        $this->load->helper('text');
        
        $params = $this->_createContainerStdClass(
            array(
                'name' => $name,
                'offset' => $offset,
            )
        );
    
        $this->_getBy('tag', $params);

    }
    
    public function year($year, $month, $offset = 0)
    {
        $this->load->helper('text');
        
        $params = $this->_createContainerStdClass(
            array(
                'year' => $year,
                'month' => $month,
                'offset' => $offset,
            )
        );
    
    	$this->_getBy('year', $params);
    }
      
    public function index($offset = 0)
    {
        $this->load->helper('text');
        
        $params = $this->_createContainerStdClass(
            array(
                'offset' => $offset,
            )
        );
    
    	$this->_getBy('index', $params);
    }
    
    private function _getBy($type, $params)
    {
        if (! in_array($type, array('index', 'tag', 'year'))) {
            exit;
        } else {
            // na podstawie zmiennej $type jest
            // wywoływana jest odpowiednia metoda modelu Post
            $methodName = 'getBy';
            $methodName .= ucfirst($type);
            $post = $this->post->$methodName($this->postPerPage, $params);
            
            // jeżeli wyników jest więcej niż liczba wyświetleń na stronie
            if ($post->count > $this->postPerPage) {
                // włącz paginację
                
                $url = 'index/';
                $offsetParams = 3;
                                
                $paramsTemp = clone $params;
                unset($paramsTemp->offset);
                
                foreach($paramsTemp as $param) {
                    $url .= $param . '/';
                    ++$offsetParams;
                }
                
                $this->_pagination($url, $post->count, $offsetParams);
                $post->perPage = $this->postPerPage;
            }
            
         	if ($post->count - $params->offset > $this->postPerPage) {
                $post->toDisplay = $this->postPerPage;
            } else {
                $post->toDisplay = $post->count - $params->offset;			
            }
            
            if ($post->toDisplay == 1) {
                $this->data['fixedHeight'] = 'fixedHeight';
            } else {
                $this->data['fixedHeight'] = '';
            }
            
            $this->data['posts'] = $post;
            
            $this->load->view('index', $this->data);
        }
    }

	private function _pagination($url, $count, $uri_segment)
	{
		$this->load->library('pagination');

		$config['base_url'] = base_url() . $url;
		$config['uri_segment'] = $uri_segment;
		$config['total_rows'] = $count;
		$config['per_page'] = $this->postPerPage;
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config); 
	}
    
    private function _createContainerStdClass($elems)
    {
        $container = new stdClass;
        
        foreach ($elems as $key => $value) {
            $container->$key = $value;
        }
        
        return $container;
    }
}
