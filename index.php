<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./font/css/all.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Produits</title>
</head>
<body>

    <div class="container bg-container mt-5 ms-auto me-auto shadow rounded rounded-5" id="App">
        <!--Premier div du page-->
        <div class="container-fluid" v-show="showTable">

            <h1 class="text-center pt-3 ps-3 pe-3  font-monospace fst-italic">Listes des produits</h1>
            <hr style="border: 2px solid black;">

            <div class="table-responsive ">
                <button class="btn btn-dark text-white" @click="tableShow"><i class="fas fa-add"></i></button>
                <table class="table col-12 text-center">
                    <tr style="border-bottom: 2px solid orangered;">
                        <th>Numéros</th>
                        <th>Design</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Montant</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                    <tr v-for="row in dataProduit">
                        <td>{{row.numProduit}}</td>
                        <td>{{row.design}}</td>
                        <td>{{row.prix | ariary}}</td>
                        <td>{{row.qte | kilo}}</td>
                        <td>{{row.prix * row.qte | ariary}}</td>
                        <td><button class="btn btn-warning text-white" @click="formUpdate(row.numProduit)"><i class="fas fa-edit"></i></button></td>
                        <td><button class="btn btn-danger" @click="deleteProduit(row.numProduit)"><i class="fas fa-trash"></i></button></td>
                    </tr>
                </table>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="col-4">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Montant minimum : </strong>{{minimum | ariary}}</li>
                            <li class="list-group-item"><strong>Montant maximum : </strong>{{maximum | ariary}}</li>
                            <li class="list-group-item"><strong>Somme total du montant : </strong>{{somme | ariary}}</li>
                        </ul>
                    </div>
                    <div class="col-5">
                        <canvas id="myChart"></canvas>
                    </div>
            </div>
        </div>
        
        </div>
        <!-- formulaire d'ajout et de modification -->
    
        <div class="container-fluid" v-show="formDisplay">
            <div class="d-flex justify-content-between align-items-center">
                <h1 v-if="add" class=" fst-italic font-monospace mt-3"> Ajouter un produit</h1>
                <h1 v-if="update" class=" fst-italic font-monospace mt-3"> Modifier le produit {{ design }} </h1>
                <h1 @click="displayTable" class="" style="cursor: pointer;">&times</h1>
            </div>
            <hr>

            <form>
                <div class="form-group">
                    <input type="text" v-model="numeroProduit" id="numeroProduit" class="form-control p-3 mb-3" autocomplete="off" placeholder="Numéros du produits">
                </div>
                <div class="form-group">
                    <input type="text" v-model="design" id="design" class="form-control p-3 mb-3" autocomplete="off" autocapitalize="on" placeholder="Design">
                </div>
                <div class="form-group">
                    <input type="text" v-model="prix" id="prix" class="form-control p-3 mb-3" autocomplete="off" placeholder="Prix">
                </div>
                <div class="form-group">
                    <input type="text" v-model="quantite" id="quantite" class="form-control p-3 mb-3" autocomplete="off" placeholder="Quantité" >
                </div>
                <!--Boutton-->
                <div class="text-center">
                    <button type="button"  class="p-3 m-3 col-11 bg" @click="dataInsert"  v-if="add" ><i class="fas fa-add"> AJOUTER</i></button>
                    <button type="button" class="p-3 m-3 col-11 bg" @click="dataUpdate(id)" v-if="update"><i class="fas fa-edit"> Modifier</i></button>
                </div>
            </form>
        </div>
    </div>
    
    
    <script src="./js/vue.js"></script>
    <script src="./js/chart.js"></script>
    <script src="./js/axios-1.x/dist/axios.js"></script>
    <script src="./js/main.js"></script>
</body>
</html>