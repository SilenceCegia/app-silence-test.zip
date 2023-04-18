<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Decoupage;
use App\Models\ProjetAction;
use App\Models\StudentGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function silencePdf(Request $request)
    {

        $action_id = $request->query('id',  false);

        try {

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('ordre')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['decoupages_s'] = $decoupages_s;
            $data['jours'] = $jours;
            $data['decoupages_p'] = $decoupages_p;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.silence', $data);

            return $pdf->download("silence.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
    
    public function thématiquePdf(Request $request)
    {

        $action_id = $request->query('id',  false);

        try {

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.Thématique', $data);

            return $pdf->download("Thématique.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }

    public function pitchPdf(Request $request)
    {

        $action_id = $request->query('id',  false);

        try {

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.pitch', $data);

            return $pdf->download("pitch.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
    public function shémaPdf(Request $request)
    {

        $action_id = $request->query('id',  false);

        try {

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.shéma', $data);

            return $pdf->download("schéma.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
  
    public function synopsisPdf(Request $request)
    {

        $action_id = $request->query('id',  false);

        try {

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.synopsis', $data);

            return $pdf->download("synopsis.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
  
    public function traitementPdf(Request $request)
    {

        $action_id = $request->query('id',  false);

        try {

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.traitement', $data);

            return $pdf->download("traitement.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
  
    public function scénarioPdf(Request $request)
    {

        $action_id = $request->query('id',  false);

        try {

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.scénario', $data);

            return $pdf->download("scénario.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
  
    public function découpagePdf(Request $request)
    {

        $action_id = $request->query('id',  false);

        try {

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::where('action_id', $action_id)->distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;
            $data['decoupages_s'] = $decoupages_s;


            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.découpage', $data);

            return $pdf->download("découpage.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
  
    public function lieux_tPdf(Request $request)
    {

        $action_id = $request->query('id',  false);

        try {

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::where('action_id', $action_id)->distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.lieux_t', $data);

            return $pdf->download("lieux_t.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
  
    public function liste_acteurPdf(Request $request)
    {

        $action_id = $request->query('id',  false);

        try {

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.liste_acteur', $data);

            return $pdf->download("liste_acteur.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
  
    public function dépouillementPdf(Request $request)
    {

        $action_id = $request->query('id',  false);

        try {

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('lieu')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.dépouillement', $data);

            return $pdf->download("dépouillement.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
  
    public function planningPdf(Request $request)
    {

        $action_id = $request->query('id',  false);

        try {

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('ordre')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['decoupages_l'] = $decoupages_l;
            $data['jours'] = $jours;
            $data['decoupages_p'] = $decoupages_p;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.planning', $data);
            $pdf->setPaper('A4', 'landscape');

            return $pdf->download("planning.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
  
    public function feuille_scriptPdf(Request $request)
    {

        $action_id = $request->query('id',  false);

        try {

            $action = Action::where("id", $action_id)->first();
            $decoupages_d  = Decoupage::where('action_id', $action_id)->distinct()->orderBy('sequence_id','asc')->get('sequence_id');
            $decoupages_l  = Decoupage::distinct()->get('lieu');
            $decoupages = Decoupage::all();
            $jours  =Decoupage::where('action_id', $action_id)->distinct()->orderBy('jours','asc')->get('jours');
            $decoupages_s  = Decoupage::where('action_id', $action_id)->orderBy('sequence_id','asc')->orderBy('plan','asc')->get();
            $decoupages_p  = Decoupage::where('action_id', $action_id)->orderBy('ordre')->get();
         

            if (!$action) {
                return "";
            }

            $nom_auteur = "";

            if ($action->owner_type == "student") {
                $nom_auteur = User::where("id", $action->owner_id)->first()->name;
            } else if ($action->owner_type == "group") {
                $group = StudentGroup::where('id', $action->owner_id)
                    ->first();
                $ids        = array_map('intval', json_decode($group->membres));
                $nom_auteur    = implode(' , ', User::whereIn('id', $ids)->get()->map(function ($user) {
                    return $user->name;
                })->toArray());
            }

            $options = ['isRemoteEnabled' => true];
            $options['isPhpEnabled'] = true;

            $data['action'] = $action;
            $data['decoupages'] = $decoupages;
            $data['jours'] = $jours;
            $data['decoupages_p'] = $decoupages_p;
            $data['decoupages_l'] = $decoupages_l;
            $data['nom_auteur'] = $nom_auteur;

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setOptions($options)->loadView('pdf.feuille_script', $data);

            return $pdf->download("feuille_script.pdf");
        } catch (ModelNotFoundException $e) {
            return "";
        }
    }
  
    

    
    
}
