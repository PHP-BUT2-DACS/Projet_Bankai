 ![Bankai](https://www.icegif.com/wp-content/uploads/2023/03/icegif-988.gif)

# 🏆 Bankai — Réseau Social Sportif

## 🎯 Découverte du projet

Bankai est un réseau social centré autour de **trois sports qui nous passionnent** :  
⚽ **Football**, 🏀 **Basketball**, et 🏎️ **Formule 1**.

---

## 🧭 Ligne directrice

### 👤 Création de compte & profil  
Commencez par créer un compte à votre nom.  
Une fois connecté, vous arrivez sur **la page principale** : celle des **posts des utilisateurs**.

Avant d'explorer plus loin, rendez-vous dans la **sidebar droite > "Profil"** :  
Vous y trouverez toutes vos **informations personnelles** :
- Pseudo, nom, prénom, photo de profil
- Sports favoris, équipe, localisation
- Date de création du compte
- Vos abonnés, vos abonnements et vos posts

🔧 **Pensez à compléter ou modifier votre profil** si nécessaire.

Il existe aussi un compte admin : 
- mail : admin@admin.com
- Mdp : password

---

### ✍️ Créer un post

Une fois votre profil prêt, créez votre **premier post**.

Chaque post contient :
- Un titre
- Un message
- Un sport associé (pour un filtrage plus pertinent selon les centres d’intérêt)

Vous retrouverez ensuite vos posts et ceux des autres dans un **fil chronologique** sur la page principale.

Vous pouvez :
- 🔥 Liker des posts  
- 🗑️ Supprimer les vôtres  
- 🔍 Filtrer par sport ou voir tous les posts  
- 👤 Cliquer sur le pseudo d’un utilisateur pour visiter son profil, vous abonner, etc.

---

### 🔎 Rechercher

Cliquez sur **"Rechercher"** pour trouver :
- Des **utilisateurs** (ex : "Cristiano Ronaldo")
- Des **posts**
- Des **équipes**

Vous pouvez ainsi vous abonner à d'autres utilisateurs, retrouver des contenus spécifiques, ou identifier votre future équipe favorite.

---

### 🛡️ Les équipes

Pas encore d’équipe ? Créez la vôtre dans l’onglet **"Team"**.  
Vous y trouverez aussi la liste de toutes les équipes déjà créées.

---

### 📅 Matchs & Événements

- L’onglet **"Matchs"** permet de consulter les matchs à venir ou passés selon les **sports et les dates**.
- L’onglet **"Calendrier"** permet de :
  - 📌 **Créer ou rejoindre** des **conférences** et **entraînements**
  - ✅ Participer à une conférence (cliquer dessus)
  - 📅 Voir les événements programmés (⚠️ *Nécessite un rafraîchissement manuel après action*)

> ℹ️ Les entraînements sont **associés à votre équipe**. Vous ne voyez que ceux de votre propre équipe, et vous y êtes inscrit automatiquement.

---

## ⚙️ Prérequis & Installation

1. **Cloner le dépôt :**
   ```bash
   git clone https://github.com/PHP-BUT2-DACS/Projet_Bankai.git
   ``` 
  
en console admin :  
```bash
cd "project_directory"  
mkdir bootstrap\cache  
mkdir storage\framework\views  
mkdir storage\framework\cache  
mkdir storage\framework\sessions  
  ```
Changer le database.sqlite de dossier (/database)
  ```bash
Composer install  
npm install
```
.env.example -> .env  
Dans le projet
```bash:  
npm run build  
php artisan serve  
```
🔐 Configuration SSL pour PHP et l’API
Pour éviter les erreurs SSL lors des requêtes externes (ex: API Sports), suivez ces étapes :

Téléchargez le fichier cacert.pem
- 👉 https://curl.se/ca/cacert.pem

Enregistrez-le par exemple dans :
- C:\wamp64\bin\php\cacert.pem
  
ou
- C:\xampp\php\extras\ssl\cacert.pem

Configurez php.ini pour utiliser ce certificat

Ouvrez le fichier php.ini (vous pouvez utiliser php --ini pour en connaître le chemin).

Recherchez la ligne suivante et dé-commentez-la (enlevez le ;), puis ajoutez le chemin complet :
```bash
curl.cainfo = "C:\wamp64\bin\php\cacert.pem"
```
Faites de même pour :
```bash
openssl.cafile = "C:\wamp64\bin\php\cacert.pem"
```
💡 Redémarrez votre serveur local après avoir modifié php.ini.

## 📚 Sources

### 🔌 API utilisée :
- [API Sports](https://api-sports.io/)

### 📖 Tutoriels & Documentation :
- [Blog Laravel – Kinsta](https://kinsta.com/fr/blog/blog-laravel/)
- [Laravel Jetstream : rejoindre une équipe à l'inscription (Stack Overflow)](https://stackoverflow.com/questions/68557588/laravel-jetstream-how-to-join-a-default-team-at-registration)
- [Laravel Starter Kits — Documentation officielle](https://laravel.com/docs/10.x/starter-kits)
- [Fonction "favoris" dans Laravel (Stack Overflow)](https://stackoverflow.com/questions/67518401/favorite-functionality-for-my-laravel-application)
- [Laravel Markable](https://laravel-news.com/laravel-markable)
- [Moteur de recherche dans Laravel (Medium)](https://medium.com/@iqbal.ramadhani55/search-in-laravel-e0e20f329b01)
- [Intégration FullCalendar avec Livewire](https://laravel.sillo.org/posts/liveware-fullcalendar)

### 🎥 Vidéos :
- [Créer une app Laravel 9 avec Laravel Breeze et Livewire (YouTube)](https://www.youtube.com/watch?v=UbZ35yWnpgU)
- [Créer un réseau social avec Laravel et Jetstream (YouTube)](https://www.youtube.com/watch?v=UgIvT5L92Rg&t=30s)
- [Laravel Livewire FullCalendar Event CRUD (YouTube)](https://www.youtube.com/watch?v=ZNETtfaZbVQ)

### 🧠 Aides à la réflexion :
- Utilisation de **Grok**, **ChatGPT**, **Claude**, **DeepSeek** et **Perplexity**

### ⭐ Mention spéciale :
- Le meilleur cours PHP jamais créé :  
  👉 [Cours de PHP par Julien Caposiena](https://phd.julien-cpsn.com/courses/PHP/)
