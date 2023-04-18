<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\ProjetAction;
use App\Models\StudentGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjetActionController extends Controller
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

    public function delete($id)
    {
        $projet=ProjetAction::find($request->id_delete_dec);
        $projet->delete();

        $actions=Action::where("projet_actions", $id)
        ->get();
        $actions->delete();
    }

    public function creer(Request $request){
        try {
            DB::beginTransaction();
            $redirectUrl = $request->redirect_url;

            $projet = new ProjetAction();
            $projet->nom = $request["nom"];
            $projet->type = $request["type"];
            $projet->classe = $request->input("classe", session('group'));
            $projet->description = $request->input("description", "");

            $projet->owner_type = $request["owner_type"];
            $projet->owner_id = $request->user()->id;

            $projet->save();


            // Projet créé par un professeur pour des groupes d'élèves

            $groups = json_decode($request->groups);

            foreach ($groups as $grp) {

                $group = new StudentGroup();
                $group->nom = $grp->name;
                $group->projet_action_id = $projet->id;
                $members = json_encode(
                    array_map(function ($m) {
                        return "$m->id";
                    }, $grp->members)
                );

                $group->membres = $members;
                $group->save();

                $action = new Action();
                $action->owner_id = $group->id;
                $action->owner_type = "student_group";
                $action->projet_action_id = $projet->id;

                $action->save();
            }


            DB::commit();
        } catch (\Exception $e) {
            $redirectUrl .= "?error=1";
            DB::rollBack();
        }

        return redirect($redirectUrl);
    }

    public function studentCreateProject(Request $request)
    {
        try {
            DB::beginTransaction();
            $redirectUrl = $request->redirect_url;

            $projet = new ProjetAction();
            $projet->nom = $request["nom"];
            $projet->type = $request["type"];
            $projet->classe = $request["classe"];
            $projet->description = $request->input("description", "");

            $projet->owner_type = $request["owner_type"];
            $projet->owner_id = Auth::user()->id;

            $projet->save();

            // Projet créé par l'élève lui même, creation de l'action
            $action = new Action();
            $action->owner_id = $projet->owner_id;
            $action->owner_type = "student";
            $action->projet_action_id = $projet->id;

            $action->save();

            $redirectUrl .= "?p=$projet->id";


            DB::commit();
        } catch (\Exception $e) {
            $redirectUrl .= "?error=1";
            DB::rollBack();
        }

        return redirect($redirectUrl);
    }

    public function joinProject(Request $request)
    {
        $action = new Action();
        $action->owner_id = $request->input("group_id");
        $action->owner_type = "student_group";
        $action->projet_action_id = $request->input("project_id");
        $action->save();
        return redirect("/student/action-dashboard");
    }

    public function findProjetsStudent($student_id)
    {
        return ProjetAction::where([
            'owner_type' => 'student',
            'owner_id' => $student_id
        ])->Orderby('updated_at','ASC')->get();
        // return ProjetAction::get();
    }

    public function findProjetsGroupStudent($student_id)
    {

        $groups = StudentGroup::where('membres', 'LIKE', '%"' . $student_id . '"%')->get()->toArray();

        $groups_ids = array_map(function ($m) {
            return $m["id"];
        }, $groups);

        $actions = Action::where("owner_type", "student_group")
            ->whereIn('owner_id', $groups_ids)
            ->Orderby('updated_at','ASC')
            ->get()->toArray();

        $projets_ids = array_map(function ($m) {
            return $m["projet_action_id"];
        }, $actions);

        return ProjetAction::whereIn(
            'id',
            $projets_ids
        )->get();
    }

    public function countStudentsOfProject($project_id)
    {

        $number_students = 0;

        $actions = Action::where('projet_action_id', $project_id)->get();
        foreach ($actions as $action) {
            if ($action->owner_type == 'student') {
                $number_students++;
            } else {
                $std_grp = StudentGroup::where('id', $action["owner_id"])->get()->first();
                $number_students += substr_count($std_grp["membres"], ",") + 1;
            }
        }

        return $number_students;
    }

    public function findByProfesseur($professeur_id, $classe)
    {
        return ProjetAction::where(["owner_id" => $professeur_id, "owner_type" => "teacher", "classe" => $classe])->get();
    }

    public function findForCurrentProfesseur()
    {
        $classe = session('group');
        return $this->findByProfesseur(Auth::id(), $classe);
    }
}
