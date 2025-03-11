<?php

namespace App\Controllers;

use App\Models\Movie;
use Firebase\JWT\JWT;
use App\Models\BlogTag;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;

class MovieController extends BaseController
{
    use ResponseTrait;
    public function all()
    {
        $moviesModel  =  New Movie;
        $offset = (!empty($this->request->getVar('offset')))?$this->request->getVar('offset'):0;
        $limit = (!empty($this->request->getVar('limit')))?$this->request->getVar('limit'):6;
        $movies = $moviesModel->findAll($limit,$offset);
        if(!empty($movies))
        {
            foreach ($movies as  $movie) {
                $modiefiedMovie = $movie;
                $modiefiedMovie['video'] = !empty($movie['video'])?base_url($movie['video']):'';
                $modiefiedMovie['cover_pic'] = !empty($movie['cover_pic'])?base_url($movie['cover_pic']):'';
                $modiefiedMovies[] = $modiefiedMovie;

            }
            return $this->respond([
                'code'    => '200',
                'message' => 'Movies Fetch Successfully',
                'data'    => $modiefiedMovies
            ], 200);
        }
        return $this->respond([
            'code'    => '200',
            'message' => 'NO Movie found',
            'data'    => ''
        ], 200);

    }

    public function get_movies()
    {
        $moviesModel = new Movie;
        $offset = $this->request->getVar('offset') ?? 0;
        $limit = $this->request->getVar('limit') ?? 6;

        // Initialize the base query
        $query = $moviesModel;

        // Check for genre or movie_name in the request
        $genre = $this->request->getVar('genre');
        $movieName = $this->request->getVar('movie_name');

        // Filter by genre if it's set
        if (!empty($genre)) {
            $query = $query->where('genre', $genre);
        }

        // Filter by movie_name if it's set
        if (!empty($movieName)) {
            $query = $query->like('movie_name', $movieName);
        }

        // Get the movies with pagination
        $movies = $query->findAll($limit, $offset);

        if (!empty($movies)) {
            $modifiedMovies = [];
            foreach ($movies as $movie) {
                $modifiedMovie = $movie;
                $modifiedMovie['video'] = getMedia($movie['video']);
                $modifiedMovie['cover_pic'] = getMedia($movie['cover_pic']);
                $modifiedMovies[] = $modifiedMovie;
            }
            $this->data['movies'] = $modifiedMovies;
        } else {
            $this->data['movies'] = [];
        }

        // Add genres to the data array
        $this->data['genres'] = [
            'Action', 'Adventure', 'Comedy', 'Drama', 'Thriller', 'Horror',
            'Science Fiction (Sci-Fi)', 'Fantasy', 'Mystery', 'Romance',
            'Animation', 'Family', 'Superhero', 'Documentary', 'Biography'
        ];

        echo load_view('pages/movies/movies', $this->data);
    }

    public function show($id) {
        $moviesModel = new Movie(); // Assuming you have a MovieModel for database operations
        $movie = $moviesModel->find($id);
        
        if (!$movie) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Movie not found');
        }
        // Add genres to the data array
        $this->data['genres'] = [
            'Action', 'Adventure', 'Comedy', 'Drama', 'Thriller', 'Horror',
            'Science Fiction (Sci-Fi)', 'Fantasy', 'Mystery', 'Romance',
            'Animation', 'Family', 'Superhero', 'Documentary', 'Biography'
        ];
        $this->data['movie']  = $movie;

        return load_view('pages/movies/movies-detail',  $this->data );
    }



    public function addMovie()
    {
        $rules = [
            'movie_name'=>'required',
            'genre'=>'required',
            'stars'=>'required',
            'producer'=>'required',
            'release_year'=>'required',
            'duration'=>'required',
            'source'=>'required',
            'video'=>'uploaded[video]|ext_in[video,mp4]|max_length[3000]',
            'rating'=>'required',
        ];
        if ($this->validate($rules)) {
            $movieModel  = New Movie;
            $user_data = getCurrentUser();
            $movie_name = $this->request->getVar('movie_name');

            $inserted_data = [
                'user_id'=>$user_data['id'],
                'movie_name' =>$this->request->getVar('movie_name'),
                'genre' =>$this->request->getVar('genre'),
                'stars' =>$this->request->getVar('stars'),
                'producer' =>$this->request->getVar('producer'),
                'source' =>$this->request->getVar('source'),
                'rating' =>$this->request->getVar('rating'),
                'description' =>$this->request->getVar('description'),
                'duration' =>$this->request->getVar('duration'),
                'release_year' =>$this->request->getVar('release_year'),
            ];  
            
            $cover_pic = $this->request->getFile('cover_pic');
            if(!empty($cover_pic))
            {
                $inserted_data['cover_pic'] = storeMedia($cover_pic, 'movie_thumbnail');
                
            }
            $video = $this->request->getFile('video');
            if(!empty($video))
            {
                $inserted_data['video'] = storeMedia($video, 'movies');
            }
           
            
            $movieModel->save($inserted_data);
            {
                return $this->respond([
                    'code' => '403',
                    'message' => 'Movie Created Successfully',
                    'validation_errors' => $inserted_data
                ], 403);
            }
        }
        else{
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '403',
                'message' => 'Validation error message',
                'validation_errors' => $validationErrors
            ], 403);
        }
    }
    public function editMovie()
    {
        echo base_url();
        die;
        $rules = [
           'movie_id'=>'required'
        ];
        if ($this->validate($rules)) {
            $movie_id = $this->request->getVar('movie_id');
            $movieModel =  New Movie;
            $movie = $movieModel->find($movie_id);
            $movie['cover_pic'] = base_url()."uploads/movie/cover_pic/".$movie['cover_pic'];
            $movie['video'] = base_url()."uploads/movie/video/".$movie['video'];
            return $this->respond([
                'code' => '200',
                'message' => 'Movie data fetch successfully',
                'data' => $movie
            ], 200);
        }
        else{
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '403',
                'message' => 'Validation error message',
                'validation_errors' => $validationErrors
            ], 403);
        }

    }
    public function updateMovie()
    {
        
    }
    public function delete()
    {

    }
    
    
}
