<template>

    <div class="contenuFormulaireAjout">

    <form class="teste">

      <div class="divEnTete">

        <p id="titre">Modification d'un client</p>

        <div>

            Identifiant du client : <input type="text" id="identifiant" readonly v-model="formulaire.identifiant">

        </div>

      </div>

      <div class="divFormulaireAjout">

        <div class="divInput" id="divNom">

            <label>Nom du client :</label><br>
            <input type="text" v-model="formulaire.nom" v-on:input="validerNom" @input="v$.formulaire.nom.$touch()"
            v-on:blur="v$.formulaire.nom.$touch()" @keydown.enter="suivant1" id="nom" maxlength="20"
            :class="{ 'invalide': v$.formulaire.nom.$error,'valide': !v$.formulaire.nom.$error }"><br>

        </div>

        <div v-if="v$.formulaire.nom.$error">

          <p v-if="v$.formulaire.nom.required.$invalid" class="messageErreur">Veuillez saisir le nom du client</p>

        </div><br>

        <div class="divInput">

            <label>Contact :</label><br>
            <input type="text" name="contact" v-model="formulaire.contact" v-on:blur="v$.formulaire.contact.$touch()" 
            @keydown.enter="suivant2" v-on:input="v$.formulaire.contact.$touch()" maxlength="15"
            :class="{ 'invalide': v$.formulaire.contact.$error,'valide': !v$.formulaire.contact.$error }" id="contact">
            </input><br>

        </div>

        <div v-if="v$.formulaire.contact.$error">

          <p v-if="v$.formulaire.contact.required.$invalid" class="messageErreur">Veuillez saisir le contact du client</p>

        </div>
        
        <div class="divBoutton">

            <input type="reset" value="Annuler" id="btnAnnuler" v-on:click="$router.push('listeClient')">
            <input type="button" value="Enregistrer" :disabled="v$.$invalid" id="btnModifier" v-on:click="modifier">

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
    import Swal from 'sweetalert2';

    export default {
        name: "formAjout",
        setup() {
            return {
                v$: useVuelidate()
            }
        },
        mounted() {
            document.getElementById("nom").focus();
        },
        data() {
            return {
                message : variable,
                formulaire: {
                    identifiant: variable.idClient,
                    nom : variable.nomClient,
                    contact : variable.contactClient
                }
            }
        },
        methods: {

            async modifier() {
                
                document.getElementById("btnModifier").disabled = true;

                try {

                    const reponse = await axios.post("http://localhost/gestionnaire-vente-voiture/backend/modifierClient.php", this.formulaire);

                    if(reponse.status == 201) {

                        this.erreurModification();
                        return;

                    } else {

                                        this.message.modifierMessage("Informations modifiée avec succès !");

                this.$router.push({
                    path : "listeClient",
                    state : { vientDeModifier : true }
                });
                    }

                } catch (erreur) {

                    this.message.modifierMessage("Impossible d'effectuer la modification !");
                }

            },
            validerNom() {
                this.formulaire.nom = this.formulaire.nom.replace(/[^a-zA-ZÀ-ÿ\s]/g, '')
            },
            suivant1() {
                document.getElementById("contact").focus();
            },
            suivant2() {
                document.getElementById("contact").blur();
            },
            erreurModification() {
                Swal.fire({
                title : "Erreur de modification !",
                text : "Le contact que vous avez saisi est déjà utilisé.",
                icon : "error",
                confirmButtonColor : "#7494ec",
                confirmButtonText : 'Ok',
            });
        }                                  
        },

        validations() {
            return {
                formulaire: {
                    nom: { required },
                    contact: { required },
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
    padding-top: 5%;
}

.divInput {
    position: relative;
    margin: 30px;
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

#btnModifier {
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

#btnModifier:not(:disabled):hover {
    background-color: #5b7fe8;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(116, 148, 236, 0.5);
}

#btnModifier:disabled {
    cursor: default;
    opacity: 0.6;
}

#btnModifier:not(:disabled):active  {
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
    margin-left: 4%;
    margin-top: -1%;
}

.divBoutton {
    margin-left: 60%;
    margin-top: 10%;
    padding-bottom: 2%;
}


</style>