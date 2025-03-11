<?php

namespace App\Controllers\Admin;

use App\Models\Game;

use App\Controllers\Admin\AdminBaseController;

class gameController extends AdminBaseController
{
    private $gameModel;

    public function __construct()
    {
        parent::__construct();
        $this->gameModel = new Game();
    }

    public function index()
    {
        $this->data['page_title'] = lang('Admin.all_games');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_games'), 'url' => ''];
        $this->data['games'] = $this->gameModel->findAll();
        return view('admin/pages/all-games', $this->data);
    }


    public function create()
    {
        $this->data['page_title'] = lang('Admin.create_new_game');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.create_new_game'), 'url' => ''];
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        return view('admin/pages/games/create', $this->data);
    }


    public function store()
    {
        // Define validation rules with language-specific error messages
        $rules = [
            'name' => [
                'label' => lang('Admin.game_message.name_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.game_message.name_required')
                ]
            ],
            'description' => [
                'label' => lang('Admin.game_message.description_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.game_message.description_required')
                ]
            ],
            'url' => [
                'label' => lang('Admin.game_message.url_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.game_message.url_required')
                ]
            ],
        ];
    
        // Validate the request
        if ($this->validate($rules)) {
    
            $inserted_data = [
                'user_id' => getCurrentUser()['id'], 
                'name' => $this->request->getVar('name'),
                'description' => $this->request->getVar('description'),
                'link' => $this->request->getVar('url'),
            ];
    
            $image = $this->request->getFile('image');
            if (!empty($image) && $image->isValid() && !$image->hasMoved()) {
                $gameimage = storeMedia($image, 'game_image');
                $inserted_data['image'] = $gameimage;
            }
    
            $this->gameModel->save($inserted_data);
            $session = \Config\Services::session();
            $session->setFlashdata('success', lang('Admin.create_game_success'));
            
            return redirect()->to('admin/games');
    
        } else {
            $validationErrors = $this->validator->getErrors();
            return view('admin/pages/games/create', ['validation' => $validationErrors]);
        }
    }
    



    public function edit($id)
    {

        $this->data['page_title'] = lang('Admin.edit_game');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.edit_game'), 'url' => ''];
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['game'] = $this->gameModel->find($id);
        return view('admin/pages/games/edit', $this->data);
    }


    public function update($id)
    {
        $rules = [
            'name' => [
                'label' => lang('Admin.game_message.name_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.game_message.name_required')
                ]
            ],
            'description' => [
                'label' => lang('Admin.game_message.description_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.game_message.description_required')
                ]
            ],
            'url' => [
                'label' => lang('Admin.game_message.url_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.game_message.url_required')
                ]
            ],
        ];
    
        // Validate the request
        if ($this->validate($rules)) {
    
            $inserted_data = [
                'user_id' => getCurrentUser()['id'], 
                'name' => $this->request->getVar('name'),
                'description' => $this->request->getVar('description'),
                'link' => $this->request->getVar('url'),
            ];
    
            $image = $this->request->getFile('image');
            if (!empty($image) && $image->isValid() && !$image->hasMoved()) {
                $gameimage = storeMedia($image, 'game_image');
                $inserted_data['image'] = $gameimage;
            }
    
            $this->gameModel->update($id,$inserted_data);
            $session = \Config\Services::session();
            $session->setFlashdata('success', lang('Admin.update_game_success'));
            
            return redirect()->to('admin/games');
    
        } else {
            $this->data['validation'] = $this->validator->getErrors();
            $this->data['page_title'] = lang('Admin.edit_game');
            $this->data['breadcrumbs'][] = ['name' => lang('Admin.edit_game'), 'url' => ''];
            $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
            $this->data['game'] = $this->gameModel->find($id);
            return view('admin/pages/games/edit', $this->data);
        }
    }


    public function delete($id)
    {
        $this->gameModel->delete($id);
        $session = \Config\Services::session();
        $session->setFlashdata('success', lang('Admin.delete_game_success'));

        return redirect('admin/games');
    }
}
