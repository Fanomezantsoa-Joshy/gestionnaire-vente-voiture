import { createRouter, createWebHistory } from 'vue-router'
import CreerCompte from '@/components/CreerCompte.vue'
import Connexion from '@/components/Connexion.vue'
import MdpOublier from '@/components/MdpOublier.vue'
import PagePrincipale from '@/components/PagePrincipale.vue'
import nouveauClient from '@/components/nouveauClient.vue'
import listeClient from '@/components/listeClient.vue'
import nouveauVoiture from '@/components/nouveauVoiture.vue'
import listeVoiture from '@/components/listeVoiture.vue'
import nouveauAchat1 from '@/components/nouveauAchat1.vue'
import nouveauAchat2 from '@/components/nouveauAchat2.vue'
import facture from '@/components/facture.vue'
import listeAchat from '@/components/listeAchat.vue'
import recette from '@/components/recette.vue'
import modifierClient from '@/components/modifierClient.vue'
import modifierVoiture from '@/components/modifierVoiture.vue'
import modifierAchat1 from '@/components/modifierAchat1.vue'
import modifierAchat2 from '@/components/modifierAchat2.vue'
import modifierAchat3 from '@/components/modifierAchat3.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: Connexion
    },
    {
      path: '/mdpOublier',
      component: MdpOublier
    },
    {
      path: '/creerCompte',
      component: CreerCompte
    },
    {
      path: '/pagePrincipale',
      component: PagePrincipale,
      redirect: '/pagePrincipale/recette',
      children: [
        {
          path: 'nouveauClient',
          component: nouveauClient
        },
        {
          path: 'listeClient',
          component: listeClient
        },
        {
          path: 'modifierClient',
          component: modifierClient
        },
        {
          path: 'nouveauVoiture',
          component: nouveauVoiture
        },
        {
          path: 'listeVoiture',
          component: listeVoiture
        },
        {
          path: 'modifierVoiture',
          component: modifierVoiture
        },
        {
          path: 'nouveauAchat1',
          component: nouveauAchat1
        },
        {
          path: 'nouveauAchat2',
          component: nouveauAchat2
        },
        {
          path: 'facture',
          component: facture
        },
        {
          path: 'modifierAchat1',
          component: modifierAchat1
        },
        {
          path: 'modifierAchat2',
          component: modifierAchat2
        },
        {
          path: 'modifierAchat3',
          component: modifierAchat3
        },
        {
          path: 'listeAchat',
          component: listeAchat
        },
        {
          path: 'recette',
          component: recette
        }
      ]
    }
  ],
})

export default router
