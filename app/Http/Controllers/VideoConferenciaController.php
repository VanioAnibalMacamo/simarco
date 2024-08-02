<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoConferenciaController extends Controller
{
    //

    public function index()
    {
        return view('video_conferencia.videoconferencia');
    }
}
