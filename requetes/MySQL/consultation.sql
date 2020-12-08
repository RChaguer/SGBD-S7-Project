-- ===============================================
-- ============== CONSULTATIONS ==================
-- ===============================================


-- requete pour affichier le nom et la date de création d'un club (Bordeaux)
select NOM_CLUB, DATE_CREATION 
    from CLUB C         
    where ID_CLUB = 1;


-- requete pour affichier des informations sur les équipes
-- du club HBC BORDEAUX ordonnés par le nom du catégorie
select E.ID_EQUIPE ID, E.NOM_EQUIPE NOM, G.NOM_CATEGORIE CAT
    from EQUIPE E inner join CATEGORIE G on G.ID_CATEGORIE = E.ID_CATEGORIE 
    where E.ID_CLUB = 1
    order by G.NOM_CATEGORIE;


-- requete pour affichier l'ID et le nom d'une catégorie donnée (ici 7)
select ID_CATEGORIE, NOM_CATEGORIE
    from CATEGORIE
    where ID_CATEGORIE = 7;


-- requete pour affichier les informations de l'équipe qui a ID_EQUIPE =13
select E.NOM_EQUIPE NOM,  G.NOM_CATEGORIE CAT, C.NOM_CLUB CLUB
    from EQUIPE E inner join CLUB C on E.ID_CLUB=C.ID_CLUB 
    inner join CATEGORIE G on G.ID_CATEGORIE=E.ID_CATEGORIE
    where ID_EQUIPE = 13;


-- requete pour affichier des informations sur un sportif donné
-- (Joueur|entraineur) (ici ID_SPORTIF = 8 )
select I.ID_INDIVIDU ID, I.NOM_INDIVIDU NOM,
       I.PRENOM_INDIVIDU PRENOM, I.ADRESSE ADR
    from INDIVIDU I inner join SPORTIF S on I.ID_INDIVIDU = S.ID_SPORTIF  
    where I.ID_INDIVIDU = 8;


-- requete pour affichier les informations (incluant la date de début)
-- sur les joueurs actuels d'une équipe donnée (ici HBC BORDEAUX)
select I.ID_INDIVIDU ID, I.NOM_INDIVIDU NOM,
       I.PRENOM_INDIVIDU PRENOM, T.DATE_DEBUT DATE
    from JOUEUR P inner join PLAYER_ACTUAL_TEAM T on P.ID_JOUEUR = T.ID_JOUEUR
    inner join INDIVIDU I on I.ID_INDIVIDU = P.ID_JOUEUR
    where T.ID_EQUIPE = 13;


-- requete pour affichier les informations (incluant date de naissance / numéro de licence ..)
--  sur un joueur donné (ici ID_JOUEUR =8)
select P.ID_JOUEUR ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM,
       I.ADRESSE ADR, P.NUMERO_LICENCE NUM_LIC, P.DATE_NAISSANCE DATE
    from (INDIVIDU I inner join JOUEUR P on I.ID_INDIVIDU = P.ID_JOUEUR)
    where I.ID_INDIVIDU = 8;


-- requete pour affichier les informations (incluant date de naissance / numéro de licence ..)
-- sur tous les joueurs
select P.ID_JOUEUR ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM,
       I.ADRESSE ADR, P.NUMERO_LICENCE NUM_LIC, P.DATE_NAISSANCE DATE,
       V.NOM_EQUIPE  NOM_E
    from (INDIVIDU I inner join JOUEUR P on I.ID_INDIVIDU = P.ID_JOUEUR) 
    right outer join PLAYER_ACTUAL_TEAM V on V.ID_JOUEUR=P.ID_JOUEUR;


-- requete pour afficher la liste des joueurs d'une équipe donnée
-- ici (ID_EQUIPE = 27 ) qui ont joué dans l'intervalle de temps 
-- [date1,date2] (ici date1 = '2020-02-21' et date2 = '2020-07-15')
select J.ID_JOUEUR ID, I.NOM_INDIVIDU NOM,
       I.PRENOM_INDIVIDU PRENOM , E.NOM_EQUIPE EQUIPE,
       H.DATE_DEBUT as 'DATE DEBUT',
       H.DATE_FIN as 'DATE_FIN'
    from JOUEUR J inner join HISTORIQUE H on J.ID_JOUEUR = H.ID_SPORTIF 
    inner join INDIVIDU I on I.ID_INDIVIDU = J.ID_JOUEUR 
    inner join EQUIPE E on E.ID_EQUIPE = H.ID_EQUIPE
    where H.DATE_DEBUT <= '2020-02-21' and (H.DATE_FIN is null or H.DATE_FIN > '2020-07-15')
    and E.ID_EQUIPE = 27;


-- requete pour affichier tous les personnels d'un club  donné 
-- (ici ID_CLUB = 1) avec leurs roles
select I.ID_INDIVIDU ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM,
       R.NOM_ROLE ROLE, I.ADRESSE ADR, C.NOM_CLUB CLUB
    from (INDIVIDU I inner join PERSONNEL P on I.ID_INDIVIDU = P.ID_PERSONNEL) 
    inner join CLUB C on C.ID_CLUB = P.ID_CLUB
    inner join ROLE_PERSONNEL RP on I.ID_INDIVIDU = RP.ID_PERSONNEL
    inner join ROLE R on RP.ID_ROLE = R.ID_ROLE
    where C.ID_CLUB = 1;


-- requete pour affichier tous les personnels de tous les clubs qui ont 
-- un meme role donné (ici ID_ROLE = 1)
select I.ID_INDIVIDU ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM,
       R.NOM_ROLE ROLE, I.ADRESSE ADR, C.NOM_CLUB CLUB
    from (INDIVIDU I inner join PERSONNEL P on I.ID_INDIVIDU = P.ID_PERSONNEL) 
    inner join CLUB C on C.ID_CLUB = P.ID_CLUB
    inner join ROLE_PERSONNEL RP on I.ID_INDIVIDU = RP.ID_PERSONNEL
    inner join ROLE R on RP.ID_ROLE = R.ID_ROLE
    where R.ID_ROLE = 1;


-- requete pour affichier tous les roles qui existent
select ID_ROLE ID, NOM_ROLE NOM
    from ROLE;


-- requete pour affichier les scores des matchs joués à une date donnée
-- (ici'2020-01-01')
select E_R.NOM_EQUIPE HOME, ifnull(S.SCOREHOME, 0) as SCOREHOME,
       ifnull(S.SCOREAWAY, 0) as SCOREAWAY, E_V.NOM_EQUIPE AWAY,
       M.DATE_RENCONTRE DATE, G.NOM_CATEGORIE CAT, SA.LABEL SAISON,
       ST.NOM_STADE STADE     
    from SCORE S right outer join RENCONTRE M on M.ID_RENCONTRE = S.RENCONTRE
    inner join SAISON SA on SA.ID_SAISON = M.ID_SAISON
    inner join EQUIPE E_V on E_V.ID_EQUIPE = M.ID_EQUIPE_V
    inner join EQUIPE E_R on E_R.ID_EQUIPE = M.ID_EQUIPE_R
    inner join CATEGORIE G on G.ID_CATEGORIE = E_V.ID_CATEGORIE
    inner join STADE ST on ST.ID_STADE = M.ID_STADE
    where M.DATE_RENCONTRE = '2020-01-01';


-- requete pour affichier les scores de tous les matchs joués par une équipe
-- dans une saison (ici ID_EQUIPE =13 et ID_SAISON=2)
select E_R.NOM_EQUIPE HOME, ifnull(S.SCOREHOME, 0) as SCOREHOME,
       ifnull(S.SCOREAWAY, 0) as SCOREAWAY, E_V.NOM_EQUIPE AWAY,
       M.DATE_RENCONTRE DATE, G.NOM_CATEGORIE CAT, SA.LABEL SAISON,
       ST.NOM_STADE STADE     
    from SCORE S right outer join RENCONTRE M on M.ID_RENCONTRE = S.RENCONTRE
    inner join SAISON SA on SA.ID_SAISON = M.ID_SAISON
    inner join EQUIPE E_V on E_V.ID_EQUIPE = M.ID_EQUIPE_V
    inner join EQUIPE E_R on E_R.ID_EQUIPE = M.ID_EQUIPE_R
    inner join CATEGORIE G on G.ID_CATEGORIE = E_V.ID_CATEGORIE
    inner join STADE ST on ST.ID_STADE = M.ID_STADE
    where (M.ID_EQUIPE_R = 13 or M.ID_EQUIPE_V = 13) and M.ID_SAISON = 2;


-- requete pour affichier les joueurs participants dans une rencontre avec 
-- leurs postes et en affichant le nombre de buts/fautes qui ont marqués/commis 
--  (ici ID_RENCONTRE = 1)
select I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM, JM.NOM_POSTE POSTE,
       JM.NOMBRE_BUT BUTS, JM.NOMBRE_FAUTE FAUTES, JM.NOM_EQUIPE EQUIPE
    from JOUEURS_MATCH JM inner join INDIVIDU I on JM.ID_JOUEUR = I.ID_INDIVIDU
    where JM.ID_RENCONTRE  = 1;


-- requete pour affichier le nombre de matchs gagnés/perdus/nuls
-- pour les clubs à une saison donnée (ici ID_SAISON = 2 (20/21))
select  CLUB.NOM_CLUB NOM,
        IFNULL(STATS_CLUBS.WINS, 0) WINS,
        IFNULL(STATS_CLUBS.DRAWS, 0) DRAWS,
        IFNULL(STATS_CLUBS.LOSSES, 0) LOSSES,
        LABEL SAISON
    from STATS_CLUBS right outer join CLUB on STATS_CLUBS.ID_CLUB = CLUB.ID_CLUB
    inner join SAISON on STATS_CLUBS.ID_SAISON = SAISON.ID_SAISON
    where STATS_CLUBS.ID_SAISON = 2
    group by STATS_CLUBS.ID_CLUB;


-- requete pour affichier le nombre de matchs gagnés/perdus/nuls
-- pour les clubs à tous les saisons
select  CLUB.NOM_CLUB NOM,
        IFNULL(SUM(STATS_CLUBS.WINS), 0) WINS,
        IFNULL(SUM(STATS_CLUBS.DRAWS), 0) DRAWS,
        IFNULL(SUM(STATS_CLUBS.LOSSES), 0) LOSSES
    from STATS_CLUBS right outer join CLUB on STATS_CLUBS.ID_CLUB = CLUB.ID_CLUB
    group by STATS_CLUBS.ID_CLUB;


-- requete pour affichier la feuille du match
select E_R.NOM_EQUIPE HOME, ifnull(S.SCOREHOME, 0) as SCOREHOME, ifnull(S.SCOREAWAY, 0) as SCOREAWAY, E_V.NOM_EQUIPE AWAY, M.DATE_RENCONTRE DATE, G.NOM_CATEGORIE CAT, SA.LABEL S_LABEL , ST.NOM_STADE STADE     
    from SCORE S right outer join RENCONTRE M on M.ID_RENCONTRE = S.RENCONTRE
    inner join SAISON SA on SA.ID_SAISON = M.ID_SAISON
    inner join EQUIPE E_V on E_V.ID_EQUIPE = M.ID_EQUIPE_V
    inner join EQUIPE E_R on E_R.ID_EQUIPE = M.ID_EQUIPE_R
    inner join CATEGORIE G on G.ID_CATEGORIE = E_V.ID_CATEGORIE
    inner join STADE ST on ST.ID_STADE = M.ID_STADE
    where M.ID_RENCONTRE = 1;


-- requete pour affichier l'entraineur d'une équipe donnée à une date donnée
-- (ici ID_EQUIPE = 13 and DATE = '2020-01-01')
select I.NOM_INDIVIDU NOM,PRENOM_INDIVIDU PRENOM, ADRESSE, E.NOM_EQUIPE NOM_EQUIPE, H.DATE_DEBUT DATE_DEBUT, H.DATE_FIN DATE_FIN
                from (INDIVIDU I inner join SPORTIF S on I.ID_INDIVIDU= S.ID_SPORTIF
                left join JOUEUR J on J.ID_JOUEUR = S.ID_SPORTIF  
                left outer join (select H.*
                                 from HISTORIQUE H
                                 where H.DATE_DEBUT <= '2020-01-01' and (H.DATE_FIN is null or H.DATE_FIN > '2020-01-01')) H on S.ID_SPORTIF = H.ID_SPORTIF) 
                left outer join EQUIPE E on E.ID_EQUIPE=H.ID_EQUIPE
                where J.ID_JOUEUR is null and H.ID_EQUIPE=13;


