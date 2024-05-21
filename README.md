révision avec fake api https://jsonplaceholder.typicode.com/guide/

Aller dans le dossier Parent, ouvrir un terminal et taper la commande: symfony new --webapp NomDuProjet

Après la création du projet, aller dans le .env, dé-commenter la ligne 28 et commenter la ligne 29 et changer ceci pour la ligne 28: DATABASE_URL="mysql://root@127.0.0.1:3306/NomDuProjet?serverVersion=10.11.2-MariaDB&charset=utf8mb4"

Pour créer une base de donnée, aller dans le terminal et taper: php bin/console doctrine:database:create

Pour créer une entité, aller dans le terminal et taper: php bin/console make:entity

Pour créer une relation entre deux entités, après avoir rentrer les attributs de la deuxième entité, rentrer leEntité/lesEntités puis en Field Type taper: relation puis taper le nom de l’entité en relation (regarder dans le dossier Entity pour connaître orthographe exacte) puis choisissez votre type de relation puis taper entrer pour les deux questions suivantes puis pour le nom du champ choisir le leEntité/lesEntités au lieu de entité

La migration se fait avec la commande: php bin/console make:migration puis php bin/console doctrine:migrations:migrate puis yes pour remplacer la database

Pour créer un form la commande: php bin/console make:form puis pour le nom du form on rentre: NomDuFormType (tjrs finir par Type) puis rentrer le nom de l’entité où on va rentrer les infos (voir le dossier Entity pour connaitre l’orthographe exacte)

Pour ajouter un bouton submit dans le form, aller dans le fichier dans le dossier form puis ajouter dans $builder, à la fin:  ->add('save',SubmitType::class,['label'=>'Enregistrer']) puis rajouter:
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

Pour créer un contrôleur, il faut taper: php bin/console make:controller puis aller dans src/Controller/QqchoseController.php

Pour lancer l’appli symfony, créer un nouveau terminal et taper: symfony server:start

Form de base:

{{ form_start(form) }}
{{ form_widget(form) }}
{{ form_end(form) }}




Menu déroulant dans un form:

->add('leHotel', EntityType::class, [
                'class' => Hotel::class,
                'choice_label' => 'nom',
                'multiple' => false, 
                'expanded' => true,
])

Multiple sert à choisir réponses ou non.
Expanded sert à choisir le style.

Puis rajouté:

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
Et le use de la classe: use App\Entity\Hotel;

Uttiliser SASS

Dans un terminal, taper: composer require symfony/webpack-encore-bundle
Puis taper dans le terminal:  npm install
Aller dans le fichier webpack.config.js et dé-commenter en ligne 57 .enableSassLoader()
 Installer le sassloader avec npm install sass-loader@^13.0.0 sass --save-dev
Puis lancer npm run dev
Aller dans assets puis styles et changer l’extension pour .scss et faire la même chose dans le fichier app.js

Installer Bootstrap

https://github.com/LaTituzine/Utiliser-Bootstrap-avec-Symfony-6

Rentrer npm install bootstrap --save-dev
Rentrer npm i bootstrap-icons

Aller dans app.scss et copier:

@import "~bootstrap/scss/bootstrap";
@import "~bootstrap-icons/";

Aller dans app.js et copier: import "bootstrap";

Installer VueJS

Commencer par installer encore avec: composer require symfony/webpack-encore-bundle
Puis rentrer npm install ou npm i

Puis copier « .enableVueLoader() » dans le fichier webpack.config après la ligne 9 dans Encore

puis lancer yarn encore dev --watch pour relancer encore 

Puis installer vue avec: npm install vue@latest vue-loader@latest vue-template-compiler --save-dev

Et enfin créer un dossier components dans le dossier assets

Puis lancer yarn encore dev --watch pour lancer le serveur pour auto refresh

Créer des Users

Pour créer des Users, il faut utiliser la commande: php bin/console make:user
C’est comme créer une entity mais spécialement pour les utilisateurs donc il est possible de rajouter des relations ou des champs avec php bin/console make:entity

Créer un formulaire d’inscription

Pour créer un formulaire d’inscription, il faut utiliser la commande: 
php bin/console make:registration-form

Créer un formulaire de login

Pour créer un formulaire d’inscription, il faut utiliser la commande: 
php bin/console make:auth

Pour le style de d’authentification:
L’option 0 est faite pour partir de rien
L’option 1 crée un formulaire qui marche directement

Puis aller dans src->Security->VotreFormulaireAuthentification.php et décommenter la ligne 52 et remplacer ‘some_route’ par la route de votre page de redirection et supprimer/commenter la ligne 53

Gestion des erreurs

Composer require symfony/twig-pack et passer en prod dans le fichier .env




Réaliser des méthodes

La création des méthode se fait dans les entités.

Dans le controller, pour récupérer l’entité, on fait: $entité= $entitéRepository->find($id);
Pour vérifier si l’entité existe:
if (!$entité) {
            throw $this->createNotFoundException('Aucune entité trouvée pour l\'id ' . $id);
}
Pour uttiliser la méthode dans le controller:  $result= $entité->votreMéthode();

Comment Envoyer des mails:

installer composer require phpmailer/phpmailer

Code d’exemple de mail:
// Créer une nouvelle instance de PHPMailer
        $mail = new PHPMailer\PHPMailer();

        // Activer le mode de débogage (0 pour désactiver)
        $mail->SMTPDebug = 0;

        // Définir le type de transport sur SMTP
        $mail->isSMTP();

        // Hôte du serveur SMTP (MailHog utilise souvent le port 1025)
        $mail->Host = 'localhost';
        $mail->Port = 1025;

        // Désactiver l'authentification SMTP (MailHog n'a généralement pas besoin d'authentification)
        $mail->SMTPAuth = false;

        // Définir l'expéditeur et le destinataire
        $mail->setFrom('votre_email@example.com', 'Votre Nom');
        $mail->addAddress('destinataire@example.com', 'Nom du destinataire');

        // Définir le sujet du mail
        $mail->Subject = 'Sujet du mail';

        // Corps du mail au format HTML
        $mail->msgHTML('<p>Ceci est le corps du message au format HTML.</p>');

        // Ajouter une pièce jointe (facultatif)
        //$mail->addAttachment('chemin/vers/fichier.pdf');

        // Envoyer le mail
        if ($mail->send()) {
            $msg= 'Le message a été envoyé avec succès.';
        } else {
            $msg= 'Erreur lors de l\'envoi du message : ' . $mail->ErrorInfo;
        }

Comment recevoir des mails:

Télécharge la version qui correspond :

https://github.com/mailhog/MailHog/releases/tag/v1.0.1

Exécute le fichier .exe

Pour afficher ta boite de reception mailhog = http://localhost:8025/

Apres tu vas sur vscode dans dans ton .env tu met : MAILER_DSN=smtp://localhost:1025

Pour finir tu vas sur config/packages/messenger.yaml et tu commente la ligne = Symfony\Component\Mailer\Messenger\SendEmailMessage: async

Comment faire une API:

https://www.youtube.com/watch?v=HDy3-HTR4yM
Installer le package: composer require api

Puis aller dans une entité choisis que vous voulez que les infos soit accessibles via une api et ajouter le packet ApiResource puis ajouter #[ApiResource] juste avant la signature de l’entité ex: public entité{}
