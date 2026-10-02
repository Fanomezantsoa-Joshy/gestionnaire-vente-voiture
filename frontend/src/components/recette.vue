<template>

    <div class="divContenuRecette">

        <div class="divConteneur">

            <div class="divEnTete">
                <h1>Recette total</h1>
            </div>

            <div class="divContenu">
                
                <div class="divBilan">
                    <div class="divIcon" style="background: #e0e7ff;">
                    </div>
                    <div class="divDetailBilan">
                        <h3 id="loyer total">{{ mois1 }}</h3>
                        <p class="valeurBilan" id="total">{{ recette1.toLocaleString("de-DE") }} Ar</p>
                    </div>
                </div>

                <div class="divBilan">
                    <div class="divIcon" style="background: #ffedd5;">
                    </div>
                    <div class="divDetailBilan">
                        <h3>{{ mois2 }}</h3>
                        <p class="valeurBilan" id="min">{{ recette2.toLocaleString("de-DE") }} Ar</p>
                    </div>
                </div>

                <div class="divBilan">
                    <div class="divIcon" style="background: #dcfce7;">
                    </div>
                    <div class="divDetailBilan">
                        <h3>{{ mois3 }}</h3>
                        <p class="valeurBilan" id="max">{{ recette3.toLocaleString("de-DE") }} Ar</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="divBas">

            <div class="divContenu">
                
                <div class="divBilan">
                    <div class="divIcon" style="background: #fee2e2;">
                    </div>
                    <div class="divDetailBilan">
                        <h3 id="loyer total">{{ mois4 }}</h3>
                        <p class="valeurBilan" id="total">{{ recette4.toLocaleString("de-DE") }} Ar</p>
                    </div>
                </div>

                <div class="divBilan">
                    <div class="divIcon" style="background: #f3e8ff;">
                    </div>
                    <div class="divDetailBilan">
                        <h3>{{ mois5 }}</h3>
                        <p class="valeurBilan" id="min">{{ recette5.toLocaleString("de-DE") }} Ar</p>
                    </div>
                </div>

                <div class="divBilan">
                    <div class="divIcon" style="background: #fef3c7;">
                    </div>
                    <div class="divDetailBilan">
                        <h3>{{ mois6 }}</h3>
                        <p class="valeurBilan" id="max">{{ recette6.toLocaleString("de-DE") }} Ar</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="divGraphique">

            <h1>Graphique</h1>

            <div class="contenuGraphique">

                <Bar id="graphique" :options="options" :data="valeur"></Bar>

            </div>

        </div>

    </div>

</template>

<script>

    import axios from "axios";
    import { Bar } from 'vue-chartjs';
    import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, LineController } from 'chart.js';
    ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

    export default {
        name: "PageStatistique",
        components : {
            Bar
        },
        data() {
            return {
                mois1 : "",
                mois2 : "",
                mois3 : "",
                mois4 : "",
                mois5 : "",
                mois6 : "",
                recette1 : 0,
                recette2 : 0,
                recette3 : 0,
                recette4 : 0,
                recette5 : 0,
                recette6 : 0,
                valeur: {
                    labels: [sessionStorage.getItem("mois1"), sessionStorage.getItem("mois2"), sessionStorage.getItem("mois3"),
                    sessionStorage.getItem("mois4"), sessionStorage.getItem("mois5"), sessionStorage.getItem("mois6")],
                    datasets: [
                        {
                            label: "Recette en Ariary",
                            backgroundColor: ["#e0e7ff", "#ffedd5","#dcfce7", "#fee2e2", "#f3e8ff", "#fef3c7"],
                            borderColor: ["#b4c6fc", "#fdba74", "#86efac", "#fca5a5", "#d8b4fe", "#fcd34d"],
                            borderWidth: 2,
                            borderRadius: 8,
                            hoverBackgroundColor: ["#c7d2fe", "#fed7aa", "#bbf7d0", "#fecaca", "#e9d5ff", "#fde68a"],
                            hoverBorderColor: ["#818cf8", "#fb923c", "#4ade80", "#f87171", "#c084fc", "#fbbf24"],
                            data: []
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                boxWidth: 0,
                                color: "#1e293b",
                                font: {
                                    size: 18,
                                    family: "'Inter', 'Helvetica Neue', Arial, sans-serif"
                                }
                            },
                            position: "top"
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: ["#818cf8", "#fb923c", "#4ade80", "#f87171", "#c084fc", "#fbbf24"],
                                font: {
                                    size: 18,
                                    family: "'Inter', 'Helvetica Neue', Arial, sans-serif"
                                }
                            }
                        },
                        y: {
                            ticks: {
                                color: "#1e293b",
                                font: {
                                    size: 16,
                                    family: "'Inter', 'Helvetica Neue', Arial, sans-serif"
                                }
                            }
                        }
                    }
                }
            }
        },
        methods: {
        
            async recuperer() {
                try {
        
                    const reponse = await axios.get("http://localhost/gestionnaire-vente-voiture/backend/recette.php");

                    this.mois1 = reponse.data[0].mois;
                    this.mois2 = reponse.data[1].mois;
                    this.mois3 = reponse.data[2].mois;
                    this.mois4 = reponse.data[3].mois;
                    this.mois5 = reponse.data[4].mois;
                    this.mois6 = reponse.data[5].mois;
                    this.recette1 = reponse.data[0].recette;
                    this.recette2 = reponse.data[1].recette;
                    this.recette3 = reponse.data[2].recette;
                    this.recette4 = reponse.data[3].recette;
                    this.recette5 = reponse.data[4].recette;
                    this.recette6 = reponse.data[5].recette;

                    sessionStorage.setItem("mois1", String(reponse.data[0].mois).slice(0, -5));
                    sessionStorage.setItem("mois2", String(reponse.data[1].mois).slice(0, -5));
                    sessionStorage.setItem("mois3", String(reponse.data[2].mois).slice(0, -5));
                    sessionStorage.setItem("mois4", String(reponse.data[3].mois).slice(0, -5));
                    sessionStorage.setItem("mois5", String(reponse.data[4].mois).slice(0, -5));
                    sessionStorage.setItem("mois6", String(reponse.data[5].mois).slice(0, -5));
                    
                } catch (erreur) {
                    alert("Connexion impossible!" + erreur.message);
                    return;
                }
            }
        },
        mounted() {
            this.recuperer();
            this.valeur.datasets[0].data[0] = sessionStorage.getItem("recette1");
            this.valeur.datasets[0].data[1] = sessionStorage.getItem("recette2");
            this.valeur.datasets[0].data[2] = sessionStorage.getItem("recette3");
            this.valeur.datasets[0].data[3] = sessionStorage.getItem("recette4");
            this.valeur.datasets[0].data[4] = sessionStorage.getItem("recette5");
            this.valeur.datasets[0].data[5] = sessionStorage.getItem("recette6");
        }
}


</script>

<style scoped>

    .divContenuRecette {
        height: 100%;
    }

    .divConteneur {
        flex: 1;
        margin-left: 3%;
        margin-right: 3%;
        font-family: "Inter Variable", sans-serif;
    }

    .divEnTete h1 {
        color: #7494ec;
        font-size: x-large;
    }

    .divContenu {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1rem;
    }

    .divBas {
        margin-left: 3%;
        margin-right: 3%;
    }

    .divBilan {
        background-color: #fff;
        padding-top: 5%;
        padding-bottom: 10%;
        padding-left: 10%;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: flex-start;
        gap: 10%;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
    }

    .divBilan:hover, .divGraphique:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
    }

    .divIcon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .divDetailBilan h3 {
        margin-top: -1%;
        font-size: 16px;
        color: #64748b;
        font-weight: 500;
    }

    .valeurBilan {
        font-size: 1.5rem;
        font-weight: 700;
        color: #334155;
        margin: 0.25rem 0;
    }

    h2 {
        font-family: "Poppins", sans-serif;
        color: #64748b;
        font-size: x-large;
        margin-left: 5%;
    }

    .divGraphique {
        background-color: #fff;
        height: 40%;
        margin-left: 3%;
        margin-right: 3%;
        border-radius: 12px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
    }

    .divGraphique h1 {
        padding-left: 5%;
        padding-top: 2%;
        color: #7494ec;
        font-size: x-large;
    }

    .contenuGraphique {
        padding-left: 15%;
        padding-right: 15%;
        height: 70%;
    }


</style>