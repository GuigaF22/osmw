@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ 
Configuration requise pour OSWebManager:
    -- SSH / Mono / Apache / Mysql / PHPMyAdmin* / Lib php SSH2  (*pas n�cessaire si autre moyen)
Fonctionnement:
    -- OSMW envoi des commandes au simulateur via le fichier "Screensend" dans un screen Unix
    -- Le simulateur est lanc� par le fichier batch "RunOpensim.sh" qui contient le nom du screen (moteur)
    -- Certains fichiers doivent avoir les droits 777 pour pouvoir etre modifier par OSMW
    -- Les fichiers fournis doivent etre install�s dans chaque simulateurs (moteurs)
    -- ATTENTION aux droits d'acc�s aux fichiers 
    --> R�gions.ini (droits �criture) / OpensimDefaults.ini , etc.. qui doivent etre accessible
Gestion des Utilisateurs:
    => 5 Niveaux d'acc�s sont autoris�s
    -- Administrateurs 
    -- Gestionnaires de sauvegardes
    -- Invit�s / Compte priv� par moteur
    -- 1 compte root
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

******************************************
*********** Suivi de versions ************
******************************************

*** v6.0 *** MISE A JOUR MAJEUR ***
/* NEWS 2020 by djphil */
-- PHP 7 Compatibility
-- Cleanup Code
-- Fix bugs
-- Npc Managment
-------------------------------------------------------
*** v5.0 *** MISE A JOUR MAJEUR ***
/* NEWS 2015 by djphil */
-- Cleanup Code
-- Fix bugs
-- Add Themes
-- Add bootstrap
-- Add Multilanguage
-- Add Google Recaptcha v2.0
-- Add Navbar, Hg, Map, Contact, ...
-- Add more actions, options, infos, ...
And more, and more, and more ...
-- ...
-------------------------------------------------------
*** v4.0 Beta *** En cours
-- Mise � jours des SESSION
-- Systeme d'installation int�gr�s **
-- ...
-------------------------------------------------------
*** v3.2 Final ***
-- Gestion des sauvegardes de la config des moteurs Opensim et pour chaque sim
-- Transfert des fichiers de sauvagardes vers un serveur FTP exterieur
-- Detection des fichiers de config moteurs
-------------------------------------------------------
*** v3.0 *** MISE A JOUR MAJEUR ***
-- OSMW � sa propre base de donn�e *** Nouveaut�
-- Les Fichiers de config , conf moteurs et users sont en BDD ( prb de s�curit� !)
-- Compte Utilisateur filtr� au niveau des moteurs (choix du moteur) *** Nouveaut�
-- Verifier/ Modifier/ configurer vos INIs, opensim, grid, ... *** Nouveaut�
-- Connectivit� AdmOSMW (Referencement sur le site Fgagod.net) 
-------------------------------------------------------
*** v2.0 ***
-- Optimisations du code
-------------------------------------------------------
*** v1.1 ***
-- Refonte complete de l'interface
-- Syst�me d'installation simplifi�
-- Gestion des moteurs OpenSim, des utilisateurs et de la config en .INI
-- ...
--------------------------------------------------------
*** v1.0 ***
-- Ajout de la gestion multi-Utilisateurs dans OSMW
--------------------------------------------------------
*** v0.9.11 ***
-- Authentification multi-users via fichier texte  (pas encore int�grer � OSMW)
--------------------------------------------------------
*** v0.7.11 ***
-- Ajouts de Fonctionnalt�es;
	-- Cartographie ajout�
	-- TOUS demarrer et arreter d'une seule fois
	-- Une serie de tests pour voir si tous fonctionne bien
	-- Ce fichier LOL
-- Optimisations du code
--------------------------------------------------------
*** v0.6.11 ***
-- Premiere version de OSWebManager
