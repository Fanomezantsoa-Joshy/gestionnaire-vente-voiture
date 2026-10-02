<template>

    <div class="contenuFormulaireAjout">

        <form>



            <div class="divFormulaireAjout">

                <div class="divContenuFacture" ref="contenuFacture">

                    <p>Facture N° {{ formulaire.numeroFact }}</p>

                <div class="divEnTeteFacture">
                    Date de facturation : {{ date }} <br>
                    Nom du client : {{ nom }} <br>
                    Contact : {{ contact }}

                </div>

                <div class="divFacture">

                    <Vue3EasyDataTable :headers="enTeteFacture" :items="facture" 
                        hide-footer border-cell
                        header-text-direction="center">

                        <template #item-designation="valeur">

                            <div class="design">

                                {{ valeur.designation }}

                            </div>

                        </template>


                        <template #item-quantite="valeur">

                            <div class="quantite">

                                {{ valeur.quantite }}

                            </div>

                        </template> 
                        
                        <template #item-prix="valeur">

                            <div class="prix">

                                {{ valeur.prix }}

                            </div>

                        </template> 

                        <template #item-total="valeur">

                            <div class="total">

                                {{ valeur.total }}

                            </div>

                        </template> 

                    </Vue3EasyDataTable>

                </div>

                <h3>Arrêté par la présente facture à la somme de {{ lettre }} ariary.</h3>

                </div>


                <div class="divBoutton">

                    <input type="button" value="Retour" id="btnEnregistrer" v-on:click="$router.push('nouveauAchat2')">
                    <input type="button" value="Imprimer" id="btnImprimer" style="margin-left: 20%;" v-on:click.once="imprimer">
                    <input type="button" value="Enregistrer" id="btnEnregistrer" style="float: right;" v-on:click="enregistrer">
                    <input type="button" value="Annuler" id="btnAnnuler" style="float: right;" v-on:click="$router.push('listeAchat')">

                </div>

            </div>


        </form>

    </div>


</template>

<script>

import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import axios from 'axios';
import { toCardinal } from 'n2words/fr-FR';
import { variable } from '@/variable';
import html2pdf from 'html2pdf.js'

    export default {
        name: "formAjout",
        components : {
            Vue3EasyDataTable
        },
        mounted() {
            this.dernierNumero();
            this.afficherListeVoiture();
            const valeurFacture = sessionStorage.getItem("valeurFacture");
            this.facture = JSON.parse(valeurFacture);

            const taille = this.facture.length;
            var total = 0;
            for (var i = 0; i < taille; i++) {
                total = total + parseInt(String(this.facture[i].total).replaceAll(".",""));
            };
            this.lettre = toCardinal(total)
            this.facture.push({total : total.toLocaleString("de-DE") + " Ar"});
        },
        data() {
            return {
                lettre : "",
                numero : sessionStorage.getItem("achatNumeroFacture"),
                date : new Date().toLocaleDateString("fr-FR", { day: '2-digit', month: 'long', year: 'numeric'}),
                nom : sessionStorage.getItem("achatNomClient"),
                contact : sessionStorage.getItem("achatContactClient"),
                recherche : "",
                enTeteFacture : [
                { text : "Désignation", value : "designation", sortable : false },
                { text : "Quantité", value : "quantite", sortable: false},
                { text : "Prix Unitaire", value : "prix", sortable: false},
                { text : "Total", value : "total", sortable: false, width : 200},
                ],
                facture : [],
                formulaire: {
                    numeroFact : this.derNumero,
                }
            }
        },
        methods: {

            async dernierNumero() {
                try {

                    const reponse = await axios.get("http://localhost/gestionnaire-vente-voiture/backend/recupNumAchat.php");

                    if (reponse.status == 202) {
                        console.log("La table achat est vide");
                        this.formulaire.numero = "001";
                        return;
                    }

                    var num = reponse.data.numachat;

                    this.formulaire.numeroFact = String(parseInt(num.substring(4, 7)) + 1).padStart(3, "0");

                } catch (erreur) {
                    alert("Impossible de se connecter aux bases de données !");
                }
            },
            async afficherListeVoiture() {
            try {
                    const response = await axios.get("http://localhost/gestionnaire-vente-voiture/backend/achatListeVoiture.php");
                    this.listeVoiture = response.data;
            } catch (erreur) {
                alert("Connexion impossible !");
                return;
            }
        },
            async enregistrer() {
            try {
                const response = await axios.post("http://localhost/gestionnaire-vente-voiture/backend/nouveauAchat.php", {

                    achat : this.numero,
                    voiture : JSON.parse(sessionStorage.getItem("valeurFacture")),
                    client : sessionStorage.getItem("achatIdCLient"),
                    
                });

                variable.modifierMessage("Achats enregistrée avec succès !");

                this.$router.push({
                    path : "listeAchat",
                    state : { vientDeAjout : true }
                });

            } catch (erreur) {
                alert(erreur.message)
                return;
            }
        },    
        desactiver() {
            document.getElementById("quantite").blur();
        },
        imprimer() {
            const contenu = this.$refs.contenuFacture;
            const date = new Date().toLocaleDateString('fr-FR');
            const options = {
                margin : [20, 5, 0, 5],
                filename : "FACT-" + this.formulaire.numeroFact + " " + date.replaceAll('/', '-') + ".pdf",
                image : { type : 'jpeg', quality : 0.98 },
                html2canvas : {
                    scale : 3,
                    useCORS : 2,
                    logging : false
                },
                jsPDF : {
                    unit : 'mm',
                    format : 'a4',
                    orientation : 'portrait'
                }
            };

            html2pdf().set(options).from(contenu).save();
            document.getElementById("btnImprimer").disabled = true;
        }                      
        }
    }

</script>

<style scoped>

.design {
    padding-left: 20%;
    text-align: left;
}

.quantite {
    text-align: center;
}

.prix, .total {
    padding-right: 20%;
    text-align: right;
}

.contenuFormulaireAjout {
    font-family: "Inter Variable", sans-serif;
    height: 100%;
}

.divEnTeteFacture {
    margin-left: 10%;
    line-height: 30px;
}

p {
    text-align: center;
    font-weight: 600;
    font-size: 18px;
}

.divFormulaireAjout {
    background-color: #fff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    margin-left: 2%;
    margin-right: 2%;
    margin-top: 2%;
    padding-right: 5%;
    padding-left: 5%;
    padding-top: 2%;
}

h3 {
    color: #334155;
    font-size: 15px;
    text-align: center;
}

#btnEnregistrer, #btnImprimer {
    width: 150px;
    margin-left: 30px;
    height: 50px;
    background-color: #7494ec;
    border-radius: 10px;
    border: none;
    outline: none;
    cursor: pointer;
    font-size: 18px;
    color: #fff;
    font-weight: 500;
    box-shadow: 0 4px 14px 0 rgba(116, 148, 236, 0.4);
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

#btnEnregistrer:not(:disabled):hover, #btnImprimer:not(:disabled):hover {
    background-color: #5b7fe8;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(116, 148, 236, 0.5);
}

#btnEnregistrer:disabled {
    cursor: default;
    opacity: 0.6;
}

#btnEnregistrer:not(:disabled):active, #btImprimer:not(:disabled):active  {
    background-color: #436be3;
    transform: translateY(1px) scale(0.97);
    box-shadow: 0 2px 10px rgba(116, 148, 236, 0.4);
    opacity: 0.6;
}

#btnAnnuler {
    width: 100px;
    height: 50px;
    font-size: large;
    color: #ffa500;
    text-decoration: none;
    border: none;
    background-color: transparent;
}

#btnAnnuler:hover {
    color: #d38b05;
    text-decoration: underline;
}

.divBoutton {
    padding-bottom: 2%;
    margin-top: 3%;
}

.divFacture {
    font-family: "Inter Variable", sans-serif;
    --easy-table-border : none;
    --easy-table-row-border: 1px solid #d1d5db;
    --easy-table-header-font-size: 16px;
    --easy-table-header-background-color: #f8fafc;
    --easy-table-header-font-color: #334155;
    --easy-table-body-row-font-size: 15px;
    --easy-table-body-item-padding: 10px 0 10px 0px;
    --easy-table-header-item-padding: 10px 0 10px 0px;
    overflow-x: hidden;
    width: 80%;
    height: 210px;
    margin-left: 10%;
    margin-right: 10%;
    margin-top: 3%;
}

.divContenuFacture {
    border: 1px solid #e2e8f0;
}

:deep(.vue3-easy-data-table__main) {
    border-collapse : collapse;
}

:deep(.vue3-easy-data-table__main table) {
    border-right : 1px solid #d1d5db;  
}

:deep(.vue3-easy-data-table__main table tbody tr:last-child td) {

    border-bottom: 1px solid #d1d5db;

}

:deep(.vue3-easy-data-table__main table tbody tr:last-child td:nth-child(-n+3)) {

    border-right : none;
    border-left : none;
    border-bottom : none;

}

:deep(.vue3-easy-data-table__main table tbody tr:last-child td:nth-child(3)) {

    border-right : 1px solid #d1d5db;

}

:deep(.vue3-easy-data-table__main th) {
    border-top: 1px solid #d1d5db;

}

:deep(.vue3-easy-data-table__header th:first-child), :deep(.vue3-easy-data-table__main table tbody tr td:first-child) {
    border-left: 1px solid #d1d5db;  
}

</style>