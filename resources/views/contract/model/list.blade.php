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
                <form action="{{ route('model-contracts.store') }}" method="POST">
                    <h2>Créer un modèle</h2>
                    @csrf
                    <div class="form-group">
                        <label>Nom du modèle</label>
                        <input type="text" name="name" required value="">
                    </div>
                    <div class="form-group">
                        <label>Contenu</label>
                        <p class="hint">Utiliser #objet.attribut# pour utiliser les variables</p>
                        <ul class="hint">
                            <div>
                                <li>#user.name# : votre nom</li>
                                <li>#date.start# : la date de début</li>
                                <li>#date.end# : la date de fin</li>
                                <li>#price.total# : le montant total</li>
                                <li>#price.month# : le montant par mois</li>
                            </div>

                            <div>
                                <li>#tenant.name# : Le nom du locataire</li>
                                <li>#tenant.address# : L'adresse du locataire</li>
                                <li>#tenant.email# : Le mail du locataire</li>
                                <li>#tenant.phone# : Le téléphone du locataire</li>
                                <li>#tenant.bank_account# : Le compte bancaire du locataire</li>
                            </div>
                            
                            <div>
                                <li>#box.price# : Le prix du box</li>
                                <li>#box.img# : L'image du box</li>
                                <li>#box.address# : L'adresse du box</li>
                            </div>
                        </ul>
                        <div id="editorjs"></div>
                    </div>
                    <input class="links" type="submit" value="Enregistrer">
                    <input type="hidden" name="owner_id" value="{{ Auth::user()->id}}">
                    <input type="hidden" name="content"></input>
                </form>
                <table>
                    <tr>
                        <th>Nom</th>
                        <th>Contenu</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($models as $model)
                    <tr>
                        <td>{{$model[0]->name}}</td>
                        <td class="contract">{!!$model[1]!!}</td>
                        <td>
                            <a class="links" href="{{ route('contrats.create', ['contract', $model[0]->id, Auth::user()->id]) }}">Générer un contrat</a>
                            <a href="{{ route('model-contracts.edit', $model[0]->id) }}" class="links" >Modifier</a>
                            <form action="{{ route('model-contracts.destroy', [$model[0]->id, $model[0]->landlord_id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="links" type="submit">Supprimer</button>
                            </form> 
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/simple-image@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/checklist@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/code@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/table@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/link@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/marker@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/inline-code@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/editorjs-button@latest"></script>


<script>
    const editor = new EditorJS({
        holder: 'editorjs',
        data: {
        },
        tools:{
            header: {
                class: Header,
                inlineToolbar: true
            },
            list: {
                class: EditorjsList,
                inlineToolbar: true
            },
            embed: {
                class: Embed,
                inlineToolbar: true
            },
            linkTool: {
                class: LinkTool,
                inlineToolbar: true
            },
            table: {
                class: Table,
                inlineToolbar: true
            }, 
            simpleImage:{
                class: SimpleImage,
                inlineToolbar: true
            }
        },
        onChange: function () {
            console.log('something changed');
            editor.save().then((outputData) => {
                console.log(document.querySelector('input[name=content]'));
                document.querySelector('input[name=content]').value = JSON.stringify(outputData['blocks'])
            }).catch((error) => {
                console.log('Saving failed: ', error)
            }); 
        }
    })
</script>