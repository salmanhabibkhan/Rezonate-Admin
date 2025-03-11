<?php

namespace App\Controllers\Admin;


use App\Models\Game;
use App\Models\Movie;
use App\Controllers\Admin\AdminBaseController;

class MovieController extends AdminBaseController

{
    private $movieModel;

    public function __construct()
    {
        parent::__construct();
        $this->movieModel = new Movie();
    }

    public function index()
    {
        $this->data['page_title'] = lang('Admin.movies');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_or_customize_movies'), 'url' => ''];
        $this->data['movies'] = $this->movieModel->findAll();
        return view('admin/pages/all-movies', $this->data);
    }


    public function create()
    {
        $this->data['page_title'] = lang('Admin.add_movie');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.add_movie'), 'url' => ''];
        $this->data['js_files'] = ['/assets/js/jquery.validate.min.js'];
        return view('admin/pages/movies/create', $this->data);
    }


    public function store()
    {
        $rules = [
            'movie_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.movie_message.movie_name_required'),
                ],
            ],
            'genre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.movie_message.genre_required'),
                ],
            ],
            'stars' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.movie_message.stars_required'),
                ],
            ],
            'producer' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.movie_message.producer_required'),
                ],
            ],
            'duration' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.movie_message.duration_required'),
                ],
            ],
            'description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.movie_message.description_required'),
                ],
            ],
            'cover_pic' => [
                'rules' => 'uploaded[cover_pic]|mime_in[cover_pic,image/jpg,image/png,image/jpeg,image/gif]',
                'errors' => [
                    'uploaded' => lang('Admin.movie_message.cover_pic_uploaded'),
                    'mime_in' => lang('Admin.movie_message.cover_pic_mime_in'),
                ],
            ],
            'video' => [
                'rules' => 'uploaded[video]|mime_in[video,video/mp4]',
                'errors' => [
                    'uploaded' => lang('Admin.movie_message.video_uploaded'),
                    'mime_in' => lang('Admin.movie_message.video_mime_in'),
                ],
            ],
        ];
    
        if ($this->validate($rules)) {
            $inserted_data = [
                'movie_name' => $this->request->getVar('movie_name'),
                'genre' => $this->request->getVar('genre'),
                'stars' => $this->request->getVar('stars'),
                'producer' => $this->request->getVar('producer'),
                'source' => $this->request->getVar('source'),
                'imdb_link' => $this->request->getVar('imdb_link'),
                'description' => $this->request->getVar('description'),
                'duration' => $this->request->getVar('duration'),
                'release_year' => $this->request->getVar('release_year'),
            ];
    
            $video = $this->request->getFile('video');
            $cover_pic = $this->request->getFile('cover_pic');
    
            if (!empty($video) && $video->isValid() && !$video->hasMoved()) {
                $inserted_data['video'] = storeMedia($video, 'movie', 'video');
            }
            if (!empty($cover_pic) && $cover_pic->isValid() && !$cover_pic->hasMoved()) {
                $inserted_data['cover_pic'] = storeMedia($cover_pic, 'movie_cover');
            }
    
            $this->movieModel->save($inserted_data);
            $session = \Config\Services::session();
            $session->setFlashdata('success', lang('Admin.movie_created_success'));

            return redirect('admin/movies');
        } else {
            $validationErrors = $this->validator->getErrors();
            return view('admin/pages/movies/create', ['validation' => $validationErrors]);
        }
    }
    



    public function edit($id)
    {
        $this->data['page_title'] = lang('Admin.edit_movie');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.edit_movie'), 'url' => ''];
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['movie'] = $this->movieModel->find($id);
        return view('admin/pages/movies/edit', $this->data);
    }


    public function update($id)
    {
        $rules = [
            'movie_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.movie_message.movie_name_required'),
                ],
            ],
            'genre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.movie_message.genre_required'),
                ],
            ],
            'stars' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.movie_message.stars_required'),
                ],
            ],
            'producer' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.movie_message.producer_required'),
                ],
            ],
            'duration' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.movie_message.duration_required'),
                ],
            ],
            'description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.movie_message.description_required'),
                ],
            ],
        ];
    
        if ($this->validate($rules)) {
            $inserted_data = [
                'movie_name' => $this->request->getVar('movie_name'),
                'genre' => $this->request->getVar('genre'),
                'stars' => $this->request->getVar('stars'),
                'producer' => $this->request->getVar('producer'),
                'source' => $this->request->getVar('source'),
                'rating' => $this->request->getVar('rating'),
                'description' => $this->request->getVar('description'),
                'duration' => $this->request->getVar('duration'),
                'release_year' => $this->request->getVar('release_year'),
            ];
    
            $video = $this->request->getFile('video');
            if (!empty($video) && $video->isValid() && !$video->hasMoved() && $video->getSize() > 0) {
                $inserted_data['video'] = storeMedia($video, 'movie');
            }
    
            $cover_pic = $this->request->getFile('cover_pic');
            if (!empty($cover_pic) && $cover_pic->isValid() && !$cover_pic->hasMoved() && $cover_pic->getSize() > 0) {
                $moviecover = storeMedia($cover_pic, 'movie_cover');
                $inserted_data['cover_pic'] = $moviecover;
            }
    
            $this->movieModel->update($id, $inserted_data);
            return redirect('admin/movies');
        } else {
            $validationErrors = $this->validator->getErrors();
            return view('admin/pages/movies/create', ['validation' => $validationErrors]);
        }
    }
    

    public function delete($id)
    {
        $this->movieModel->delete($id);
        return redirect('admin/movies');
    }
}
