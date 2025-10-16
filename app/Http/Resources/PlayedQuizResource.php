<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayedQuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        unset($data['started_on'], $data['ended_on']);

        if (isset($this->started_on) && isset($this->ended_on)) {
            $start = strtotime($this->started_on);
            $end = strtotime($this->ended_on);
            $data['time'] = $end - $start;
        } else {
            $data['time'] = null;
        }

        if (isset($data['points'], $data['quiz_max_points']) && (float)$data['quiz_max_points'] > 0) {
            $data['points_rate'] = round(((float)$data['points'] / (float)$data['quiz_max_points']) * 100, 2);
        } else {
            $data['points_rate'] = null;
        }

        $data['player_name'] = $this->player->first_name . ' ' . $this->player->last_name;

        return $data;
    }
}
