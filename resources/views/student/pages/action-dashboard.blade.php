@extends('student.layouts.page', ['contentBackground' => '#33395e'])

@section('content')
    <link href="{{ asset('css/action_teacher.css') }}" rel="stylesheet">
    <style>
.dropbtn {
  background-color: transparent;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

.dropup {
  position: relative;
  display: inline-block;
}

.dropup-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  bottom: 50px;
  z-index: 1;
}

.dropup-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropup-content a:hover {background-color: #ccc}

.dropup:hover .dropup-content {
  display: block;
}

.dropup:hover .dropbtn {
  background-color: #2980B9;
}
</style>

    @php

        use App\Http\Controllers\ProjetActionController;
        use App\Models\Action;
     
  
        $actions = Action::all();

        $projetActionCtrl = new ProjetActionController();

        if (isset($_GET['error'])) {
            echo '<script>
                alert("Une erreur s\'est produite. Le projet n \'a pas été créé");
            </script>';
        }

    @endphp

    <div class="container-fluid" style="color: #FFF; padding-top: 32px;">
        <div class="row">
            <div class="col-md-6" style="margin-bottom: 16px;">
                <h2 class="font-weight-bold">Tableau de bord, ACTION!</h2>
            </div>
            <div class="col-md-6 text-end" style="margin-bottom: 16px;">
                <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
                    data-bs-target="#createProjetModal">
                    <i class="fas fa-plus-circle"></i>
                    Nouveau projet
                </button>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12 mb-3" style="margin-top: 48px; margin-bottom: 8px;">
                <h3 class="font-weight-bold">Les projets en cours</h3>
            </div>
        </div>

        <style>
            td,
            th {
                padding: 8px !important;
            }
            tr:hover{
        background-color: #A0A0A0;
        }
        </style>

        <div class="row">
            <div class="col-md-9" >
                <table id="product-table" class="table table-sm table-bordered">
                    <thead>
                        <th>Projet</th>
                        <th>Format</th>
                        <th>Type</th>
                        <th>Statut</th>
                        <th>Dernière modification</th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody >
                    @foreach ($projetActionCtrl->findProjetsStudent(Auth::user()->id) as $projetAction)
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">{{ $projetAction['nom'] }}</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">Film de {{ $projetAction['type'] }}</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">Individuel</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">En cours</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">
                            @foreach($actions as $action)
                                @if($action->projet_action_id ==  $projetAction['id'] )
                               @php echo date('d m Y H:i', strtotime($action->updated_at)); @endphp
                                @endif
                             @endforeach                       
                            </a></td>
                               <td>
                             
                                <a href="/report/scenario?id={{ $projetAction['id'] }}"style="color:#617A9A; text-align:left; font-size:15px;">  
                            <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/telecharger.png" alt="Télécharger" style=" height: 18px;padding-right:25px;" title="telecharger"/>
                           
                            </a>
                             </td>
                            <td class="header">
                                <div class="dropup">
                                    
                                <a class="dropbtn" style="color:white;">   
                                
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                               
                                </a>
                            
                                <div class="dropup-content">
                                   
                                </div>
                                </div>
                                </td>
                            </tr>
                        @endforeach
                        @foreach ($projetActionCtrl->findProjetsGroupStudent(Auth::user()->id) as $projetAction)
                            <tr>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">{{ $projetAction['nom'] }}</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">Film de {{ $projetAction['type'] }}</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">Individuel</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">En cours</a></td>
                            <td><a href="/student/action?p={{ $projetAction['id'] }}&c=0">
                            @foreach($actions as $action)
                                @if($action->projet_action_id ==  $projetAction['id'] )
                               @php echo date('d m Y H:i', strtotime($action->updated_at)); @endphp
                                @endif
                             @endforeach                      
                            </a></td>
                                <td >
                             
                              
                            <a href="/report/scenario?id={{ $projetAction['id'] }}"style="color:#617A9A; text-align:left; font-size:15px;">  
                            <img src="https://silence-2021.s3.eu-west-3.amazonaws.com/ressources/icon/telecharger.png" alt="Télécharger" style=" height: 18px;padding-right:25px;" title="telecharger"/>
                           
                            </a>
    </td>
                            </td>
                            <td class="header">
                                <div class="dropup">
                                    
                                <a class="dropbtn" style="color:white;">   
                                
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                               
                                </a>
                            
                                <div class="dropup-content">
                                   
                                </div>
                                </div>
                                </td>
                               
                              
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Creer projet modal -->
    <div class="modal fade" id="createProjetModal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="background-color: #4a4d77;">
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="close btn btn-link" style="text-decoration: none;"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i style="color: #d5972b; font-size: 1.5em;" class="fas fa-arrow-alt-circle-left"></i>
                        </button>
                        <button type="button" class="close btn btn-link" style="text-decoration: none;"
                            data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #d5972b; font-size: 2rem;">&times;</span>
                        </button>
                    </div>

                    <h3 class="text-center text-white">
                        Nouveau projet
                    </h3>
                    <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px);">
                        <form id="create_project_form" method="POST" action="/student/student-create">
                        <input type="hidden" name="redirect_url" value="/student/action" />
                        <input type="hidden" name="owner_type" value="student" />
                        <input type="hidden" name="classe" value="classe 1" />
                       
                            @csrf
                            <div class="form-group">
                                <label class="text-white" for="nameInput">Nom du projet</label>
                                <input type="text" class="form-control text-orange" id="nameInput" name="nom"
                                    placeholder="Nom du projet">
                            </div>
                            <div class="form-group">
                                <label class="text-white">Type de projet</label> <br />

                                <div class="bg-white pt-1 pb-1 ps-2 pe-2">
                                    <input type="radio" name="type" value="fiction" class="btn-check" id="fiction"
                                        checked="checked">
                                    <label class="btn btn-light btn-orange" for="fiction">Fiction</label>


                                </div>
                            </div>
                        

      

                        <div class="text-end">
                            <button type="submit" 
                                class="btn btn-orange rounded-pill">Créer</button>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
    @if (request()->input('p', false))
        <!-- Modal -->
        <div class="modal fade" id="creationSuccessModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content pb-2" style="background: #3c3d5f;">
                    <div class="modal-body text-white">
                        <h2 class="mt-2">
                            Projet créé

                            <button class="btn float-end" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times text-white fa-2x"></i>
                            </button>
                        </h2>

                        <div class="text-center mt-5" style="margin-bottom: 64px;">
                            <i class="fas fa-check-circle fa-10x"
                                style="color: #de813b; background: radial-gradient(ellipse at center,  #FFF 50%, #3b3e5e 51%);"></i>
                            <div class="mt-3">
                                <span class="fs-1 d-block">Super !</span>
                                <span class="fs-4 d-block fw-light">Ton projet a été créé, tu peux commencer dès
                                    maintenant ou y revenir plus tard</span>
                            </div>
                        </div>

                        <div class="text-end">
                            <a class="btn btn-orange btn-lg rounded-3"
                                href="/student/action?c=0&p={{ request()->input('p') }}" style="margin-right: 48px;">Je
                                passe à l'ACTION!</a>
                            <button class="btn btn-lg btn-outline-light rounded-3"
                                data-bs-dismiss="modal">Terminé</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#creationSuccessModal").modal('show');
            });
        </script>
    @endif


    <script src="/js/teacher_action.js"></script>
@endsection
