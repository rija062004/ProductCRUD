var app = new Vue({
    el: '#App',
    data: {
        dataProduit : "",
        numeroProduit: "",
        design: "",
        prix: "",
        quantite: "",
        id: "",
        showTable: true,
        formDisplay: false,
        add: true,
        update: false,
        titre: "Modifier",
        elseData: "",
        minimum: "",
        maximum: "",
        somme: "",
        dataPoint: "",
        test : 15,
        mychart: ""
    },

    mounted: function (){
        this.fetchData();  
    },

    //Methodes pour le CRUD de la page
    methods:{
        fetchData: function (){
            axios.post('./action.php', {action :'fetchall'}).then(function(response){
                app.dataProduit = response.data;
                app.autreRecuperation();
            });
        },
        tableShow: function (){
            this.showTable= false;
            this.formDisplay = true;
            app.numeroProduit = "";
            app.design="";
            app.prix="";
            app.quantite="";
        },
        displayTable: function(){
            this.showTable= true;
            this.formDisplay= false;
            this.update= false;
            this.add= true;
        },
        dataInsert: function (){
            if(this.design != "" && this.prix && this.quantite){

                axios.post('./action.php',{
                    action : 'insert', 
                    numeroProduit: app.numeroProduit,
                    design : app.design,
                    prix: app.prix,
                    quantite: app.quantite

                }).then(function (response){
                    app.numeroProduit= "";
                    app.design="";
                    app.prix="";
                    app.quantite="";
                    app.showTable= true;
                    app.formDisplay= false;
                    alert(response.data.message);
                    app.fetchData();
                })

            }else{
                alert("Veuillez remplir tous les champs !");
                app.numeroProduit= "";
                    app.design="";
                    app.prix="";
                    app.quantite="";
            }
        },
        dataUpdate: function(id){
            axios.post('./action.php', {
                action: 'update',
                id: id,
                numeroProduit: app.numeroProduit,
                design: app.design,
                prix: app.prix,
                quantite: app.quantite
            }).then(function (response){
                alert(response.data.message);
                app.fetchData();
                app.showTable= true;
                app.formDisplay= false;
            })

        },
        formUpdate: function (id){
            this.update= true;
            this.add= false;
            this.tableShow();
            axios.post('./action.php', {
                action: 'fetch', id: id
            }).then(function (response){
                var data = response.data[0];
                app.id = id;
                app.numeroProduit = data.numProduit;
                app.design = data.design;
                app.prix = data.prix;
                app.quantite = data.qte;

                console.log(app.numProduit);

            })
        },

        deleteProduit: function (id){
            if(confirm("Voulez-vous vraiment supprimer?"))
            {
                axios.post('./action.php', {
                    action: 'delete',
                    id : id
                }).then(function(response){
                    app.fetchData();
                })
            }else{
                alert("Opération annulé");
            }
        },
        autreRecuperation: function(){
            axios.post('./action.php', {
                action: 'fetchElse'
            }).then(function (response){
                // console.log(response.data);
                app.elseData = response.data;
                
                app.minimum = app.elseData[0].minimum;
                app.maximum = app.elseData[0].maximum;
                app.somme = app.elseData[0].somme;
                console.log("NEXT FUNCTION");

                if (app.myChart) {
                    app.myChart.destroy();//Pour détruire la methode
                }
                
                app.histogramme();
                
                
                
            })
        },
        histogramme: function (){
            const ctx = document.getElementById('myChart');
            console.log(this.somme);
            app.myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                  labels: ['Minimum', 'Total', 'Maximum'],
                  datasets: [{
                    label: 'MINIMUM',
                    data: [this.minimum, 0, 0],
                    backgroundColor:'rgba(47, 200, 44, 0.8)',
                    borderWidth: 1
                  },{
                    label: 'MAXIMUM',
                    data: [0, this.maximum, 0],
                    backgroundColor: 'rgba(60, 55, 200, 0.8)',
                    borderWidth: 1
                  },{
                    label: 'TOTAL',
                    data: [0, 0, this.somme],
                    backgroundColor: 'rgba(200, 60, 55, 0.7)',
                    borderWidth: 1
                  }
                
            ]
                },
                options: {
                  scales: {
                    y: {
                      beginAtZero: true,
                      tiks:{
                        callback: function(value, index, values) {
                            if(parseInt(value) >= 1000){
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            } else {
                                return value;
                            }
                        }
                      }
                      
                    }
                  }
                }
              });
        }
    },
    filters:{
        ariary: function(value){
            return value + ' Ar';
        },
        kilo: function(value){
            return value + ' Kg';
        }
    }

 
});