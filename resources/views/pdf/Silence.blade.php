<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FaisTonFilm') }}</title>

    <style>
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
            return "Correspond au numéro de la séquence.";

        case 2:
            return "Note INT si ta séquence<br/>
            se déroule à l'intérieur et EXT ,<br/>
            si ta séquence se déroule à l'extérieur.";

        case 3:
            return "Note si ta séquence se,<br/>
            déroule le jour ou la nuit";

        case 4:
            return "Correspond à l'action des personnages <br/>
            dans le plan.Il s'agit de tout ce qu'il va <br/>
            se passer à l'image, c'est ce que le  <br/>
            spectateur va voir à l'écran.
            ";

        case 5:
            return "Correspond aux informations  <br/>
            relatives aux costumes et aux accessoires.
            ";

        case 6:
            return "Correspond aux informations  <br/>
            relatives au maquillage et à la coiffure.";

      
    }
}

?>     

table{
    width: 100%;
    height: 80%;

    font-size: 12px;

}



table td{

    height: 30px;
    border:1px solid black;
    
}





        .form-control,
        .btn {
            box-shadow: none !important;
            outline: none !important;
        }

        .btn-check:checked+.btn-outline-primary {
            color: #FFF;
        }

        .action-sidebar .action-menu-item {
            padding: 12px 16px 12px 16px;
            width: 160px;
            text-align: center;
            line-height: 110%;
            font-size: 90%;
        }

        .action-sidebar .action-menu-item.active {
            border-left: 4px solid #d5972b;
            background: #e9d3ad;
            border-bottom-right-radius: 5px;
            border-top-right-radius: 5px;
            text-transform: uppercase;
            font-size: 78%;
        }

        .action-title {
            text-align: center;
            font-weight: bolder;
            font-size: 140%;
            text-transform: uppercase;
            font-family: Arial, Helvetica, sans-serif;
        }

        .action-subtitle {
            color: #999;
            font-size: 90%;
            text-align: center;
            font-weight: 500;
            margin-top: 64px;
            margin-bottom: 16px;
        }

        .action-textarea {
            border: 1px solid #eee;
            resize: none;
            padding: 8px;
        }

        .action-textarea:focus-visible {
            border: 1px solid rgba(74, 77, 119, 0.1);
            outline: none !important;
            box-shadow: 0 0 2px rgba(74, 77, 119, 0.3);
        }

        .help-button {
            color: #FFF;
            font-size: 3rem;
            cursor: pointer;
        }

        .small-help-button {
            color: #d5972b;
            font-size: 1.5rem;
            cursor: pointer;
            position: relative;
            bottom: 12px;
            right: 8px;
            margin-right: -8px;
        }

        .help-button[aria-describedby] {
            color: #7e82a2;
        }

        .popover {
            background: transparent;
            text-align: center;
            max-width: 600px;
        }

        .popover .arrow {
            display: none;
        }

        .popover-body {
            background: #c9cbd8;
            color: #000;
            border-radius: 5px;
        }

        .popover-orange .popover-body {
            background: #e7c384;
        }

        .modal-content {
            background: #9294aa;
            color: #FFF;
            border-radius: 24px;
        }

        .modal-backdrop.show {
            opacity: 0.97;
            background: #FFF;
        }

        .add-personnage-input {
            margin: 0 0 0 16px;
            display: inline-block;
            width: 300px;
        }

        .liste-personnage-item {
            display: inline-block;
        }
    </style>

    <style>
        @font-face {
            font-family: 'Courier';
            src: url({{ storage_path('fonts/CourierPrime-Regular.ttf') }}) format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Courier';
            src: url({{ storage_path('fonts/CourierPrime-Italic.ttf') }}) format("truetype");
            font-weight: normal;
            font-style: italic;
        }

        @font-face {
            font-family: 'Courier';
            src: url({{ storage_path('fonts/CourierPrime-Bold.ttf') }}) format("truetype");
            font-weight: bold;
            font-style: normal;
        }

        @font-face {
            font-family: 'Courier';
            src: url({{ storage_path('fonts/CourierPrime-BoldItalic.ttf') }}) format("truetype");
            font-weight: bold;
            font-style: italic;
        }

        @page {
            size: A4 portrait;
            margin: 32px 64px;
            height: 100%;
        }

        .sequence-scenario-container {
            padding: 32px 64px;
        }

        body {
            font-family: 'Courier', sans-serif;
        }

        .page-cover {
            text-align: center;
            height: 100%;
            position: relative;
        }

        .page-cover .title-container {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            height: 100px;

        }

        .titre-film {
            font-size: 30pt;
            font-family: 'Courier', sans-serif;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .ecrit-par {
            font-size: 13pt;
            font-family: 'Courier', sans-serif;
        }

        .page-break {
            page-break-after: always;
        }
    </style>

<body>
    @guest
    @else
        <div class="page-cover">
            <div class="title-container">
                <div class="titre-film">{{ $action->titre_oeuvre ?? "Titre de l'oeuvre" }}</div>
                <div class="ecrit-par">Écrit par : {{ $nom_auteur }}</div>
            </div>
        </div>

        <div style="clear:both;"></div>
      
        <div class="page-break"></div>

<div style="font-size: 12pt;">

    <div id="scenario-container" class="d-flex flex-column h-100">

        <div id="sequences">

        
       
            <div class="titre-film"  >LA THÉMATIQUE</div>

            <br><br>
            {{ $action->thematique }}
           

        </div>
    </div>
</div>
<div style="clear:both;"></div>

<div class="page-break"></div>

<div style="font-size: 12pt;">

    <div id="scenario-container" class="d-flex flex-column h-100">

        <div id="sequences">

       
            <div class="titre-film">LE PITCH</div>

            <br><br>
            {{ $action->pitch }}
           

        </div>
    </div>
</div>
<div style="clear:both;"></div>

        <div class="page-break"></div>

        <div style="font-size: 12pt;">

<div id="scenario-container" class="d-flex flex-column h-100">

    <div id="sequences">

   
        <div class="titre-film">LE SCHÉMA NARRATIF</div>

        <br><br>

        <table>
        <tr>
            <td>
                <div>Situation initiale</div>
                <div class="text-center">Qui? Où? Quand?</div>
                <div>
                    Expose le contexte, présente le ou les personnages principaux, les lieux, l'environnement du
                    héros et des personnages
                </div>
            </td>
            <td>
                {{ $action->situtation_initiale ?? '' }}
            </td>
        </tr>
        <tr>
            <td>
                <div>Élément perturbateur</div>
                <div>Est le problème auquel le personnage principal sera confronté</div>
            </td>
            <td>
                {{ $action->element_pertubateur ?? '' }}
            </td>
        </tr>
        <tr>
            <td>
                <div>Péripéties</div>
                <div>Ce sont les différentes actions que le personnage principal va devoir faire pour résoudre
                    son problème.
                    À la fin des péripéties vient le Climax, le moment le plus intense du film où le héros va
                    pouvoir résoudre son problème.
                </div>
            </td>
            <td>
              {{ $action->peripeties ?? '' }}
            </td>
        </tr>
        <tr>
            <td>
                <div>Élément de résolution</div>
                <div>Moment où le héros va enfin trouver une solution pour résoudre son problème. </div>
            </td>
            <td>
           {{ $action->element_resolution ?? '' }}
            </td>
        </tr>
        <tr>
            <td>
                <div>Situation finale</div>
                <div>C’est la fin du film, le héros qui était malheureux redevient heureux...ou pas.</div>
            </td>
            <td>
      {{ $action->situation_finale ?? '' }}
            </td>
     </tr>
</table>

       

    </div>
</div>
</div>
<div style="clear:both;"></div>


<div class="page-break"></div>
        <div style="font-size: 12pt;">

<div id="scenario-container" class="d-flex flex-column h-100">

    <div id="sequences">

     
   
        <div class="titre-film">LE SYNOPSIS</div>

        <br><br>
        {{ $action->synopsis }}
       

    
    </div>
</div>
</div>
<div style="clear:both;"></div>

<div class="page-break"></div>
        <div style="font-size: 12pt;">

<div id="scenario-container" class="d-flex flex-column h-100">

    <div id="sequences">

        
   
        <div class="titre-film" >LE TRAITEMENT</div>

        <br><br>
        {{ $action->traitement }}
       

    </div>
</div>
</div>

        <div style="clear:both;"></div>

        @if(!empty($action->scenario))

        <div class="page-break"></div>

        <div class="page-cover">
            <div class="title-container">
                <div class="titre-film">Scenario</div>
                <div class="ecrit-par">Écrit par : {{ $nom_auteur }}</div>
            </div>
        </div>

        <div style="clear:both;"></div>

        <div class="page-break"></div>

        <div style="font-size: 12pt;">

            <div id="scenario-container" class="d-flex flex-column h-100">

                <div id="sequences">
        
                <br><br>
                @php
                        $scenario = json_decode($action->scenario);
                        $sequences = $scenario->sequences;
                        $index = 0;
                    @endphp


                    @foreach ($sequences as $sequence)
                        @php $index++; @endphp
                        <div id="sequence-{{ $index }}" class="sequence-scenario-container">
                            <div class="pb-3">
                                <div style="page-break-inside: avoid;">
                                    <div style="text-transform: uppercase; margin-bottom: 8px;">
                                        {{ $index }}. {{ $sequence->location ?? '' }} - {{ $sequence->lieu }} - {{ $sequence->time ?? '' }}
                                    </div>
                                    <div>
                                        (<span style="text-transform: uppercase;">
                                            {{ implode(', ', $sequence->personnages) }}
                                        </span>)
                                    </div>
                                </div>
                                @foreach ($sequence->dialogues_descriptions as $dialogue_description)
                                    @if ($dialogue_description->type === 'description')
                                        @if (isset($dialogue_description->value->description) && !empty($dialogue_description->value->description))
                                            <div style="padding-top: 32px; text-align: justify; page-break-inside: avoid;">
                                                {{ $dialogue_description->value->description }}
                                            </div>
                                        @endif
                                    @elseif ($dialogue_description->type === 'dialogue')
                                        <div style="padding-top: 32px; page-break-inside: avoid;">
                                            <div style="padding: 0 16px 0 64px;">
                                                <div style="padding-left: 32px; margin-bottom: 10px;">
                                                    <span
                                                        style="text-transform: uppercase;">{{ $dialogue_description->value->personnage }}
                                                    </span>
                                                    @if (isset($dialogue_description->value->emotion) && !empty($dialogue_description->value->emotion))
                                                        (<em>{{ $dialogue_description->value->emotion }}</em>)
                                                    @endif
                                                </div>
                                                <div>
                                                    {{ $dialogue_description->value->dialogue }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <div style="clear:both;"></div>

<div class="page-break"></div>
         
        <div style="font-size: 12pt;">

<div id="scenario-container" class="d-flex flex-column h-100">

    <div id="sequences">

        @php
            $scenario = json_decode($action->scenario);
            $sequences = $scenario->sequences;
            $index = 0;
        @endphp
   
        <div class="titre-film">DECOUPAGE TECHNIQUE</div>

        <br><br>
        <table>
<tr>

    <td style="width:5%;" >
        SÉQ N°
</td>
    <td >
        PLAN N°
</td>

    <td style="width:5%;">
        LIEU 
</td>
    <td style="width:20%;" >
        DESCRIPTION DE L'ACTION 
</td>
    <td style="width:5%;" >
        ÉCHELLE  
</td>
    <td>
        ANGLE 
</td>
    <td style="width:15%;">
        SUR
</td>
    <td style="width:8%;">
        MOUVEMENT CAMÉRA 
</td>
    <td >
        AUDIO 
</td>
    <td >
        RACCORD 
</td>
</tr>

@foreach ($decoupages_s as $decoupage)
<tr>

<td style="width:5%;" >
{{$decoupage->sequence_id}}
</td>
<td >
{{$decoupage->plan}}
</td>

<td style="width:5%;">
{{$decoupage->lieu}}
</td>
<td style="width:20%;" >
{{$decoupage->description}}
</td>
<td style="width:5%;" >
{{$decoupage->echelle}}  
</td>
<td>
{{$decoupage->angle}} 
</td>
<td style="width:15%;">
{{$decoupage->sur}}
</td>
<td style="width:8%;">
{{$decoupage->mouvement}}
</td>
<td >
{{$decoupage->audio}}
</td>
<td >
{{$decoupage->raccord}}
</td>
</tr>
@endforeach
</table>
       

    </div>
</div>
</div>
<div style="clear:both;"></div>

<div class="page-break"></div>
        <div style="font-size: 12pt;">



    @php
            $liste_acteurs= json_decode($action->liste_acteur);
           
        @endphp
     
   
<div id="scenario-container" class="d-flex flex-column h-100">

<div id="sequences">


 

    <div class="titre-film">LISTE DES ACTEURS/ACTRICES</div>

    <br><br>
    <table>
        <tr>
            <td style="width:10%;" >
            Personnage
            </td>
            <td style="width:25%;">
            Prenom
            </td>
        
            <td >
            Nom 
            </td>
            <td style="width:15%;">
            Mails 
            </td>

            <td style="width:15%;">
            Telephone
            </td>
        </tr>
        
       @foreach($liste_acteurs as $liste_acteur)
        <tr>
            <td style="width:10%;" >
            {{$liste_acteur->personnages}}
            </td>
            <td style="width:25%;">
            {{$liste_acteur->prenom}}
            </td>
        
            <td >
            {{$liste_acteur->nom}}
            </td>
            <td style="width:15%;">
            {{$liste_acteur->mails}}
            </td>

            <td style="width:15%;">
            {{$liste_acteur->telephones}}
            </td>
        </tr>
        @endforeach
        
    </table>
   

</div>
</div>
</div>
<div style="clear:both;"></div>

<div class="page-break"></div>

@if(empty( $scenario->personnages))  
@else
   @foreach ($scenario->personnages as $personnage)
                @php
                $index = 0;
                @endphp
      

        <div style="font-size: 12pt;">

            <div id="scenario-container" class="d-flex flex-column h-100">

                <div id="sequences">

                   
               
                    <div class="titre-film">DÉPOUILLEMENT PERSONNAGE</div>
      
                    <br><br>
      
        <table>
                <tr>
                    <td colspan="6">DÉPOUILLEMENT PERSONNAGE :  {{$personnage}}  
                    <input type="hidden" class="form-control" style=" width:100%;"
                            placeholder="note" name="personnage[]" value="{{$personnage}}">
                    </td>
                </tr>
                <tr>
            
                    <td>N° SEQ </td>
                    <td>INT/EXT </td>
                    <td>JOUR/NUIT </td>
                    <td>DESCRIPTION DE L’ACTION</td>
                    <td>NOTES COSTUME ET ACCESSOIRES </td>
                    <td>NOTES MAQUILLAGE/COIFFURE</td>
                </tr>

                @foreach($scenario->sequences as $sequence)
                @php 
                $index++;
             
                 @endphp
                    @foreach(getSequencePersonnages($sequence) as $perso)
                    @php   $perso=trim($perso);
                            $personnage=trim($personnage);
                            $liste_acteurs = json_decode($action->depouillements);
                     @endphp
                    @if($perso == $personnage)
                                <tr>
                                    <td>{{ $index }}</td>
                                    <td>{{ $sequence->location}}</td>
                                    <td>{{  $sequence->time}}</td>
                                    <td>
                                  
                                            @foreach ($sequence->dialogues_descriptions as $keyIndex => $dialogue_description)
                                            @if ( ($dialogue_description->type) == 'description' )
                                                            {{$dialogue_description->value->description }}
                                                        @endif
                                            @endforeach
                                   

                                    </td>
      @if(!empty($liste_acteurs)) 
             @foreach ($liste_acteurs as $personnag)
               
                @php 
                
                 $personn=trim($personnage);
                 $personnagy=trim($personnag->personnage);

                 @endphp
                    @if($personn == $personnagy )
                                    <td>{{$personnag->note_acs}}</td>
                                    <td>{{$personnag->note_maq}}</td>
                                </tr>
                                @endif    
                    @endforeach
              
                @else
                <td></td>
                <td></td>
                                </tr>
            @endif
      @endif
 @endforeach
  @endforeach
       
        </table>

        <br>
        <br>

                   

                </div>
            </div>
        </div>
    
        <div style="clear:both;"></div>

<div class="page-break"></div>
        @endforeach


 

   
        @foreach ($jours as $jour)
       

            <div id="scenario-container" class="d-flex flex-column h-100">

                <div id="sequences">

                    @php
                        $scenario = json_decode($action->scenario);
                        $sequences = $scenario->sequences;
                        $index = 0;
                    @endphp
               
                    <div class="titre-film">PLANNING DE TOURNAGE</div>
      
                    <br><br>
                

<table>
    <tr>
        <td colspan="8"> Jours {{$jour->jours}}</td>
    <tr>
    <tr>
        <td >
            SÉQ N° 
        </td>
        <td  >
            Plan 
        </td>
        <td  >
            LIEU 
        </td>
        <td>
            DÉCORS 
        </td>
    
        <td >
        DESCRIPTION DE L’ACTION 
        </td>
        <td >
        PERSONNAGES
        </td>
        <td >
        HORAIRE DE TOURNAGE 
        </td>
        <td >
        TEMPS DE TOURNAGE 
        </td>
    </tr>


    @php
    $h1 = strtotime($action->pat);
    $test = "O";
    $durée = "00:00:00";
    @endphp

@foreach ($decoupages_p as $decoupage)
    @if($decoupage->jours == $jour->jours)
        <tr>
            <td>{{$decoupage->sequence_id}}</td>
            <td>{{$decoupage->plan}}</td>
            <td>{{$decoupage->lieu}}</td>
            <td>{{$decoupage->decors}}</td>
                <td>
            @php
            $descriptions = json_decode($decoupage->description);
            @endphp
            @if(!empty($descriptions[0]))
            {{$descriptions[0]}}
            @endif

            </td>
            <td>
            @php
            $personnages = json_decode($decoupage->sur);
            @endphp
              @if(!empty($personnages))
            @foreach ($personnages as $personnage)
               
            {{$personnage}}
            <br>
            @endforeach
                @endif
            </td>
            <td>
            @if($test == $decoupage->lieu && strtotime($h1) >= strtotime($action->pat) )
            {{ ucfirst($h1 = gmdate("H:i:s", strtotime($h1) + strtotime($durée))) }}
            @elseif(strtotime($h1) < strtotime($action->pat) ) 
            {{ ucfirst($h1 = gmdate("H:i:s", strtotime($action->pat)  )) }}
            @else
            {{ ucfirst($h1 = gmdate("H:i:s", strtotime($h1) + strtotime($durée) + strtotime("00:20:00") )) }}
            @endif
            </td>
            <td>{{$decoupage->durée}}
            
            </td>
        </tr>
        @endif
    @endforeach
 
</table>
<br>
<br>
      

                </div>
            </div>
        </div>
        <div style="clear:both;"></div>


<div class="page-break"></div>
@endforeach
@endif
@endif
@if(!empty($jours))
        @php $f = 1; @endphp
@foreach ($jours as $jour)
@foreach ($decoupages as $decoupage)
@if($decoupage->jours == $jour->jours)
      

        <div style="font-size: 12pt;">

            <div id="scenario-container" class="d-flex flex-column h-100">

                <div id="sequences">

                    @php
                        $scenario = json_decode($action->scenario);
                        $sequences = $scenario->sequences;
                        $index = 0;
                    @endphp
               

      
                    <br><br>

                    <table >
        <tr style="text-align:center; height:70px;">
            <td colspan="9">FEUILLE DE SCRIPT </td>
        </tr>
        <tr>
            <td colspan="6">Titre : {{$action->titre_oeuvre}} </td>
            <td colspan="3">MEILLEURE PRISE </td>
        </tr>
        <tr>

            
            <td colspan="2">Feuille n°{{$f}}</td>
        @php $f = $f + 1; @endphp


            <td colspan="2">Séquence n° {{ $decoupage->sequence_id }}</td>
            <td colspan="2">Carte mémoire n°</td>
            <td colspan="3" ></td>
        </tr>
        <tr>
            <td colspan="2">Date : </td>
            <td colspan="2">Plan n° {{ $decoupage->plan }}</td>
            <td colspan="2">Lieu : {{ $decoupage->lieu }} </td>
            <td colspan="3" style="border-top:1px solid  transparent;"></td>
        </tr>
    
      

        <tr>
            <td colspan="2">Description de l'action </td>
            <td colspan="2">Échelle  </td>
            <td colspan="2">Angle</td>
            <td colspan="3">Mouvement </td>
        </tr>

        <tr>
            <td colspan="2"> {{ $decoupage->description }}</td>
            <td colspan="2">{{ $decoupage->echelle }}</td>
            <td colspan="2">{{ $decoupage->angle }}</td>
            <td colspan="3">{{ $decoupage->mouvement }}</td>
        </tr>

        <tr style="text-align:center; height:100px;">
            <td colspan="9">  OBSERVATIONS (+/-) </td>
        </tr>
        <tr>
            <td colspan="1">PRISE N° </td>
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
 <div style="clear:both;"></div>
 <div class="page-break"></div>
 @endif
@endforeach
@endforeach
@endif
    <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $page_number = $pdf->get_page_number();
                    if($PAGE_NUM > 1){
                        $pdf->text(820, 520, "Page ".($PAGE_NUM-1)."/".($PAGE_COUNT-1), "Courier", 12, array(0,0,0));
                    }
                ');
            }
        </script>
 @endguest

</body>

</html>
