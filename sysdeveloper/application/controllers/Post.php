<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Post extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
		$this->user->isLogged();
		$this->user->setLoggedUser();
        $this->load->model(['post_model' => 'post']);
    }

    public function page_index($page = null)
    {
        $url = base_url('admin/posts');
        $total_rows = $this->post->getCount();
        $per_page = 3;
        $totalPages = ceil($total_rows / $per_page); 

        $curr_page = 0;

        if(empty($this->uri->segment(3))):
            $page = 1;
        endif;

        if(isset($page) && trim($page) != ''):
            if ((($per_page * $page) - $per_page) > 0) {
                $curr_page = (($per_page * $page) - $per_page);
            }
        endif;

        if(($page > $totalPages || $page < 1) && $total_rows != 0):
            redirect('admin/posts/page/' . $totalPages, 'refresh');
            exit;
        endif;        

        $this->pagination->initialize(config_pagination($url, $total_rows, $per_page));

        if ($this->user->hasPermission('view_post')) :
            $dados = [
                'title'      => 'Artigos',
                'title_page' => 'Artigos - ' . getenv('SIS_TITLE'),
                'user'       => $this->user->getUserId($this->session->userOnline['user_id']),
                'posts'      => $this->post->getPosts($per_page, $curr_page),
                'links'      => $this->pagination->create_links(),
                'menuActive' => [
                    "menuPage" => "PostActive",
                    "subPage" => "PostHome"
                ]
            ];

            $this->template->load('admin/template/template', 'admin/view/post/view-home', $dados);

        else :
            redirect('admin/nopermission', 'refresh');
            die;

        endif;
    }

    public function page_create()
    {
        if ($this->user->hasPermission('create_post')) :
            $dados = [
                'title'      => 'Cadastrar Artigo',
                'title_page' => 'Cadastrar Artigo - ' . getenv('SIS_TITLE'),
                'user'       => $this->user->getUserId($this->session->userOnline['user_id']),
                'menuActive' => [
                    "menuPage" => "PostActive",
                    "subPage" => "PostCreate"
                ]
            ];
            $this->template->load('admin/template/template', 'admin/view/post/view-create', $dados);

        else :
            redirect('admin/nopermission', 'refresh');
            die;

        endif;
    }

}