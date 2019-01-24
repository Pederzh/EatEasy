@extends('layouts.app')

@section('content')
 <div class="row">
  <div class="col s12 m5">
  <h5>Risultati:</h5>
  @if($ristoranti->isEmpty())
    <h6>{{$message}}</h6>
  @else
  @foreach($ristoranti as $ristorante)
          <div class="card card medium">
            <div class="card-image">
            <a href="{{ url('/ristorante',$ristorante->ID_esercente) }}">
              <img src="{{'getImgRestaurant/' . $ristorante->ID_esercente . '/' . '1.jpg'}}">
              <span class="card-title">{{$ristorante->nome_esercizio}}</span>
            </a>
            </div>
            <div class="card-content">
              <p>
               <div class="row">
              @foreach($ristorante->classe()->get() as $class)
              <div class="col s4 m4">
                {{$class->nome_classe}}
                <div class="progress">
                  <div class="determinate" style="width: {{$class->pivot->valutazione_classe}}%"></div>
                </div>
              </div>
              @endforeach
              </div>
              </p>
            </div>
        </div>
    
  @endforeach
    @endif
    </div>
    <form class="col s12 m7" method="GET" action="{{ url('/ricerca') }}" enctype="multipart/form-data">
            <h5>Ricerca per luogo e filtri</h5>
              <input id="luogo" name="luogo" type="text" placeholder="Ricerca luogo..." required="" value="{{$luogo}}">
                <ul class="collapsible" data-collapsible="accordion">
                    @foreach($classi as $classe)
                    @if ($classe->ID_classe!=0)
                    <li>
                    <div class="collapsible-header">{{$classe->nome_classe}}</div>
                        <div class="collapsible-body">
                        <div class="row">
                          <div class="col s12">
                              <table class="highlight">
                              @foreach($questions as $question)
                                    @if ($question->id_classe==$classe->ID_classe)
                                      @if (!$question->cliccabile)
                                        
                                          <tr>
                                            <td colspan=3><b>{{$question->domanda}}</b></td>
                                          </tr>
                                      @else
                                        <?php
                                          $dom = $question->ID_domanda_utente;
                                          $esiste = false;
                                        ?>
                                        <tbody>
                                          <tr>
                                            <td>
                                            @if ($filtri != null)
                                            @foreach($filtri as $filtro)
                                              @if ($filtro->ID_domanda_utente == $dom)
                                              <input type="checkbox" checked="on" name={{$dom}} id={{$dom}}><label for={{$dom}}></label>
                                                <?php
                                                  $esiste = true;
                                                ?>
                                              @endif
                                            @endforeach
                                            @endif
                                            @if($esiste == false)
                                            <input type="checkbox"  name={{$dom}} id={{$dom}}><label for={{$dom}}></label>
                                            @endif
                                            </td>
                                                <td>{{$question->domanda}}</td>                  
                                                @if ($question->domanda!=$question->descrizione)
                                                <?php
                                                  $descrizione = $question->descrizione;
                                                ?>
                                                <td>
                                                  <!-- Modal Trigger -->  
                                                  <a class="waves-effect waves-light modal-trigger" data-target={{$dom+100}}><i class="material-icons">info_outline</i></a>
                                                    <!-- Modal Structure -->
                                                    <div id={{$dom+100}} class="modal open" style="top:0px; display:none; z-index: 1003; opacity:0 transform: scaleX(0.7);">
                                                      <div class="modal-content">
                                                        <h8><b><i>Descrizione</i></b></h8><hr>
                                                        <p>{{$descrizione}}</p>
                                                      </div>
                                                      <div class="modal-footer">
                                                        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Ricevuto!</a>
                                                      </div>
                                                    </div>
                                                  </td>
                                                @endif    
                                          </tr>
                                        </tbody>
                                      @endif  
                                    @endif
                            @endforeach

                          </table>  
                          
                        </div>  
                      </div>          
                        </div>
                    </li>
                    @endif
                    @endforeach
                  </ul>
                <!--l'invio dei dati al model avviene attraverso il 'name' degli input-->
                <div class="row">
                  <div class="input-field col s6">
                  <button class="btn waves-effect waves-light" type="submit">Ricerca<i class="material-icons right">send</i></button></div>
                </div>
            </form>
  </div> 
      @include('includes._pagination')
@endsection