<?php

namespace App\Http\Controllers;

use App\Eventos;
use App\TipoEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EventosController extends Controller
{
    //
    public function calendario()
    {
        $tipoEvento = TipoEvento::all();
        return view('calendario2', compact('tipoEvento'));
    }
    public function getEventos($accion = 'leer')
    {
        switch ($accion) {
            case 'agregar':
                $data = \request()->all();
                $evento = new Eventos();
                $evento->title = $data['title'];
                $evento->description = $data['description'];
                $evento->tipoevento = $data['tipoevento'];
                $evento->start = $data['start'];
                $evento->end = $data['end'];
                $evento->save();
                return "exito";
                break;
            case 'eliminar':
                $respuesta = false;
                if (isset($_POST['id'])) {
                    $evento = Eventos::find($_POST['id']);
                    $evento->delete();
                    return "exito";
                }
                return "error";
                break;
            case 'modificar':
                $evento = Eventos::find($_POST['id']);
                $data = \request()->all();
                $evento->update($data);
                return "exito";
                break;
            default:
                header('Content-type: application/json');
                $allEventos = Eventos::all();
                $allEventos = DB::table('eventos')
                    ->leftJoin('tipoEvento', 'eventos.tipoEvento', '=', 'tipoEvento.id')
                    ->select('eventos.id', 'title', 'description', 'start', 'end', 'color', 'textColor', 'tipoEvento', 'tipo')
                    ->get();
                return $allEventos;
                break;
        }
    }
    public function tipoEvento($accion)
    {
        switch ($accion) {
            case 'agregar':
                $data = \request()->all();
                $tipoevento = new TipoEvento();
                $tipoevento->tipo = $data['tipo'];
                $tipoevento->color = $data['color'];
                $tipoevento->textColor = $data['textColor'];
                $tipoevento->save();
                return "$tipoevento->id";
                break;
            case 'modificar':
                $data = \request()->all();
                $tipoevento = TipoEvento::find($_POST['id']);
                $data = \request()->all();
                $tipoevento->update($data);
                return "$tipoevento->id";
                break;
            case 'eliminar':
                $respuesta = false;
                if (isset($_POST['id'])) {
                    $tipoevento = TipoEvento::find($_POST['id']);
                    $tipoevento->delete();
                    return "exito";
                }
                break;
            default:
                return true;
                break;
        }
    }

    public function sendMail(Request $request){
        $subject = "Asunto del correo";
        $for = "llc007.1@gmail.com";
        Mail::send('mails/calendario',$request->all(), function($msj) use($subject,$for){
            $msj->from("llc007.1@gmail.com","NombreQueApareceráComoEmisor");
            $msj->subject($subject);
            $msj->to($for);
        });
        return redirect("/calendario2");
    }
}
