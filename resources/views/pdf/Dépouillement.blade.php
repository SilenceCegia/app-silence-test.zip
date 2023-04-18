<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FaisTonFilm') }}</title>
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
    <style>
        

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
</head>



<body>
    @guest
    @else
       
        @php
                    $scenario = json_decode($action->scenario);
             
                @endphp
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
@endif

        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $page_number = $pdf->get_page_number();
                    if($PAGE_NUM > 1){
                        $pdf->text(520, 820, "Page ".($PAGE_NUM-1)."/".($PAGE_COUNT-1), "Courier", 12, array(0,0,0));
                    }
                ');
            }
        </script>

    @endguest

</body>

</html>
