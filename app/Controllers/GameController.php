<?php

namespace App\Controllers;

use App\Models\Game;

use Firebase\JWT\JWT;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class GameController extends BaseController
{
    use ResponseTrait;
    public function allGames()
    {
        $gameModel = new Game;
        $offset = $this->request->getVar('offset') ?? 0;
        $limit = $this->request->getVar('limit') ?? 6;
    
        // Fetch games with offset and limit
        $games = $gameModel->findAll($limit, $offset);
    
        // Check if games are found
        if (!empty($games)) {
            $modifiedgames = [];
            foreach ($games as $game) {
                $modifiedgame = $game;
                // Modify game image URL
                $modifiedgame['image'] = base_url($game['image']);
                $modifiedgames[] = $modifiedgame;
            }
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.fetch_games_success'),
                'data' => $modifiedgames
            ], 200);
        }
    
        return $this->respond([
            'code' => '404',
            'message' => lang('Api.no_games_found'),
            'data' => []
        ], 404);
    }
    
    public function index()
    {   
        $user_data = getCurrentUser();
        $gameModel = New Game;
        $this->data['games'] = $gameModel->findAll();
        echo load_view('pages/games/all-games', $this->data);
    }
}
