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
        if ($this->user->hasPermission('view_page')) :
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

        else :
            redirect('admin/nopermission', 'refresh');
            die;

        endif;
    }

    public function page_create()
    {
        if ($this->user->hasPermission('create_page')) :
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

        else :
            redirect('admin/nopermission', 'refresh');
            die;

        endif;
    }

    public function page_update($uri)
    {
        if ($this->user->hasPermission('update_page')) :
        $dados = [
            'title'   => 'Cadastrar Página',
            'title_page' => 'Cadastrar Página - ' . getenv('SIS_TITLE'),
            'user' => $this->user->getUserId($this->session->userOnline['user_id']),
            'page' => $this->page->getPageUrl($uri),
            'pages' => $this->page->getPageParentNull($this->page->getPageUrl($uri)->page_id),
            'menuActive' => [
                "menuPage" => "PageActive"
            ],

            'scripts' => [
                'tinymce' => [
                    'dir' => 'plugins',
                    'file' => 'tinymce/tinymce.min.js'
                ]
            ]
        ];

        $this->template->load('admin/template/template', 'admin/view/page/view-update', $dados);

        else :
            redirect('admin/nopermission', 'refresh');
            die;

        endif;
    }

    public function create()
    {
        $json = [];
        $dados = $this->input->post();

        if ($this->form_validation->set_rules('page_title', 'Nome da página', 'trim|required|min_length[5]|is_unique[tb_page.page_title]')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'page_title';

        elseif ($this->form_validation->set_rules('page_desc', 'Breve Descrição', 'trim|required|min_length[5]')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'page_desc';

        elseif ($this->form_validation->set_rules('page_content', 'Texto/Informações', 'trim|required')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'page_content';

        else :

            $dados["page_parent"] = (($dados["page_parent"] == "null") || ($dados["page_parent"] == 0) ? null : $dados["page_parent"]);
            $dados["page_url"] = slug($dados['page_title']);

            if ($this->page->create($dados)) :

                $json['success'] = 'Cadastro realizado com sucesso!';
                $json['redirect'] = '../page';

            else :
                $json['error'] = 'Erro ao efetuar o cadastro, entre em contato com o suporte!';

            endif;

        endif;

        echo json_encode($json);
    }

    public function update()
    {
        $json = [];
        $dados = $this->input->post();

        if ($this->getTitle($dados['page_id'], $dados['page_title'])) :
            $json["error"] = 'O nome da página <strong>' . $dados['page_title'] . '</strong> já existe';
            $json['focus'] = 'page_title';

        elseif ($this->form_validation->set_rules('page_title', 'Nome da página', 'trim|required|min_length[5]')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'page_title';

        elseif ($this->form_validation->set_rules('page_desc', 'Breve Descrição', 'trim|required|min_length[5]')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'page_desc';

        elseif ($this->page->getSubPages($dados['page_id']) && !empty($dados["page_parent"])) :
            $json["error"] = "A página não poderá ser listada como filha, remova as páginas filhas.";
            $json['focus'] = 'page_parent';

        elseif ($this->form_validation->set_rules('page_content', 'Texto/Informações', 'trim|required')->run() === false) :
            $json['error'] = validation_errors();
            $json['focus'] = 'page_content';

        else :

            $dados["page_parent"] = (($dados["page_parent"] == "null") || ($dados["page_parent"] == 0) ? null : $dados["page_parent"]);
            $dados["page_url"] = slug($dados['page_title']);

            if ($this->page->update($dados)) :

                $json['success'] = 'Atualizado com sucesso!';
                $json['redirect'] = '../../page';

            else :
                $json['error'] = 'Erro ao efetuar o cadastro, entre em contato com o suporte!';

            endif;

        endif;

        echo json_encode($json);
    }

    // VERIFICA SE JÁ EXISTE O MESMO NOME DA PÁGINA
    public function getTitle($page_id, $page_title)
    {
        $title = $this->page->getTitle($page_title);

        if ($title && ($page_id !== $title->page_id)) :
            return true;
        endif;
    }
}
