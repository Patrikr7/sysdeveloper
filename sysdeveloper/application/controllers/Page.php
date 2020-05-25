<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->user->isLogged();
        $this->user->setLoggedUser();
    }

    public function index()
    {
        $dados = [
            'title'   => 'Páginas',
<<<<<<< HEAD
            'title_page' => 'Páginas - ' . getenv('SIS_TITLE'),	
=======
            'title_page' => 'Páginas',
>>>>>>> 41a7919cd8349e392a820f468268b365283ca407
            'user' => $this->user->getUserId($this->session->userOnline['user_id']),
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
<<<<<<< HEAD
            'title_page' => 'Cadastrar Página - ' . getenv('SIS_TITLE'),	
=======
            'title_page' => 'Cadastrar Página',
>>>>>>> 41a7919cd8349e392a820f468268b365283ca407
            'user' => $this->user->getUserId($this->session->userOnline['user_id']),
            'menuActive' => [
                "menuPage" => "PageActive",
                "subPage" => "PageCreate"
            ]
        ];
        $this->template->load('admin/template/template', 'admin/view/page/view-create', $dados);
    }
}
