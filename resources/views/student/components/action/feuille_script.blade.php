<?php

function buildSequencePersonnagesOptions($personnages, $selectedPersonnage)
{
    $result = '';
    foreach ($personnages as $personnage) {
        $checked = trim($personnage) === trim($selectedPersonnage) ? 'selected="selected"' : '';
        $result .= '<option value="' . trim($personnage) . '" ' . $checked . ' >' . trim($personnage) . '</option>';
    }
    return $result;
}

function getSequencePersonnages($sequence)
{
    $personnages = [];

    foreach ($sequence->dialogues_descriptions as $dialogue) {
        if (isset($dialogue->value->personnage)) {
            array_push($personnages, $dialogue->value->personnage);
        }
    }

    foreach ($sequence->personnages as $personnage) {
        array_push($personnages, $personnage);
    }

    return array_unique($personnages);
}



function buildOrangePopover($index){
    return '<i tabindex="' .
        $index .
        '" class="small-help-button fas fa-question-circle" data-bs-toggle="popover" data-bs-placement="top"
                        data-bs-content=\'' .
        getOrangePopoverContent($index) .
        '\' data-bs-template=\'' .
        getOrangePopoverTemplate() .
        '\' data-bs-trigger="focus" data-bs-title=" "></i>';
}

function getOrangePopoverTemplate(){
    return '<div class="popover popover-orange" role="tooltip"><div class="popover-body"></div></div>';
}

function getOrangePopoverContent($index)
{
    switch ($index) {
        case 1:
            return "Correspond au titre du film.";

        case 2:
            return "Correspond au numéro <br/> 
            de la feuille de tournage.Ce numéro <br/> 
            correspond à l'ordre de tournage.";

        case 3:
            return "Correspond au numéro de ta séquence.";

        case 4:
            return "Correspond au numéro de  <br/>
             la carte mémoire dans le cas où  <br/>
             il y en aurait plusieurs.";

        case 5:
            return "Correspond à la prise à <br/> 
            utiliser pour le montage.
            ";

        case 6:
            return "Correspond à l’échelle de plan <br/>
            et l’angle choisi pour le plan.
            ";

        case 7:
            return "Correspond à la date du  <br/>
             tournage du plan.";

        case 8:
            return "Correspond au numéro du plan.";

        case 9:
            return "Correspond au lieu dans le scénario.";

            case 10:
                return "Correspond à la prise à <br/> 
                utiliser pour le montage.
                ";
    
            case 11:
                return "Reprendre les éléments  <br/>
                 figurant dans le découpage technique.
                ";
    
            case 12:
                return "Reprendre les éléments  <br/>
                figurant dans le découpage technique.
                ";
    
            case 13:
                return "Reprendre les éléments  <br/>
                figurant dans le découpage technique.
                ";
    
            case 14:
                return "Lors du tournage, le ou  <br/>
                 la scripte note par un + ou - dans  <br/>
                 les cases ACTION, IMAGE et SON en  <br/>
                 fonction des informations du réalisateur, <br/>
                  du chef opérateur et de l'ingénieur du son.";
  
    }
}

?>


<form id="action-form" class="flex-grow-1" metdod="POST" action="/save-actionDecoupage">
    @csrf
    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
    <input type="hidden" name="redirect_url"
        value="/student/action?p={{ $action->projet_action_id }}&c={{ $chapterKey }}" />
    <input type="hidden" name="decoupage" value="" />



<div class="d-flex flex-column h-100" style="width:100%;text-align:center;float:right;">
    <h4 class="text-center font-weight-bolder action-title">
  
    FEUILLE DE SCRIPT 
    </h4>
    <br />

    
<div style=" letter-spacing:3px; font-weight: 300;">
@php $f = 1; @endphp
@foreach ($jours as $jour)
@foreach ($decoupages as $decoupage)
@if($decoupage->jours == $jour->jours)
        <table>
        <tr style="text-align:center; height:70px;">
            <td colspan="9">FEUILLE DE SCRIPT {!! buildOrangePopover(1) !!} </td>
        </tr>
        <tr>
            <td colspan="6">Titre : {{$action->titre_oeuvre}} {!! buildOrangePopover(1) !!}</td>
            <td colspan="3">MEILLEURE PRISE {!! buildOrangePopover(5) !!}</td>
        </tr>
        <tr>

            
            <td colspan="2">Feuille de tournage n°{{$f}} {!! buildOrangePopover(2) !!}</td>
        @php $f = $f + 1; @endphp


            <td colspan="2">Séquence n° {{ $decoupage->sequence_id }} {!! buildOrangePopover(3) !!}</td>
            <td colspan="2">Carte mémoire n° {!! buildOrangePopover(4) !!}</td>
            <td colspan="2" ></td>
        </tr>
        <tr>
            <td colspan="2">Date :  {!! buildOrangePopover(7) !!}</td>
            <td colspan="2">Plan n° {{ $decoupage->plan }} {!! buildOrangePopover(8) !!}</td>
            <td colspan="2">Lieu : {{ $decoupage->lieu }} {!! buildOrangePopover(9) !!}</td>
            <td colspan="2" style="border-top:1px solid  transparent;"></td>
        </tr>
    
      

        <tr>
            <td colspan="2">Description de l'action </td>
            <td colspan="2">Échelle {!! buildOrangePopover(6) !!} </td>
            <td colspan="2">Angle  {!! buildOrangePopover(6) !!}</td>
            <td colspan="2">Mouvement {!! buildOrangePopover(11) !!}</td>
        </tr>

        <tr>
            <td colspan="2"> {{ $decoupage->description }}</td>
            <td colspan="2">{{ $decoupage->echelle }}</td>
            <td colspan="2">{{ $decoupage->angle }}</td>
            <td colspan="2">{{ $decoupage->mouvement }}</td>
        </tr>

        <tr style="text-align:center; height:100px;">
            <td colspan="9">  OBSERVATIONS (+/-) </td>
        </tr>
        <tr>
            <td colspan="1">PRISE N° {!! buildOrangePopover(10) !!}</td>
            <td colspan="1">ACTION </td>
            <td colspan="1">IMAGE</td>
            <td colspan="1">SON</td>
            <td colspan="5">COMMENTAIRE</td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="1"></td>
            <td colspan="5"></td>
        </tr>

          
        </table>
        <br>
        <br>
@endif
@endforeach
@endforeach
    </div>
   
</div>



