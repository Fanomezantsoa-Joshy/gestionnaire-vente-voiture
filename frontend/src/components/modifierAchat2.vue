<template>

    <div class="contenuFormulaireAjout">

        <form>

            <div class="divEnTete">

                <div>

                    Numéro : <input type="text" id="numero" readonly v-model="formulaire.numero">

                </div>

                <p id="titre">Modification d'un achat</p>

            </div>

            <div class="divFormulaireAjout">

                <p id="titreTableau">Voiture(s) :</p>

                <div class="divRecherche">
                    Recherche : <input type="text" placeholder="Rechercher dans la liste" v-model="recherche">
                    <img src="../assets/icons/chercher.png" class="iconRecherche">
                </div>

                <div class="divListeVoiture">

                    <Vue3EasyDataTable :headers="enTeteListeVoiture" :items="listeVoiture" alternating theme-color="#42b883"
                        :search-field="champRecherche" :search-value="recherche"
                        item-id="id"
                        hide-footer
                        empty-message="Aucune donnée trouvée"
                        header-text-direction="center" body-text-direction="center">

                        <template #item-actions="valeur">

                            <div>

                                <input type="checkbox" name="choix" class="choix" v-model="selected[valeur.idvoit]" 
                                v-on:click="verifier(valeur.idvoit)" :id="valeur.idvoit">

                            </div>

                        </template>

                        <template #item-quantite="valeur">

                            <div>

                                <input type="number" class="quantite" min="1" :id="'quantite' + valeur.idvoit" v-model="quantite[valeur.idvoit]"
                                 v-on:keydown.prevent value="1"><br>


                            </div>

                        </template>                        
                        

                    </Vue3EasyDataTable>

                </div>


                <div class="divBoutton">

                    <input type="button" value="Retour" id="btnSuivant" v-on:click="retour">
                    <input type="button" value="Suivant" id="btnSuivant" v-on:click="suivant" style="float: right;">
                    <input type="button" value="Annuler" id="btnAnnuler" v-on:click="$router.push('listeAchat')" style="float: right;">

                </div>

            </div>


        </form>

    </div>


</template>

<script>

import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import axios from 'axios';
import { variable } from '@/variable';

    export default {
        name: "formAjout",
        components : {
            Vue3EasyDataTable
        },
        mounted() {
            this.afficherListeVoiture();
        },
        data() {
            return {
                items : [],
                selected : {},
                quantite : {},
                listeDesValeurs : [],
                message : variable,
                max : 0,
                recherche : "",
                champRecherche : ["idvoit", "design"],
                enTeteListeVoiture : [
                { text : "Choix (max = 3)", value : "actions"},
                { text : "Identifiant", value : "idvoit", sortable: true},
                { text : "Désignation", value : "design", sortable: true},
                { text : "Prix", value : "prix", sortable: true},
                { text : "Nombre", value : "nombre", sortable: true},
                { text : "Quantité", value : "quantite", width : 120},
                ],
                listeVoiture : [],
                formulaire: {
                    numero: sessionStorage.getItem("modAchatNumeroFacture")
                }
            }
        },
        methods: {
            async afficherListeVoiture() {
            try {
                    const response = await axios.get("http://localhost/gestionnaire-vente-voiture/backend/modAchatListeVoiture.php");
                    this.listeVoiture = response.data;
                    
                    this.processData(this.listeVoiture);

                    this.$nextTick(() => {

                    const valeur = JSON.parse(sessionStorage.getItem("modValeurFacture"));


                    if(valeur.length > 0) {
                            for (var i = 0; i < valeur.length; i++) {
                            document.getElementById(valeur[i].idvoit).checked = true;
                            this.quantite[valeur[i].idvoit] = valeur[i].qte;
                            this.selected[valeur[i].idvoit] = true;
                        }
                    }

                    })

            } catch (erreur) {
                alert("Connexion impossible !" + erreur.message);
                return;
            }
        },
        processData(valeur) {
            this.items = valeur;
            valeur.forEach(item => {
                this.selected[item.idvoit] = false;
                this.quantite[item.idvoit] = 1;
            });
        },
        suivant() {

            const valeur = this.items.filter(item => this.selected[item.idvoit]);

            if(valeur.length < 1) {
                alert("Veuillez choisir une voiture !");
                return;
            }
            
            const valeurFacture = valeur.map(ligne => {
                return {
                    idvoit : ligne.idvoit,
                    designation : ligne.design,
                    qte : this.quantite[ligne.idvoit],
                    prix : Number(ligne.prix).toLocaleString("de-DE") + " Ar",
                    total : (parseInt(this.quantite[ligne.idvoit]) * parseInt(ligne.prix)).toLocaleString("de-DE") + " Ar"
                }
            })
            sessionStorage.setItem("modValeurFacture", JSON.stringify(valeurFacture));
            this.$router.push("modifierAchat3");
        },
        verifier(id) {
            const valeur = this.items.filter(item => this.selected[item.idvoit]);

            if(valeur.length == 3) {
                document.getElementById(id).checked = false;
            }
        },
        retour() {
            const valeur = this.items.filter(item => this.selected[item.idvoit]);
            const valeurFacture = valeur.map(ligne => {
                return {
                    idvoit : ligne.idvoit,
                    qte : this.quantite[ligne.idvoit],
                }
            })
            sessionStorage.setItem("modValeurFacture", JSON.stringify(valeurFacture));
            this.$router.push('modifierAchat1')
        }                
        }
    }

</script>

<style scoped>

#titre {
    position: absolute;
    font-size: 25px;
    font-family: "Inter Variable", sans-serif;
    color: #7494ec;
    font-weight: 600;
    margin-left: 65%;
}

#titreTableau {
    position: absolute;
    font-size: 20px;
    font-family: "Inter Variable", sans-serif;
    color: #7494ec;
    font-weight: 600;
    margin-left: 10%;
    margin-top: 3%;
}

.contenuFormulaireAjout {
    font-family: "Inter Variable", sans-serif;
    height: 100%;
    align-content: center;
}

.iconRecherche {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    height: 25px;
    width: 25px;
    margin-left: -8%;
}

.divRecherche {
    margin: 30px 0 20px 50px;
    font-family: "Inter Variable", sans-serif;
    font-size: 16px;
    font-weight: 500;
    position: relative;
    margin-left: 55%;
}

.divRecherche input {
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 10px 20px 10px 10px;
    background-color: #f8fafc;
    font-family: "Inter Variable", sans-serif;
    font-size: 15px;
    outline: none;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    margin-left: 10px;
}

.divRecherche input:hover {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}


.divEnTete {
    margin-top: 1%;
    margin-bottom: 2%;
    margin-left: 10%;
    margin-right: 10%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
}

.divEnTete input {
    border: 2px solid #d1d5db;
    font-size: large;
    width: 40%;
    background-color: #eee;
    border-radius: 8px;
    padding: 10px 20px 10px 20px;
    outline: none;
    color: #333;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    text-align: center;
    margin-left: 10px;
}

.divFormulaireAjout {
    background-color: #fff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    margin-left: 2%;
    margin-right: 2%;
    padding-right: 5%;
    padding-left: 5%;
}

.divInput {
    position: relative;
    margin: 50px;
}

#btnSuivant {
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

#btnSuivant:not(:disabled):hover {
    background-color: #5b7fe8;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(116, 148, 236, 0.5);
}

#btnSuivant:disabled {
    cursor: default;
    opacity: 0.6;
}

#btnSuivant:not(:disabled):active  {
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
    margin-top: 2%;
}

.divListeVoiture {
    font-family: "Inter Variable", sans-serif;
    --easy-table-border: none;
    --easy-table-row-border: 1px solid #e2e8f0;
    --easy-table-header-font-size: 16px;
    --easy-table-header-background-color: #f8fafc;
    --easy-table-header-font-color: #334155;
    --easy-table-body-row-font-size: 15px;
    --easy-table-footer-font-size: 14px;
    --easy-table-footer-padding: 20px 40px 20px 0px;
    --easy-table-body-item-padding: 10px 0 10px 0px;
    overflow-x: hidden;
    border-radius: 16px;
    --easy-table-columns-border: none;
    border: 2px solid #d1d5db;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    background-color: white;
    width: 80%;
    height: 300px;
    margin-left: 10%;
    margin-right: 10%;
}

.choix {
    height: 20px;
    width: 20px;
}

.quantite {
    border: 2px solid #d1d5db;
    font-size: 15px;
    font-family: "Inter Variable", sans-serif;
    width: 50%;
    background-color: #eee;
    border-radius: 8px;
    text-align: center;
    outline: none;
    color: #333;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    height: 25px;
}

</style>