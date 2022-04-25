# production-laitier
CodeIgniter php

gestion de production laitier 

I .. Partie simple utilisateur:
  1. Inscription
  2. Login
  3. 

II. Partie super-utilisateur:
  1. Login
  2. Validation inscription (envoi mail automatique pour confirmation)
  3. Insertion achat de matiere premiere: . insertion en entree stock matiere premiere
  4. Liste d'achat necessaire : . liste achat necessaire
                                . exportation en excel
  5. Etat de stock de chaque matiere premiere
  6. Insertion produit fini (verification stock matiere premiere selon la formule de fabrication):
        - Si quantite non suffisante: proposition de quantite de produit finie avec le reste en stock de matiere premiere
        - Si quantite suffisante: . insertion en entree stock produit fini
                                  . insertion en sortie stock matiere premiere
  8. Etat de stock de chaque produit fini
  9. Insertion de vente de produit : . insertion en sortie stock produit fini
