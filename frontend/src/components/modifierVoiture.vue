<template>

    <div class="contenuFormulaireAjout">

    <form class="teste">

      <div class="divEnTete">

        <p id="titre">Modification d'une voiture</p>

        <div>

            Identifiant du voiture : <input type="text" id="identifiant" readonly v-model="formulaire.identifiant">

        </div>

      </div>

      <div class="divFormulaireAjout">

        <div class="divInput">

            <label>Designation du voiture :</label><br>
            <input type="text" name="designation" v-model="formulaire.designation" v-on:blur="v$.formulaire.designation.$touch()" 
            @keydown.enter="suivant1" v-on:input="v$.formulaire.designation.$touch()" maxlength="20"
            :class="{ 'invalide': v$.formulaire.designation.$error,'valide': !v$.formulaire.designation.$error }" id="designation">
            </input><br>

        </div>

        <div v-if="v$.formulaire.designation.$error">

          <p v-if="v$.formulaire.designation.required.$invalid" class="messageErreur">La designation du voiture est obligatoire</p>

        </div>

        <div class="divInput">

            <label>Prix (en Ar) :</label><br>
            <input type="number" min="1" v-model="formulaire.prix" @keydown.enter="suivant2" id="prix"
            v-on:input="formulaire.prix = Math.min(formulaire.prix, 999999999), v$.formulaire.prix.$touch()"
            :class="{ 'invalide': v$.formulaire.prix.$error,'valide': !v$.formulaire.prix.$error }"><br>

        </div>

        <div v-if="v$.formulaire.prix.$error">
          <p v-if="v$.formulaire.prix.pasZero.$invalid" class="messageErreur">Le prix du voiture doit être supérieur à 0</p>
        </div>

        <div class="divInput">

            <label>Nombre (max = 60) :</label><br>
            <input type="number" min="1" v-model="formulaire.nombre" id="nombre"
            v-on:input="formulaire.nombre = Math.min(formulaire.nombre, 60), v$.formulaire.nombre.$touch()" @keydown.enter="suivant3"
            :class="{ 'invalide': v$.formulaire.nombre.$error,'valide': !v$.formulaire.nombre.$error }"><br>

        </div>

        <div v-if="v$.formulaire.nombre.$error">
          <p v-if="v$.formulaire.nombre.pasZero.$invalid" class="messageErreur">Le nombre de voiture doit être supérieur à 0</p>
        </div>

        <div class="divBoutton">

            <input type="reset" value="Annuler" id="btnAnnuler" v-on:click="$router.push('listeVoiture')">
            <input type="button" value="Enregistrer" :disabled="v$.$invalid" id="btnAjouter" v-on:click="modifier">

        </div>

      </div>


    </form>

  </div>


</template>

<script>

    import axios from 'axios';
    import useVuelidate from '@vuelidate/core';
    import { required, maxLength, sameAs } from '@vuelidate/validators';
    import { variable } from '@/variable';

    export default {
        name: "formAjout",
        setup() {
            return {
                v$: useVuelidate()
            }
        },
        mounted() {
            document.getElementById("designation").focus();
        },
        data() {
            return {
                message : variable,
                formulaire: {
                    identifiant: variable.idVoiture,
                    prix: variable.prixVoiture,
                    designation: variable.designationVoiture,
                    nombre : variable.nombreVoiture
                }
            }
        },
        methods: {

            async modifier() {
                
                document.getElementById("btnAjouter").disabled = true;

                try {

                    const reponse = await axios.post("http://localhost/gestionnaire-vente-voiture/backend/modifierVoiture.php", this.formulaire);

                } catch (erreur) {

                    this.message.modifierMessage("Impossible d'effectuer la modification !");
                }

                this.message.modifierMessage("Informations modifiée avec succès !");

                this.$router.push({
                    path : "listeVoiture",
                    state : { vientDeModifier : true }
                });

            },
            suivant1() {
                document.getElementById("prix").focus();
            },
            suivant2() {
                document.getElementById("nombre").focus();
            },
            suivant3() {
                document.getElementById("nombre").blur();
            }                                    
        },

        validations() {
            return {
                formulaire: {
                    designation: { required },
                    nombre: { pasZero: (value) => value != 0 },
                    prix: { pasZero: (value) => value != 0 }
                }
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

.contenuFormulaireAjout {
    font-family: "Inter Variable", sans-serif;
    height: 100%;
    align-content: center;
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
    margin-left: 5%;
    margin-right: 5%;
    padding-left: 10%;
}

.divInput {
    position: relative;
    margin: 50px;
}

.divInput input {
    margin-top: 5px;
}

.divInput input::placeholder {
    color: #888;
    font-weight: 400;
}

.divInput input:hover {
    transform: translateY(-2px);
}

.divInput input:focus.valide {
    border-color: #3b82f6;
}

#btnAjouter {
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

#btnAjouter:not(:disabled):hover {
    background-color: #5b7fe8;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(116, 148, 236, 0.5);
}

#btnAjouter:disabled {
    cursor: default;
    opacity: 0.6;
}

#btnAjouter:not(:disabled):active  {
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

.valide {
    border: 2px solid #d1d5db;
    font-size: large;
    width: 60%;
    padding: 10px 50px 10px 20px;
    background-color: #eee;
    border-radius: 10px;
    outline: none;
    color: #333;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.invalide {
    border: 2px solid #dc3545;
    width: 60%;
    font-size: large;
    padding: 10px 50px 10px 20px;
    background-color: #eee;
    border-radius: 10px;
    outline: none;
    color: #333;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.messageErreur {
    position: absolute;
    color: #dc3545;
    font-size: 15px;
    margin-left: 5%;
    margin-top: -3%;
}

.divBoutton {
    margin-left: 60%;
    padding-bottom: 2%;
}


</style>