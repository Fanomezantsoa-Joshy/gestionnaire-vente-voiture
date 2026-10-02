<template>

    <div class="divConteneur">

            <div class="divPrincipale">

    <div class="contenuDroite">

        <h3 class="texteRecuperer">Récupération du compte</h3>
        <h5 class="texteVous">Vous avez déjà un compte ?</h5>
        <input type="button" value="Se connecter" v-on:click="$router.push('/')" id="btnSeConnecter"><br><br>


    </div>

    <div id="divFormulaire">

        <form @submit.prevent="envoyer">

            

        <div class="divInput">

        <input type="text" name="nom" v-model="formulaire.nom" maxlength="25" @input="v$.formulaire.nom.$touch()" 
        @blur="v$.formulaire.nom.$touch()" placeholder="Votre nom" v-on:keyup="changer"
        :class="{ 'invalide': v$.formulaire.nom.$error, 'valide' : !v$.formulaire.nom.$error }" id="nom" @keydown.enter="suivant1"><br>
        </div>

        <div v-if="v$.formulaire.nom.$error">

            <p v-if="v$.formulaire.nom.required.$invalid" class="messageErreur">Le nom est obligatoire</p>

        </div>

        <div class="divInput">

        <input type="text" name="prenoms" v-model="formulaire.prenoms" maxlength="25" 
        @input="v$.formulaire.prenoms.$touch()" @blur="v$.formulaire.prenoms.$touch()" placeholder="Votre prénoms"
        :class="{ 'invalide' : v$.formulaire.prenoms.$error, 'valide' : !v$.formulaire.prenoms.$error }" id="prenoms" 
        @keydown.enter="suivant2"><br>

        </div>

        <div v-if="v$.formulaire.prenoms.$error">

            <p v-if="v$.formulaire.prenoms.required.$invalid" class="messageErreur">Le prénoms est obligatoire</p>

        </div>

        

        <div class="divInput">
        
        <input type="text" name="nomUtilisateur" v-model="formulaire.nomUtilisateur" maxlength="15" 
        @input="v$.formulaire.nomUtilisateur.$touch()" @blur="v$.formulaire.nomUtilisateur.$touch()" placeholder="Nouveau nom d'utilisateur"
        :class="{ 'invalide': v$.formulaire.nomUtilisateur.$error, 'valide' : !v$.formulaire.nomUtilisateur.$error }" 
        id="nomUtilisateur" @keydown.enter="suivant3">
        <img src="../assets/icons/user-solid-full.svg" class="iconInput">

        </div>

        <div v-if="v$.formulaire.nomUtilisateur.$error">

            <p v-if="v$.formulaire.nomUtilisateur.required.$invalid" class="messageErreur">Le nom d'utilisateur est obligatoire</p>
            <p v-if="v$.formulaire.nomUtilisateur.minimum.$invalid" class="messageErreur">Le nom doit contenir au moin 04 caractères</p>

        </div>
        
        <div class="divInput">

            <span for="naissance" class="naissance">&nbsp;&nbsp; Date de naissance : </span>
            <input type="date" name="naissance" class="valide" id="naissance" @keydown.enter="suivant4" v-model="formulaire.naissance"><br>

        </div>

        

        <div class="divInput">
        
        <input type="text" name="email" v-model="formulaire.email" maxlength="30" @input="v$.formulaire.email.$touch()" 
        @blur="v$.formulaire.email.$touch()" placeholder="Votre adresse email"
        :class="{ 'invalide': v$.formulaire.email.$error, 'valide' : !v$.formulaire.email.$error }" id="email" @keydown.enter="suivant5">
        <img src="../assets/icons/envelope-solid-full.svg" class="iconInput">

        </div>

        <div v-if="v$.formulaire.email.$error">

            <p v-if="v$.formulaire.email.required.$invalid" class="messageErreur">L'adresse email est obligatoire</p>
            <p v-if="v$.formulaire.email.email.$invalid" class="messageErreur">Adresse email invalide (format : ...@gmail.com)</p>

        </div>

        

        <div class="divInput">
        
        <input type="password" name="mdp" v-model="formulaire.mdp" maxlength="10" @input="v$.formulaire.mdp.$touch()" 
        @blur="v$.formulaire.mdp.$touch()" placeholder="Nouveau mot de passe"
        :class="{ 'invalide': v$.formulaire.mdp.$error, 'valide' : !v$.formulaire.mdp.$error }" id="mdp" @keydown.enter="suivant6">
        <img src="../../public/eye-slash-solid-full.svg" class="iconInput" id="iconMdp" v-on:click="voir">

        </div>

        <div v-if="v$.formulaire.mdp.$error">

            <p v-if="v$.formulaire.mdp.required.$invalid" class="messageErreur">Le mot de passe est obligatoire</p>
            <p v-if="v$.formulaire.mdp.minimum.$invalid" class="messageErreur">Le mot de passe doit contenir au moin 06 caractères</p>

        </div>


        <input type="button" value="Annuler" v-on:click="$router.push('/')"id="btnAnnuler">
        <input type="submit" value="Enregistrer" :disabled="v$.$invalid" id="btnEnregistrer">

    </form>

    </div>

    </div>

    </div>

</template>

<script>

import axios from 'axios';
import useVuelidate from '@vuelidate/core';
import { required, minLength, email } from '@vuelidate/validators';

    export default {
        name : "CreerCompte",
        setup() {
            return {
                v$ : useVuelidate()
            }
        },
        data() {
            return {
                formulaire : {
                    nom : "",
                    prenoms : "",
                    nomUtilisateur : "",
                    naissance : "",
                    email : "",
                    mdp : ""
                }
            }
        },
        validations() {
            return {
                formulaire : {
                    nom : {required},
                    prenoms : {required},
                    nomUtilisateur : {required, minimum : minLength(4)},
                    email : {required, email},
                    mdp : {required, minimum : minLength(6)}
                }   
            }
        },
        mounted() {
            document.getElementById("nom").focus();
            const now = new Date();
            const annee = now.getFullYear() - 18;
            const mois = now.getMonth();
            const jour = now.getDay();
            document.getElementById("naissance").max = annee+"-"+String(mois).padStart(2, '0')+"-"+String(jour).padStart(2, '0');
            },
        methods : {
            async envoyer () {
                            try {
                const reponse = await axios.post("http://localhost/gestionnaire-vente-voiture/backend/mdpOublier.php", this.formulaire);
                console.log("Envoie des donnés réussie !", reponse.data);

                if (reponse.status == 201) {
                    console.log("Impossible de verifier les informations !'");
                    return;
                };
                
                if (reponse.status == 202) {
                    alert("Les informations que vous avez saisi sont incorrectes !");
                    return;
                };

                if (reponse.status == 203) {
                    alert("Impossible de changer le mot de passe !");
                    return;
                };

                if(reponse.status == 200 ) {

                    alert("Mot de passe changer avec succés !");
                    this.effacer();
                    this.$router.push("/");

                }; 

                } catch (erreur) {
                    console.error("Impossible d'envoyer les donnés !", erreur.message);
                }
            },
            effacer () {
                this.formulaire = {
                    nom : "",
                    prenoms : "",
                    nomUtilisateur : "",
                    naissance : "",
                    email : "",
                    mdp : ""
                 }
            },
            suivant1 () {
                document.getElementById("prenoms").focus();
            },
            suivant2 () {
                document.getElementById("nomUtilisateur").focus();
            },
            suivant3 () {
                document.getElementById("naissance").focus();
            },
            suivant4 () {
                document.getElementById("email").focus();
            },
            suivant5 () {
                document.getElementById("mdp").focus();
            },
            suivant6 () {
                document.getElementById("mdp").blur();
            },
            voir() {
                var type = document.getElementById("mdp").type;
                var teste = document.getElementById("iconMdp");

                if (type == "password") {
                    document.getElementById("mdp").type = "text";
                    teste.src = "../../public/eye-solid-full.svg";
                }
                else {
                    document.getElementById("mdp").type = "password";
                    teste.src = "../../public/eye-slash-solid-full.svg";
                }
            },
            changer () {
                this.formulaire.nom = this.formulaire.nom.toUpperCase();
            }
        }
    }

</script>

<style scoped>

.divConteneur {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: linear-gradient(90deg, #e2e2e2);
    font-family: "Inter Variable", sans-serif;
}

.divPrincipale {
    position: relative;
    width: 850px;
    height: 550px;
    background-color: #fff;
    margin: 20px;
    border-radius: 30px;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

.divInput {
    position: relative;
    margin: 25px;
}

.naissance {
    font-size: large;
    color: #333;
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

.iconInput {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
    height: 24px;
    width: 24px;
    border-radius: 50px;
}

#btnEnregistrer {
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
    box-shadow: 0 4px 14px 0 rgba(116, 148, 236, 0.4);
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

#btnEnregistrer:not(:disabled):hover {
    background-color: #5b7fe8;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(116, 148, 236, 0.5);
}

#btnEnregistrer:disabled {
    cursor: default;
    opacity: 0.6;
}

#btnEnregistrer:active  {
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
    margin-left: 30%;
    border: none;
    background-color: transparent;
}

#btnAnnuler:hover {
    color: #d38b05;
    text-decoration: underline;
}

form {
    width: 100%;
}

#divFormulaire {
    position: absolute;
    width: 50%;
    background-color: #fff;
    display: flex;
    align-items: center;
    z-index: 1;
}

.icon {
    border-radius: 20%;
    height: 25px;
    width: 25px;
    display: inline-flex;
    padding: 10px;
    border: 2px solid #ccc;
    color: #333;
    margin: 0 10px;
}

.contenuDroite {
    position: absolute;
    display: flex;
    flex-direction: column;
    height: 100%;
    right: -20%;
    width: 70%;
    border-radius: 150px;
    background-color: #7494ec;
    justify-content: center;
}

#btnSeConnecter {
    width: 200px;
    margin-left: 20%;
    height: 50px;
    background-color: #7494ec;
    border-radius: 10px;
    border: 2px solid white;
    outline: none;
    cursor: pointer;
    font-size: 18px;
    color: #fff;
    box-shadow: 0 4px 14px 0 rgba(116, 148, 236, 0.4);
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    font-family: "Inter Variable", sans-serif;
}

#btnSeConnecter:hover {
    background-color: #5b7fe8;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(116, 148, 236, 0.5);
}

#btnSeConnecter:active  {
    background-color: #436be3;
    transform: translateY(1px) scale(0.97);
    box-shadow: 0 2px 10px rgba(116, 148, 236, 0.4);
    opacity: 0.6;
}

.texteRecuperer {
    color: #fff;
    font-size: xx-large;
    margin-left: 5%;
}

.texteVous {
    color: #fff;
    font-size: 16px;
    margin-left: 20%;
    font-weight: 400;
}

.valide {
    border: 2px solid #d1d5db;
    font-size: large;
    width: 80%;
    padding: 10px 50px 10px 20px;
    background-color: #eee;
    border-radius: 10px;
    outline: none;
    color: #333;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.invalide {
    border: 2px solid #dc3545;
    font-size: large;
    width: 80%;
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
    margin-left: 12%;
    margin-top: -5%;
}

#naissance {
    margin-top: 10px;
}


</style>