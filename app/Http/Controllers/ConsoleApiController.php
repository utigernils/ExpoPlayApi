<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use Illuminate\Http\Request;
use App\Http\Requests\StartQuizRequest;
use App\Http\Requests\EndQuizRequest;

use App\Http\Resources\PlayedQuizResource;
use App\Http\Resources\PlayerResource;
use App\Http\Resources\ConsoleInfoResource;

use App\Models\PlayedQuiz;
use App\Models\Console;
use App\Models\Player;

class ConsoleApiController extends Controller
{
    private function getConsole() 
    {
        $apiToken = request()->query('api_token');

        if (!$apiToken) {
            abort(response()->json(['message' => 'Missing api_token parameter.'], 400));
        }

        $console = Console::where('api_token', $apiToken)->first();

        if (!$console) {
            abort(response()->json(['message' => 'Invalid api_token.'], 401));
        }

        return $console;
    }
    public function startQuiz(StartQuizRequest $request)
    {
        $console = $this->getConsole();

        $playedQuiz = PlayedQuiz::create([
            'player_id' => $request->player_id,
            'quiz_id' => $console->current_quiz_id,
            'quiz_name'=> $console->currentQuiz->name,
            'expo_id'=> $console->current_expo_id,
            'expo_name'=> $console->currentExpo->name,
            'started_on' => now(),
            'points' => 0,
            'quiz_max_points' => $console->currentQuiz->totalPoints(),
        ]);

        return new PlayedQuizResource($playedQuiz);
    }
        

    public function endQuiz(EndQuizRequest $request)
    {
        $playedQuiz = PlayedQuiz::find($request->played_quiz_id);

        if (!$playedQuiz) {
            abort(response()->json(['message' => 'Played quiz not found.'], 404));
        }

        if ($playedQuiz->ended_on) {
            abort(response()->json(['message' => 'Quiz has already ended.'], 400));
        }

        $playedQuiz->update([
            'ended_on' => now(),
            'points' => $request->points,
        ]);

        return new PlayedQuizResource($playedQuiz);
    }

    public function checkPlayer() 
    {
        $joinToken = request()->query('join_token');

        if (!$joinToken) {
            abort(response()->json(['message' => 'Missing join_token parameter.'], 400));
        }

        $player = Player::where('join_link', $joinToken)->first();

        if (!$player) {
            return response()->json(['message' => 'no player joined'], 404);
        } else {
            return new PlayerResource($player);
        }
    }

    public function getConsoleInfo() 
    {
        $console = $this->getConsole();
        return new ConsoleInfoResource($console);
    }

    public function getQuizQuestions()
    {
        $console = $this->getConsole();
        return new QuestionResource($console->currentQuiz->questions);
    }
}