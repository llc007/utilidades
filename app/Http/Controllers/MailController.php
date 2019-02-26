<?php

namespace App\Http\Controllers;

use App\Mail\FormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public function index($mensaje=null){

        if (isset($mensaje)){
            return view('formMail',compact('mensaje'));
        }
        return view('formMail');
    }
    public function sendMail(Request $request){
        $asunto = $request['asunto'];
        $for = $request['email'];
        $mensaje = $request['mensaje'];

        Mail::to($for)
            ->cc($for)
            ->bcc($for)
            ->send(new FormMail($request['mensaje'], $asunto,$for));

        return redirect('/writeMail/'.$mensaje);

//        return view('formMail',compact('mensaje'));
    }
}
