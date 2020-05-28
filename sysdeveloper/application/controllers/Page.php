<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->user->isLogged();
        $this->user->setLoggedUser();
        $this->load->model(['page_model' => 'page']);
    }

    public function index()
    {
        if ($this->page->getPageParentNull()) :
			foreach ($this->page->getPageParentNull() as $P) :
				$Page[] = [
					"Pages" => $P,
					"subPages" => $this->page->getSubPages($P["page_id"])
				];
			endforeach;
		endif;
        
        $dados = [
            'title'   => 'Páginas',
            'title_page' => 'Páginas - ' . getenv('SIS_TITLE'),	
            'user' => $this->user->getUserId($this->session->userOnline['user_id']),
            'pages' => $Page,
            'menuActive' => [
                "menuPage" => "PageActive",
                "subPage" => "PageHome"
            ]
        ];

        $this->template->load('admin/template/template', 'admin/view/page/view-home', $dados);
    }

    public function page_create()
    {
        $dados = [
            'title'   => 'Cadastrar Página',
            'title_page' => 'Cadastrar Página - ' . getenv('SIS_TITLE'),	
            'user' => $this->user->getUserId($this->session->userOnline['user_id']),
            'pages' => $this->page->getPageParentNull(),
            'menuActive' => [
                "menuPage" => "PageActive",
                "subPage" => "PageCreate"
            ],

            'scripts' => [
                'tinymce' => [
                    'dir' => 'plugins', 
                    'file' => 'tinymce/tinymce.min.js'
                ]
            ]
        ];

        $this->template->load('admin/template/template', 'admin/view/page/view-create', $dados);
    }

    public function page_update($uri)
    {
        //var_dump($this->page->getPageUrl($uri)->page_id); die;
        $dados = [
            'title'   => 'Cadastrar Página',
            'title_page' => 'Cadastrar Página - ' . getenv('SIS_TITLE'),	
            'user' => $this->user->getUserId($this->session->userOnline['user_id']),
            'page' => $this->page->getPageUrl($uri),
            'pages' => $this->page->getPageParentNull($this->page->getPageUrl($uri)->page_id),
            'menuActive' => [
                "menuPage" => "PageActive",
                "subPage" => "PageCreate"
            ],

            'scripts' => [
                'tinymce' => [
                    'dir' => 'plugins', 
                    'file' => 'tinymce/tinymce.min.js'
                ]
            ]
        ];

        $this->template->load('admin/template/template', 'admin/view/page/view-update', $dados);
    }
}
