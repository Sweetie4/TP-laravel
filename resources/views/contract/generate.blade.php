<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    
    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    
    input{
        width: 100%;
    }
    .links{
        color : rgb(27, 98, 229);
    }
    .links:hover{
        color : rgb(0, 0, 0);
    }
    
    .contract{
        white-space: pre-wrap;
    }
    
    .hint{
        font-size: 12px;
    }
    
    .form-group{
        display: flex;
        flex-direction: column;
        margin:15px 0
        
    }
    
    form{
        padding: 2%;
    }
    
    form h2{
        font-size: 20px;
        text-align: center;
    }
    
    textarea{
        height: 25vh;
    }
    
    ul {
        display: flex;
        justify-content: space-between;
    }
    
    </style>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modèles de contrat') }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form action="{{ route('contracts.store') }}" method="POST">
                        <h2>Créer un modèle</h2>
                        @csrf
                        <div class="form-group">
                            @if ($box[0])
                                <select name="box">
                                    @foreach($box as $b)
                                    <option value="{{$b->id}}">{{$b->address}}</option>
                                    @endforeach
                                </select>
                            @else
                                
                            <select disabled="disabled" >
                                <option selected="selected" value="{{$box->id}}">{{$box->address}}</option>
                            </select>
                            <input name="box" type="hidden" value="{{$box->id}}">
                            @endif
                        </div>
                        <div class="form-group">
                            @if ($tenant[0])
                                <select name="tenant">
                                    @foreach($tenant as $box)
                                    @if($box->tenant)
                                    <option value="{{$box->tenant->id}}">{{$box->tenant->first_name}} {{$box->tenant->last_name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            @else
                            <select disabled >
                                <option selected="selected" value="{{$tenant->id}}">{{$tenant->first_name}} {{$tenant->last_name}}</option>
                            </select>
                            <input name="tenant" type="hidden" value="{{$tenant->id}}">
                            @endif
                        </div>
                        <div class="form-group">
                            @if ($model[0])
                                <select name="model">
                                    @foreach($model as $contract)
                                    <option value="{{$contract->id}}">{{$contract->name}}</option>
                                    @endforeach
                                </select>
                            @else
                            <select disabled >
                                <option selected="selected" value="{{$model->id}}">{{$model->name}}</option>
                            </select>
                            <input name="model" type="hidden" value="{{$model->id}}">
                            @endif
                        </div>
    
                        <input class="links" type="submit" value="Enregistrer">
                        <input type="hidden" name="owner_id" value="{{ Auth::user()->id}}"">
                    </form>
                </div>
            </div>
        </div>
    </x-app-layout>