<template>

    <div class="divConteneur">

        <div class="divPrincipale">

            <div class="divContenuMenu">

                <div class="enTeteMenu">

                    <img src="../assets/icons/voiture.png" style="height: 100%; width: 52%;">

                </div>

                <p class="titreMenu">Menu</p>

                <div class="divMenu">

                    <div class="divBouttonMenu">

                        <RouterLink to="" class="menu" :class="{'menuClient' : menuClient}"
                        v-on:click="afficherClient = !afficherClient, afficherVoiture = false, afficherAchat = false, 
                        menuClient = true, menuVoiture = false, menuAchat = false, menuRecette = false">Clients
                        </RouterLink>
                        <img src="../assets/icons/client.png" class="iconMenu">

                    </div>

                    <div class="divMenuClient" v-if="afficherClient">

                        <div class="divBouttonMenu">

                            <RouterLink to="nouveauClient" class="sousMenu" v-on:click="fermer">Nouveau</RouterLink>
                            <img src=" ../assets/icons/nouveau.png" class="iconMenu">

                        </div>

                        <div class="divBouttonMenu">

                            <RouterLink to="listeClient" class="sousMenu" v-on:click="fermer">Liste</RouterLink>
                            <img src="../assets/icons/liste.png" class="iconMenu">

                        </div>

                    </div>

                    <div class="divBouttonMenu">

                        <RouterLink to="" class="menu" :class="{'menuVoiture' : menuVoiture}"
                        v-on:click="afficherVoiture = !afficherVoiture, afficherClient = false, afficherAchat = false,
                        menuClient = false, menuVoiture = true, menuAchat = false, menuRecette = false">
                            Voitures</RouterLink>
                        <img src="../assets/icons/menuVoiture.png" class="iconMenu">

                    </div>

                    <div class="divMenuVoiture" v-if="afficherVoiture">

                        <div class="divBouttonMenu">

                            <RouterLink to="nouveauVoiture" class="sousMenu" v-on:click="fermer">Ajout</RouterLink>
                            <img src="../assets/icons/nouveau.png" class="iconMenu">

                        </div>

                        <div class="divBouttonMenu">


                            <RouterLink to="listeVoiture" class="sousMenu" v-on:click="fermer">Liste</RouterLink>
                            <img src="../assets/icons/liste.png" class="iconMenu">

                        </div>

                    </div>

                    <div class="divBouttonMenu">

                        <RouterLink to="" class="menu" :class="{'menuAchat' : menuAchat}"
                        v-on:click="afficherAchat = !afficherAchat, afficherVoiture = false, afficherClient = false,
                        menuClient = false, menuVoiture = false, menuAchat = true, menuRecette = false">Achats
                        </RouterLink>
                        <img src="../assets/icons/achat.png" class="iconMenu">

                    </div>

                    <div class="divMenuAchat" v-if="afficherAchat">

                        <div class="divBouttonMenu">

                            <RouterLink to="nouveauAchat1" class="sousMenu" v-on:click="fermer">Nouvel</RouterLink>
                            <img src="../assets/icons/nouveau.png" class="iconMenu">

                        </div>

                        <div class="divBouttonMenu">


                            <RouterLink to="listeAchat" class="sousMenu" v-on:click="fermer">Liste</RouterLink>
                            <img src="../assets/icons/liste.png" class="iconMenu">

                        </div>

                    </div>

                    <div class="divBouttonMenu">
                        
                        <RouterLink to="" type="button" class="menu" :class="{'menuRecette' : menuRecette}"
                        @click="recuperer" id="btnRecette">Recette</RouterLink>
                        
                        <img src="../assets/icons/recette.png" class="iconMenu">

                    </div>

                </div>

                <div class="divSeDeconnecter">

                    <RouterLink to="" id="seDeconnecter" v-on:click="seDeconnecter">Se déconnecter</RouterLink>
                    <img src="../assets/icons/SeDeconnecter.svg" class="iconMenu">

                </div>

            </div>


            <div class="divTeteContenu">

                <div class="divEnTete">

                    <div class="divEnTeteGauche">

                        <h3>AutoGestion</h3>

                    </div>

                    <div class="divEnTeteDroite">

                        <div class="divBtnEnTete">

                            <img src="../assets/icons/utilisateur.png" class="iconMonCompte">
                            <input type="button" value="Mon compte" class="btnMonCompte">

                        </div>

                        <div class="divBtnEnTete">

                            <img src="../assets/icons/historique.png" class="iconHistorique">
                            <input type="button" value="Historiques" class="btnHistorique">

                        </div>

                    </div>

                </div>

                <div class="divContenu">

                    <RouterView></RouterView>

                </div>

            </div>

        </div>

    </div>

</template>

<script>

import Swal from 'sweetalert2';
import axios from 'axios';

export default {
    name : "PagePrincipale",
    data() {
        return {
            admin : "",
            afficherClient : false,
            afficherVoiture : false,
            afficherAchat : false,
            menuAchat : false,
            menuVoiture : false,
            menuClient : false,
            menuRecette : false
        }
    },
    mounted() {
        this.admin = sessionStorage.getItem("admin");

        const lien = this.$route.path;
        if((lien == "/pagePrincipale/nouveauAchat1") || (lien == "/pagePrincipale/nouveauAchat2") || 
        (lien == "/pagePrincipale/facture") || (lien == "/pagePrincipale/modifierAchat1") || 
        (lien == "/pagePrincipale/modifierAchat2") || (lien == "/pagePrincipale/modifierAchat3") ||
        (lien == "/pagePrincipale/listeAchat")) {
            this.menuAchat = true;
            this.menuVoiture = false;
            this.menuClient = false;
            this.menuRecette = false
        }

        if((lien == "/pagePrincipale/nouveauVoiture") || (lien == "/pagePrincipale/modifierVoiture") || 
        (lien == "/pagePrincipale/listeVoiture")) {
            this.menuAchat = false;
            this.menuVoiture = true;
            this.menuClient = false;
            this.menuRecette = false
        }

        if((lien == "/pagePrincipale/nouveauClient") || (lien == "/pagePrincipale/modifierClient") || 
        (lien == "/pagePrincipale/listeClient")) {
            this.menuAchat = false;
            this.menuVoiture = false;
            this.menuClient = true;
            this.menuRecette = false
        }

        if(lien == "/pagePrincipale/recette") {
            this.menuAchat = false;
            this.menuVoiture = false;
            this.menuClient = false;
            this.menuRecette = true;
        }
    },
    beforeRouteUpdate(to) {
        this.afficherClient = false;
        this.afficherAchat = false;
        this.afficherVoiture = false;

        const lien = to.path;

        if((lien != "/pagePrincipale/nouveauAchat1") && 
        (lien != "/pagePrincipale/nouveauAchat2") && (lien != "/pagePrincipale/facture")) {
            sessionStorage.setItem("valeurFacture", []);
        }

        if((lien == "/pagePrincipale/nouveauAchat1") || (lien == "/pagePrincipale/nouveauAchat2") || 
        (lien == "/pagePrincipale/facture") || (lien == "/pagePrincipale/modifierAchat1") || 
        (lien == "/pagePrincipale/modifierAchat2") || (lien == "/pagePrincipale/modifierAchat3") || 
        (lien == "/pagePrincipale/listeAchat")) {
            this.menuAchat = true;
            this.menuVoiture = false;
            this.menuClient = false;
            this.menuRecette = false
        }

        if((lien == "/pagePrincipale/nouveauVoiture") || (lien == "/pagePrincipale/modifierVoiture") || 
        (lien == "/pagePrincipale/listeVoiture")) {
            this.menuAchat = false;
            this.menuVoiture = true;
            this.menuClient = false;
            this.menuRecette = false
        }

        if((lien == "/pagePrincipale/nouveauClient") || (lien == "/pagePrincipale/modifierClient") || 
        (lien == "/pagePrincipale/listeClient")) {
            this.menuAchat = false;
            this.menuVoiture = false;
            this.menuClient = true;
            this.menuRecette = false
        }

        if(lien == "/pagePrincipale/recette") {
            this.menuAchat = false;
            this.menuVoiture = false;
            this.menuClient = false;
            this.menuRecette = true;
        }

    },
    methods : {
        fermer() {
            this.afficherClient = false;
            this.afficherVoiture = false;
            this.afficherAchat = false;
        },
        async seDeconnecter() {
            const resultat = await Swal.fire({
                title : "Déconnexion ?",
                text : "Souhaitez-vous vraiment vous déconnecter ?",
                icon : "warning",
                showCancelButton : true,
                confirmButtonColor : "#d33",
                cancelButtonColor : "#3085d6",
                confirmButtonText : 'Oui',
                cancelButtonText : 'Non',
                reverseButtons : true,
                allowOutsideClick : false,
                allowEscapeKey : false,
                allowEnterKey : false,
            });

            if(resultat.isConfirmed) {
                this.$router.push("/");
            }
        },
                async recuperer() {
                this.menuClient = false;
                this.menuVoiture = false;
                this.menuAchat = false;
                this.menuRecette = true;

                try {
        
                    const reponse = await axios.get("http://localhost/gestionnaire-vente-voiture/backend/recette.php");

                    sessionStorage.setItem("recette1", reponse.data[0].recette);
                    sessionStorage.setItem("recette2", reponse.data[1].recette);
                    sessionStorage.setItem("recette3", reponse.data[2].recette);
                    sessionStorage.setItem("recette4", reponse.data[3].recette);
                    sessionStorage.setItem("recette5", reponse.data[4].recette);
                    sessionStorage.setItem("recette6", reponse.data[5].recette);

                    this.$router.push("recette");
                    
                } catch (erreur) {
                    alert("Connexion impossible!" + erreur.message);
                    return;
                }
            }
    }

}

</script>

<style>

html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

</style>

<style scoped>

.divConteneur {
    font-family: 'Inter Variable', sans-serif;
    background-color: #f1f5f9;
    color: #0f172a;
    width: 100%;
    height: 100dvh;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
}

.divPrincipale {
    display: flex;
    flex: 1;
}

.divTeteContenu {
    width: 280px;
    background-color: #ffffff;
    border-right: 1px solid #e2e8f0;
    display: flex;
    flex: 1;
}

.divEnTete {
    height: 70px;
    border-bottom: 1px solid #e2e8f0;
}

.divContenuMenu {
    width: 200px;
    background-color: #ffffff;
    border-right: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
}

.divMenu {
    display: flex;
    flex-direction: column;
    flex: 1;
}

.titreMenu, .titreProfile {
    font-size: large;
    font-weight: 500;
    color: #64748b;
    margin-left: 30px;
}

.menu {
    text-decoration: none;
    color: #64748b;
    font-weight: 500;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    padding: 25px 0 25px 65px;
    margin: 0 10px 0 5px;
    position: absolute;
    width: 9%;
}

.menu:hover {
    background-color: #f1f5f9;
    color: #0f172a;
}

.menuAchat, .menuClient, .menuVoiture, .menuRecette, .menuAchat:hover, .menuClient:hover, .menuRecette:hover, .menuVoiture:hover {
    background-color: #e0e7ff;
    color: #4f46e5;
}

.enTeteMenu {
    text-align: center;
    height: 72px;
    border-bottom: 1px solid #e2e8f0;
    width: 100%;
}

.divBouttonMenu {
    height: 80px;
}

.iconMenu {
    height: 30px;
    width: 30px;
    position: relative;
    margin-left: 15%;
    margin-top: 10%;
}

.divTeteContenu {
    display: flex;
    flex-direction: column;
    min-width: 0; 
}

.divEnTete {
    height: 72px;
    background-color: rgba(255, 255, 255, 0.8);
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 2rem;
    position: sticky;
    top: 0;
}

.divEnTeteGauche, .divEnTeteDroite {
    display: flex;
    align-items: center;
    color: #64748b;
    font-size: 22px;
    font-family: "Inter Variable", sans-serif
}

.divContenu {
    display: flex;
    flex-direction: column;
    flex: 1;
    background-color: #f1f5f9;
}

.piedMenu {
    margin-top: 30%;
    height: 30%;
    border-top: 1px solid #e2e8f0;
}

.titreProfile {
    margin-bottom: 15%;
}

.profile {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.photoAdmin {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    margin-left: 10px;
}

.nomAdmin { 
    font-weight: 600; 
    text-align: center;
}

.infoAdmin { 
    display: flex; 
    flex-direction: column; 
    text-align: center;
    margin-left: 5px;
}

.roleAdmin { 
    color: #64748b; 
}

#seDeconnecter {
    text-decoration: none;
    color: #64748b;
    font-weight: 500;
    border-radius: 8px;
    padding: 20px 0 20px 55px;
    margin: 5px 10px 10px 5px;
    position: absolute;
    width: 10%;
}

#seDeconnecter:hover {
    background-color: #f1f5f9;
    color: #4f46e5;
}

.divSeDeconnecter {
    margin-bottom: 8%;
}


.btnMonCompte {
    width: 150px;
    margin-left: 10px;
    height: 50px;
    background-color: #7494ec;
    border-radius: 8px;
    border: none;
    outline: none;
    cursor: pointer;
    font-size: 16px;
    color: #fff;
    box-shadow: 0 4px 14px 0 rgba(116, 148, 236, 0.3);
    font-family: "Inter Variable", sans-serif;
    padding-left: 40px;
}

.btnHistorique {
    width: 150px;
    margin-left: 10px;
    height: 50px;
    background-color: #7494ec;
    border-radius: 8px;
    border: none;
    outline: none;
    cursor: pointer;
    font-size: 16px;
    color: #fff;
    box-shadow: 0 4px 14px 0 rgba(116, 148, 236, 0.3);
    font-family: "Inter Variable", sans-serif;
    padding-left: 30px;
}

.btnHistorique:hover, .btnMonCompte:hover  {
    background-color: #5b7fe8;
    box-shadow: 0 6px 20px rgba(116, 148, 236, 0.5);
}

.iconMonCompte {
    height: 30px;
    width: 30px;
    position: absolute;
    margin-top: 10px;
    margin-left: 20px;
}

.iconHistorique {
    height: 27px;
    width: 27px;
    position: absolute;
    margin-top: 11px;
    margin-left: 20px;
}

.divBtnEnTete {
    display: flex;
    flex-direction: column;
}

.sousMenu {
    text-decoration: none;
    color: #64748b;
    font-weight: 500;
    padding: 25px 0 25px 65px;
    position: absolute;
    width: 9%;
}

.sousMenu:hover {
    background-color: #c4dbff;
    color: #0f172a;
}

.divMenuClient .iconMenu, .divMenuAchat .iconMenu, .divMenuVoiture .iconMenu {
    height: 27px;
    width: 27px;
    margin: 0 10px 0 5px;
    margin-top: 11%;
    margin-left: 15%;
}

.divMenuClient, .divMenuAchat, .divMenuVoiture {
    background-color: #f1f5f9;
    margin-bottom: 5%;
    margin: 0 7px 5px 5px;
    margin-top: -5%;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
}

</style>