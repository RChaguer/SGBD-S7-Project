drop view if exists JOUEUR_EQUIPE_R_RENCONTRE;
drop view if exists JOUEUR_EQUIPE_V_RENCONTRE;
drop view if exists NB_BUT_RENCONTRE_V;
drop view if exists NB_BUT_RENCONTRE_R;
drop view if exists SCORE;
drop view if exists WIN_R;
drop view if exists WIN_V;
drop view if exists WINS;
drop view if exists LOST_R;
drop view if exists LOST_V;
drop view if exists LOSS;
drop view if exists DRAW_R;
drop view if exists DRAW_V;
drop view if exists DRAWS;
drop view if exists TABLE_S;
drop view if exists `RANK`;
drop view if exists CLUBS;
drop view if exists WINSC;
drop view if exists LOSSC;
drop view if exists DRAWSC;
drop view if exists TABLE_CATEG;
drop view if exists RANK_CATEG;
drop view if exists EQUIPE_R;
drop view if exists EQUIPE_V;
drop view if exists FEUILLE_RENCONTRE;
drop view if exists RANK_CLUB;


create view JOUEUR_EQUIPE_V_RENCONTRE as
select distinct HISTORIQUE.ID_SPORTIF,
                HISTORIQUE.ID_EQUIPE,
                EQUIPE.NOM_EQUIPE,
                RENCONTRE.ID_RENCONTRE
from HISTORIQUE
inner join RENCONTRE on HISTORIQUE.ID_EQUIPE = RENCONTRE.ID_EQUIPE_V
inner join PARTICIPATION on PARTICIPATION.ID_JOUEUR= HISTORIQUE.ID_SPORTIF
inner join EQUIPE on HISTORIQUE.ID_EQUIPE = EQUIPE.ID_EQUIPE
where (RENCONTRE.DATE_RENCONTRE > HISTORIQUE.DATE_DEBUT
       and (HISTORIQUE.DATE_FIN is null
            or RENCONTRE.DATE_RENCONTRE < HISTORIQUE.DATE_FIN))
order by RENCONTRE.ID_RENCONTRE;


create view JOUEUR_EQUIPE_R_RENCONTRE as
select distinct HISTORIQUE.ID_SPORTIF,
                HISTORIQUE.ID_EQUIPE,
                EQUIPE.NOM_EQUIPE,
                RENCONTRE.ID_RENCONTRE
from HISTORIQUE
inner join RENCONTRE on HISTORIQUE.ID_EQUIPE = RENCONTRE.ID_EQUIPE_R
inner join PARTICIPATION on PARTICIPATION.ID_JOUEUR= HISTORIQUE.ID_SPORTIF
inner join EQUIPE on HISTORIQUE.ID_EQUIPE = EQUIPE.ID_EQUIPE
where (RENCONTRE.DATE_RENCONTRE > HISTORIQUE.DATE_DEBUT
       and (HISTORIQUE.DATE_FIN is null
            or RENCONTRE.DATE_RENCONTRE < HISTORIQUE.DATE_FIN))
order by RENCONTRE.ID_RENCONTRE;

drop view NB_BUT_RENCONTRE_V;
create view NB_BUT_RENCONTRE_V as
select JOUEUR_EQUIPE_V_RENCONTRE.ID_RENCONTRE as M,
       JOUEUR_EQUIPE_V_RENCONTRE.ID_EQUIPE as V,
       JOUEUR_EQUIPE_V_RENCONTRE.NOM_EQUIPE as NOMEQUIPE,
       IFNULL(SUM(PARTICIPATION.NOMBRE_BUT), 0) as NB,
       RENCONTRE.ID_SAISON as SAISON
from JOUEUR_EQUIPE_V_RENCONTRE
inner join PARTICIPATION on (PARTICIPATION.ID_RENCONTRE=JOUEUR_EQUIPE_V_RENCONTRE.ID_RENCONTRE
                             and JOUEUR_EQUIPE_V_RENCONTRE.ID_SPORTIF = PARTICIPATION.ID_JOUEUR)
inner join RENCONTRE on RENCONTRE.ID_RENCONTRE= JOUEUR_EQUIPE_V_RENCONTRE.ID_RENCONTRE
group by JOUEUR_EQUIPE_V_RENCONTRE.ID_RENCONTRE,
         JOUEUR_EQUIPE_V_RENCONTRE.ID_EQUIPE,
         JOUEUR_EQUIPE_V_RENCONTRE.NOM_EQUIPE
order by M;


drop view NB_BUT_RENCONTRE_R;
create view NB_BUT_RENCONTRE_R as
select JOUEUR_EQUIPE_R_RENCONTRE.ID_RENCONTRE as M,
       JOUEUR_EQUIPE_R_RENCONTRE.ID_EQUIPE as R,
       JOUEUR_EQUIPE_R_RENCONTRE.NOM_EQUIPE as NOMEQUIPE,
       IFNULL(SUM(PARTICIPATION.NOMBRE_BUT), 0) as NB,
       RENCONTRE.ID_SAISON as SAISON
from JOUEUR_EQUIPE_R_RENCONTRE
inner join PARTICIPATION on (PARTICIPATION.ID_RENCONTRE=JOUEUR_EQUIPE_R_RENCONTRE.ID_RENCONTRE
                             and JOUEUR_EQUIPE_R_RENCONTRE.ID_SPORTIF = PARTICIPATION.ID_JOUEUR)
inner join RENCONTRE on RENCONTRE.ID_RENCONTRE = JOUEUR_EQUIPE_R_RENCONTRE.ID_RENCONTRE
group by JOUEUR_EQUIPE_R_RENCONTRE.ID_RENCONTRE,
         JOUEUR_EQUIPE_R_RENCONTRE.ID_EQUIPE,
         JOUEUR_EQUIPE_R_RENCONTRE.NOM_EQUIPE
order by M;


-- vue pour tt les scores
create view SCORE as
select NB_BUT_RENCONTRE_R.R as R,
       NB_BUT_RENCONTRE_R.NOMEQUIPE as HOME,
       NB_BUT_RENCONTRE_R.NB as SCOREHOME,
       NB_BUT_RENCONTRE_V.NB as SCOREAWAY,
       NB_BUT_RENCONTRE_V.NOMEQUIPE as AWAY,
       NB_BUT_RENCONTRE_V.V as V,
       NB_BUT_RENCONTRE_V.M as RENCONTRE,
       NB_BUT_RENCONTRE_R.SAISON as SAISON
from NB_BUT_RENCONTRE_V
inner join NB_BUT_RENCONTRE_R on NB_BUT_RENCONTRE_V.M = NB_BUT_RENCONTRE_R.M;

-- requete pour les scores à une saison donnée
select score.* from score
where SAISON=1;

-- vue pour les scores à une date donnée
select score.* from score
inner join RENCONTRE on score.RENCONTRE=ID_RENCONTRE
where RENCONTRE.DATE_RENCONTRE = 'date';

-- requete pour classer les meilleur buteurs en une journée  --
(select JOUEUR_EQUIPE_V_RENCONTRE.ID_SPORTIF as ID,
        JOUEUR_EQUIPE_V_RENCONTRE.ID_EQUIPE,
        IFNULL(SUM(PARTICIPATION.NOMBRE_BUT), 0) as NB
from JOUEUR_EQUIPE_V_RENCONTRE
inner join PARTICIPATION on (PARTICIPATION.ID_RENCONTRE=JOUEUR_EQUIPE_V_RENCONTRE.ID_RENCONTRE
                             and JOUEUR_EQUIPE_V_RENCONTRE.ID_SPORTIF = PARTICIPATION.ID_JOUEUR)
inner join RENCONTRE on RENCONTRE.ID_RENCONTRE= JOUEUR_EQUIPE_V_RENCONTRE.ID_RENCONTRE
inner join EQUIPE on EQUIPE.ID_EQUIPE = JOUEUR_EQUIPE_V_RENCONTRE.ID_EQUIPE
where RENCONTRE.DATE_RENCONTRE = '2020-01-01'
group by ID, EQUIPE.ID_EQUIPE
order by NB DESC)
union
(select JOUEUR_EQUIPE_R_RENCONTRE.ID_SPORTIF as ID,
       JOUEUR_EQUIPE_R_RENCONTRE.ID_EQUIPE,    
       IFNULL(SUM(PARTICIPATION.NOMBRE_BUT), 0) as NB
from JOUEUR_EQUIPE_R_RENCONTRE
inner join PARTICIPATION on (PARTICIPATION.ID_RENCONTRE=JOUEUR_EQUIPE_R_RENCONTRE.ID_RENCONTRE
                             and JOUEUR_EQUIPE_R_RENCONTRE.ID_SPORTIF = PARTICIPATION.ID_JOUEUR)
inner join RENCONTRE on RENCONTRE.ID_RENCONTRE= JOUEUR_EQUIPE_R_RENCONTRE.ID_RENCONTRE
inner join EQUIPE on EQUIPE.ID_EQUIPE = JOUEUR_EQUIPE_R_RENCONTRE.ID_EQUIPE
where RENCONTRE.DATE_RENCONTRE = '2020-01-01'
group by ID, EQUIPE.ID_EQUIPE
order by NB DESC);


create view WIN_R as
select SAISON,
       EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.R
where SCOREHOME > SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         EQUIPE.NOM_EQUIPE ;

create view WIN_V as
select SAISON,
       EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.V
where SCOREHOME < SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         EQUIPE.NOM_EQUIPE ;


create view WINS as
select SAISON,
       ID_EQUIPE,
       NOM_EQUIPE,
       IFNULL(SUM(NB), 0) as WINS
from
    (select *
     from WIN_R
     union all select *
     from WIN_V) W
group by ID_EQUIPE,
         NOM_EQUIPE;

create view LOST_R as
select SAISON,
       EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.R
where SCOREHOME < SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         EQUIPE.NOM_EQUIPE ;

create view LOST_V as
select SAISON,
       EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.V
where SCOREHOME > SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         EQUIPE.NOM_EQUIPE ;

create view LOSS as
select SAISON,
       ID_EQUIPE,
       NOM_EQUIPE,
       IFNULL(SUM(NB), 0) as LOSSES
from
    (select *
     from LOST_R
     union all select *
     from LOST_V) L
group by ID_EQUIPE,
         NOM_EQUIPE;

create view DRAW_R as
select SAISON,
       EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.R
where SCOREHOME = SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         EQUIPE.NOM_EQUIPE ;

create view DRAW_V as
select SAISON,
       EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.V
where SCOREHOME = SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         EQUIPE.NOM_EQUIPE ;

drop view DRAWS;
create view DRAWS as
select SAISON,
       ID_EQUIPE,
       NOM_EQUIPE,
       IFNULL(SUM(NB), 0) as DRAWS
from
    (select *
     from DRAW_R
     union all select *
     from DRAW_V) D
group by ID_EQUIPE,
         NOM_EQUIPE;

drop view if exists trash3;
create view trash3 as
select DRAWS.ID_EQUIPE, DRAWS.SAISON from DRAWS
 union
select WINS.ID_EQUIPE, WINS.SAISON from WINS
 union
select LOSS.ID_EQUIPE, LOSS.SAISON from LOSS ;

drop view if exists trash4;
create view trash4 as
select ID_SAISON, ID_EQUIPE, NOM_EQUIPE,ID_CATEGORIE, ID_CLUB
from EQUIPE,SAISON;





-- vue pour classement general dans tous les saisons
drop view if exists TABLE_S;
create view TABLE_S as
select  RANK() OVER(
                   order by (3*IFNULL(WINS, 0) + IFNULL(DRAWS, 0)) desc) R,
       trash4.ID_EQUIPE,
       trash4.NOM_EQUIPE,
       trash4.ID_CATEGORIE,
       trash4.ID_CLUB,
       IFNULL(WINS, 0) as WINS,
       IFNULL(DRAWS, 0) as DRAWS,
       IFNULL(LOSSES, 0) as LOSSES,
       (3*IFNULL(WINS, 0) + IFNULL(DRAWS, 0)) as SCORE,
       trash4.ID_SAISON

from trash4
left outer join WINS on WINS.ID_EQUIPE = trash4.ID_EQUIPE and wins.SAISON = trash4.ID_SAISON
left outer join DRAWS on DRAWS.ID_EQUIPE = trash4.ID_EQUIPE and draws.SAISON = trash4.ID_SAISON
left outer join LOSS on LOSS.ID_EQUIPE = trash4.ID_EQUIPE and loss.SAISON = trash4.ID_SAISON


-- requete classement des equipes pour une categ donnée et une saison donnée
select R as RANG, NOM_EQUIPE, WINS, LOSSES, DRAWS ,SCORE
from TABLE_S
where ID_CATEGORIE=5 and ID_SAISON=2;




-- requete rank equipes par club
create view RANK_CLUB as
select CLUB.*,
       SUM(TABLE_S.WINS) as WINS,
       SUM(TABLE_S.DRAWS) as DRAWS,
       SUM(TABLE_S.LOSSES) as LOSSES,
       (3*SUM(TABLE_S.WINS) + SUM(TABLE_S.DRAWS)) as SCORE
from TABLE_S inner join CLUB on TABLE_S.ID_CLUB = CLUB.ID_CLUB
group by ID_CLUB
order by SCORE desc, WINS desc, DRAWS desc, LOSSES;

-- requete des clubs classés par leurs résultats
create view CLUBS as
select ROW_NUMBER() OVER(
     order by SCORE desc ) RANG ,
          RANK_CLUB.NOM_CLUB,
          RANK_CLUB.WINS,
          RANK_CLUB.DRAWS,
          RANK_CLUB.LOSS
from RANK_CLUB;


-- requete affichage liste des équipes par club
select E.NOM_EQUIPE as 'NOM EQUIPE', C.NOM_CLUB as CLUB, G.NOM_CATEGORIE as CAT
            from (EQUIPE E inner join CLUB C on E.ID_CLUB = C.ID_CLUB)
            inner join CATEGORIE G on G.ID_CATEGORIE = E.ID_CATEGORIE
            where C.ID_CLUB=1;

-- modifier un individu --
update INDIVIDU
set NOM_INDIVIDU = 'ANTOINE'
where ID_INDIVIDU = 2;

-- Ajouter un individu --
insert into INDIVIDU (ID_INDIVIDU, NOM_INDIVIDU, ADRESSE) values (55,'MARADONA','DIEGO','5 Avenue Pablo BUENOS AIRES');

-- suppression individu --
delete from INDIVIDU
where ID_INDIVIDU = 7;

-- ajouter un club --
insert into CLUB (ID_CLUB, NOM_CLUB, DATE_CREATION) values ( 7  , 'Reims HANDBALL'   , 1942 );

-- modifier un club
update CLUB
set DATE_CREATION = 'xxxxx', NOM_CLUB = 'xxxxx'
where ID_CLUB = 1;

-- suppression club
delete from CLUB
where ID_CLUB = 7;

-- ajouter une rencontre --
insert into RENCONTRE (ID_RENCONTRE, ID_SAISON, ID_STADE, ID_EQUIPE_R, ID_EQUIPE_V, DATE_RENCONTRE) values (10 , 1 , 3, 41, 83, '18-JAN-2020');

-- modifier une rencontre --
update RENCONTRE set RENCONTRE.ID_SAISON = 1 where RENCONTRE.ID_RENCONTRE = 3;

-- supression rencontre --
delete from RENCONTRE
where ID_RENCONTRE = 4;


-- requete pour affichier la liste des joueur a la date actuelle
select JOUEUR.NUMERO_LICENCE as 'Numéro licence',
       INDIVIDU.NOM_INDIVIDU as 'Nom',
       INDIVIDU.PRENOM_INDIVIDU as 'Prénom',
       INDIVIDU.ADRESSE as 'Adresse',
       JOUEUR.DATE_NAISSANCE as 'Date de naissance',
       HISTORIQUE.DATE_DEBUT as 'Date début contrat',
       HISTORIQUE.DATE_FIN as 'Date fin contrat'
from JOUEUR inner join INDIVIDU on JOUEUR.ID_JOUEUR = INDIVIDU.ID_INDIVIDU
inner join SPORTIF on INDIVIDU.ID_INDIVIDU=SPORTIF.ID_SPORTIF
inner join HISTORIQUE on SPORTIF.ID_SPORTIF=HISTORIQUE.ID_SPORTIF
where HISTORIQUE.ID_EQUIPE = 13
and ( CURRENT_DATE > HISTORIQUE.DATE_DEBUT and (CURRENT_DATE < HISTORIQUE.DATE_FIN or HISTORIQUE.DATE_FIN is null ));


-- requete pour affichier la liste des joueur a une date donnée
select JOUEUR.NUMERO_LICENCE as 'Numéro licence',
       INDIVIDU.NOM_INDIVIDU as 'Nom',
       INDIVIDU.PRENOM_INDIVIDU as 'Prénom',
       INDIVIDU.ADRESSE as 'Adresse',
       JOUEUR.DATE_NAISSANCE as 'Date de naissance',
       HISTORIQUE.DATE_DEBUT as 'Date début contrat',
       HISTORIQUE.DATE_FIN as 'Date fin contrat'
from JOUEUR inner join INDIVIDU on JOUEUR.ID_JOUEUR = INDIVIDU.ID_INDIVIDU
inner join SPORTIF on INDIVIDU.ID_INDIVIDU=SPORTIF.ID_SPORTIF
inner join HISTORIQUE on SPORTIF.ID_SPORTIF=HISTORIQUE.ID_SPORTIF
where HISTORIQUE.ID_EQUIPE = 13
and ( 'date' > HISTORIQUE.DATE_DEBUT and 'date' < HISTORIQUE.DATE_FIN );


-- requetes stats==========================

-- vue trash
drop view if exists trash;
create view trash as
select * from NB_BUT_RENCONTRE_V  union select * from NB_BUT_RENCONTRE_R

 -- vue trash2
drop view if exists trash2;
create view trash2 as
 select RENCONTRE,R,HOME, sum(SCOREAWAY) as NB,SAISON
 from SCORE
 group by R
 union
 select RENCONTRE, V,AWAY, sum(SCOREHOME), SAISON
 from SCORE
 group by V  ;


-- vue pour la moyenne des pts marqués par rencontre pour une equipe a une date donnée
drop view if exists avg_date
create view avg_date as
select M,V,NOMEQUIPE as "NOM EQUIPE", sum(NB) as "SOMME POINTS MARQUES", avg(NB) as "MOYENNE POINTS MARQUES", SAISON
from trash inner join rencontre on ID_RENCONTRE=M
where DATE_RENCONTRE < 'date'
group by V,SAISON;


-- vue pour la moyenne des pts reçus  par rencontre pour une equipe a une date donnée
drop view if exists neg_date;
create view neg_date as
select RENCONTRE,R, -sum(NB) as neg,SAISON
from trash2 inner join rencontre on ID_RENCONTRE=RENCONTRE
where DATE_RENCONTRE < 'date'
group by R,SAISON;


-- vue pour la moyenne des pts marqués par rencontre pour une equipe au current date
drop view id exists avg_current;
create view avg_current as
select  M,V,NOMEQUIPE as "NOM EQUIPE", sum(NB) as "SOMME_POINTS_MARQUES",avg(NB) as "MOYENNE_POINTS_MARQUES",SAISON
from trash inner join rencontre on ID_RENCONTRE=M
where DATE_RENCONTRE < CURRENT_DATE
group by V,SAISON;



-- vue pour la moyenne des pts reçus par rencontre pour une equipe au current date
drop view  if exists neg_current;
create view neg_current as
select RENCONTRE,R, -sum(NB) as neg,SAISON
from trash2 inner join rencontre on ID_RENCONTRE=RENCONTRE
where DATE_RENCONTRE < CURRENT_DATE
group by R,SAISON;



-- requete final pour rank/categ
select NOM_EQUIPE ,WINS,DRAWS,LOSSES,SCORE,ifnull(SOMME_POINTS_MARQUES,0) as "SOMME POINTS MARQUES" ,ifnull(neg,0) as"SOMME POINTS RECUS",ifnull(SOMME_POINTS_MARQUES+neg,0) as DIFFERENCE, ifnull(MOYENNE_POINTS_MARQUES,0) as "MOYENNE POINTS MARQUES"
 from TABLE_S left outer join avg_current
 on ID_EQUIPE = V and TABLE_S.ID_SAISON=avg_current.SAISON
 left outer join neg_current on V=neg_current.R and TABLE_S.ID_SAISON=neg_current.SAISON
 where table_s.ID_SAISON=2, where teble_s.ID_CATEGORIE=7
 order by SCORE desc

-- requete match joués par une équipe
 select M, NOMEQUIPE as "NOM EQUIPE", NB
 from trash
 where ID_EQUIPE =1;


-- requete l'equipe actuelle des joueurs
create view PLAYER_ACTUAL_TEAM as
select J.ID_JOUEUR ID_JOUEUR,  E.ID_EQUIPE ID_EQUIPE, E.NOM_EQUIPE NOM_EQUIPE, H.DATE_DEBUT DATE_DEBUT
                from (JOUEUR J
                left outer join (select H.*
                                 from HISTORIQUE H
                                 where H.DATE_DEBUT <= CURDATE() and H.DATE_FIN is null) H on J.ID_JOUEUR = H.ID_SPORTIF)
                left outer joiN EQUIPE E on E.ID_EQUIPE=H.ID_EQUIPE;

create view ENTRAIN_ACTUAL_TEAM as
select S.ID_SPORTIF ID_ENTRAINEUR,  E.ID_EQUIPE ID_EQUIPE, E.NOM_EQUIPE NOM_EQUIPE, H.DATE_DEBUT DATE_DEBUT
                from (SPORTIF S
                left join JOUEUR J on J.ID_JOUEUR = S.ID_SPORTIF  
                left outer join (select H.*
                                 from HISTORIQUE H
                                 where H.DATE_DEBUT <= CURDATE() and H.DATE_FIN is null) H on J.ID_JOUEUR = H.ID_SPORTIF) 
                left outer join EQUIPE E on E.ID_EQUIPE=H.ID_EQUIPE
                where J.ID_JOUEUR is null;
