#INSSD THEME

PRÉREQUIS (LOCAL UNIQUEMENT) :

NE PAS OUBLIER DE RENSEIGNER LES VARIABLES D'ENVIRONNEMENTS DANS VOTRE VHOST :

	SetEnv MYSQL_HOST localhost
    	SetEnv MYSQL_USER user
    	SetEnv MYSQL_PASSWORD pass
    	SetEnv MYSQL_DATABASE inssd_bdd

CONFIGURER LA REDIRECTION dans :
/etc/hosts (MacOs / Linux) - C:\Windows\System32\drivers\etc (Windows 10)

INSTALLATION :

1- Node JS
instal nodejs -> https://nodejs.org/en/

2 - Gulp
Pour mac/linux : sudo npm install gulp -g
Pour Windows : install -g gulp

3 - En cas d'erreur
https://docs.npmjs.com/resolving-eacces-permissions-errors-when-installing-packages-globally


LANCER LA COMPILATION SASS :

Dans le terminal placez vous à la racine du repo /inseinesaintdenis/ et tapez : gulp

That it ! enjoy =)
