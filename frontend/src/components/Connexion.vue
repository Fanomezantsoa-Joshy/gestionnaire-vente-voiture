<template>

<div class="divConteneur">

    <div class="divPrincipale">

    <div id="divFormulaire">

         <form @submit.prevent="envoyer">
        
        <h1 id="enTete">Connexion</h1>
        
        <div class="divInput">

            <input type="text" name="nomUtilistateur" v-model="formulaire.nomUtilisateur" @input="v$.formulaire.nomUtilisateur.$touch()" v-on:input="validerNom" @blur="v$.formulaire.nomUtilisateur.$touch()" 
        :class="{ 'invalide' : v$.formulaire.nomUtilisateur.$error, 'valide' : !v$.formulaire.nomUtilisateur.$error }"
         maxlength="15" placeholder="Votre nom d'utilisateur" @keydown.enter="suivant1" id="nomUtilisateur">
        <img src="../assets/icons/user-solid-full.svg" alt="iconUser" class="iconInput">

        </div>
                
        <div v-if="v$.formulaire.nomUtilisateur.$error">

            <p v-if="v$.formulaire.nomUtilisateur.required.$invalid" class="messageErreur">Le nom d'utilisateur est obligatoire</p>

        </div><br>
        
        <div class="divInput">

            <input type="password" name="mdp" v-model="formulaire.mdp" @input="v$.formulaire.mdp.$touch()" @blur="v$.formulaire.mdp.$touch()"
        :class="{ 'invalide': v$.formulaire.mdp.$error,  'valide': !v$.formulaire.mdp.$error }" maxlength="10" placeholder="Votre mot de passe"
        id="mdp" @keydown.enter="suivant2" @keydown="verification">
        <img src="../assets/icons/eye-slash-solid-full.svg" class="iconInput" id="iconMdp" v-on:click="voir">

        </div>

        <div v-if="v$.formulaire.mdp.$error">

            <p v-if="v$.formulaire.mdp.required.$invalid" class="messageErreur">Le mot de passe est obligatoire</p>
            <p v-if="v$.formulaire.mdp.minimum.$invalid" class="messageErreur">Le mot de passe doit contenir au moin 06 caractères</p>

        </div>
        <p v-if="mdpIncorrecte" class="messageErreur">Le mot de passe que vous avez saisie est incorrecte</p>
        <br>

        <RouterLink to="/mdpOublier" id="mdpOublier">Mot de passe oublié ?</RouterLink>
        <input type="submit" value="Se connecter" :disabled="v$.$invalid" id="btnSeConnecter" :id="btnSeConnecter"><br><br><br>

        <span id="texte">ou se connecter avec</span><br><br>

        <div class="divIcon">
            
            <img src="../assets/icons/google-brands-solid-full.svg" class="icon">
            <img src="../assets//icons/facebook-f-brands-solid-full.svg" class="icon">
            <img src="../assets/icons/github-brands-solid-full.svg" class="icon">
            <img src="../assets/icons/linkedin-in-brands-solid-full.svg" class="icon">

         </div>

    </form>


    </div>

    <div class="contenuGauche">

        <h3 class="texteBonjour">Bonjour, Bienvenue!</h3>
        <h5 class="texteVous">Vous n'avez pas un compte ?</h5>
        <input type="button" value="Créer un compte" v-on:click="$router.push('/creerCompte')" id="btnCreerCompte"><br><br>


    </div>

</div>


</div>   
</template>

<script>

import axios from 'axios';
import useVuelidate from '@vuelidate/core';
import { minLength, required } from '@vuelidate/validators';

export default {
    name : "PageConnexion",
    setup() {
        return {
            v$: useVuelidate()
        }
    },
    data() {
        return {
            mdpIncorrecte : false,
            motDePasse : '',
            formulaire : {
                nomUtilisateur : "",
                mdp : ""
            }
        }
    },

    validations () {
        return {
            formulaire : {
                nomUtilisateur : { required },
                mdp : { required, minimum : minLength(6) }
            }
        }
    },
    methods : {
        async envoyer() {
            document.getElementById("btnSeConnecter").disabled = true;
            try {
                const reponse = await axios.get("http://localhost/gestionnaire-vente-voiture/backend/connexion.php", {
                    params: {
                        nomUtilisateur : this.formulaire.nomUtilisateur
                    }
                });

                if (reponse.status == 201) {
                    console.log("Impossible d'executer la requête !'");
                    return;
                };

                this.motDePasse = reponse.data.mdp;

                if(this.formulaire.mdp != this.motDePasse) {
                    this.mdpIncorrecte = true;
                    document.getElementById("mdp").focus();
                    return;
                }
                else {
                    sessionStorage.setItem("admin", this.formulaire.nomUtilisateur);
                    this.$router.push("/pagePrincipale");
                }

                } catch (erreur) {
                    alert("Impossible de se connecter à la base de donnés !");
                }
        },
        effacer() {
            this.formulaire = {
                nomUtilisateur : "",
                mdp : ""
            }
        },
        suivant1() {
            document.getElementById("mdp").focus();
        },
        suivant2() {
            document.getElementById("mdp").blur();
        },
        verification() {
            this.mdpIncorrecte = false;
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
                document.getElementById("mdp").focus();
            },
                validerNom() {
                this.formulaire.nomUtilisateur = this.formulaire.nomUtilisateur.replace(/[ ]/g, '')
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


#enTete {
    text-align: center;
    margin-right: 20px;
    margin-top: 50px;
    margin-bottom: 40px;
    color: #3b82f6;
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
    margin: 15px;
}

.valide {
    border: 2px solid #d1d5db;
    font-size: large;
    width: 80%;
    padding: 13px 50px 13px 20px;
    background-color: #eee;
    border-radius: 10px;
    outline: none;
    color: #333;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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

#mdpOublier {
    font-size: large;
    color: #ffa500;
    text-decoration: none;
    margin-left: 30%;
}

#mdpOublier:hover {
    color: #d38b05;
    text-decoration: underline;
}

#btnSeConnecter {
    width: 85%;
    margin-top: 20px;
    margin-left: 30px;
    height: 50px;
    background-color: #7494ec;
    border-radius: 9999px;
    border: none;
    outline: none;
    cursor: pointer;
    font-size: 20px;
    color: #fff;
    box-shadow: 0 4px 14px 0 rgba(116, 148, 236, 0.4);
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

#btnSeConnecter:not(:disabled):hover {
    background-color: #5b7fe8;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(116, 148, 236, 0.5);
}

#btnSeConnecter:disabled {
    cursor: default;
    opacity: 0.6;
}

#btnSeConnecter:not(:disabled):active  {
    background-color: #436be3;
    transform: translateY(1px) scale(0.97);
    box-shadow: 0 2px 10px rgba(116, 148, 236, 0.4);
    opacity: 0.6;
}

form {
    width: 100%;
}

#divFormulaire {
    position: absolute;
    right: 0;
    width: 50%;
    background-color: #fff;
    display: flex;
    align-items: center;
    z-index: 1;
}

.divIcon {
    display: flex;
    justify-content: center;
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

#texte {
    font-size: large;
    margin-left: 32%;
    color : #333;
}

.contenuGauche {
    position: absolute;
    justify-content: center;
    align-items: center;
    height: 100%;
    left: -20%;
    width: 70%;
    border-radius: 150px;
    display: flex;
    flex-direction: column;
    background-color: #7494ec;
}

#btnCreerCompte {
    width: 200px;
    margin-left: 30%;
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
}

#btnCreerCompte:hover {
    background-color: #5b7fe8;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(116, 148, 236, 0.5);
}

#btnCreerCompte:active  {
    background-color: #436be3;
    transform: translateY(1px) scale(0.97);
    box-shadow: 0 2px 10px rgba(116, 148, 236, 0.4);
    opacity: 0.6;
}

.texteBonjour {
    color: #fff;
    font-size: xx-large;
    margin-left: 30%;
}

.texteVous {
    color: #fff;
    font-size: 16px;
    margin-left: 30%;
    font-weight: 400;
}

.invalide {
    border: 2px solid #dc3545;
    font-size: large;
    width: 80%;
    padding: 13px 50px 13px 20px;
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
    margin-left: 30px;
    margin-top: -10px;
}


</style>