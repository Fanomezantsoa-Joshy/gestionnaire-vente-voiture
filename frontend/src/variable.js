import { reactive } from "vue";

export const variable = reactive({

    message: "Location ajoutée avec succès !",
    iconMessage: "../../public/succes.png",

    modifierMessage(nouveau) {
        this.message = nouveau
    },

    ancienNumero: "",
    numero: "",
    loyer: "",
    nom: "",
    designation: "",
    nbrJours: "",
    taux: "",
    idClient: "",
    nomClient: "",
    contactClient: "",
    idVoiture: "",
    designationVoiture: "",
    prixVoiture: "",
    nombreVoiture: ""

});