<?php

namespace App\Http\Controllers\Minapp\Team;

use App\Models\TeamPrivacy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamPrivacyController extends Controller
{
    public function teamPrivacy()
    {
        try {
            $data= TeamPrivacy::first();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
