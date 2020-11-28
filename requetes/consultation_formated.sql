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
drop view if exists WINSC;
drop view if exists LOSSC;
drop view if exists DRAWSC;
drop view if exists TABLE_CATEG;
drop view if exists RANK_CATEG;
drop view if exists EQUIPE_R;
drop view if exists EQUIPE_V;
drop view if exists FEUILLE_RENCONTRE;


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


create view NB_BUT_RENCONTRE_V as
select JOUEUR_EQUIPE_V_RENCONTRE.ID_RENCONTRE as M,
       JOUEUR_EQUIPE_V_RENCONTRE.ID_EQUIPE as V,
       JOUEUR_EQUIPE_V_RENCONTRE.NOM_EQUIPE as NOMEQUIPE,
       IFNULL(SUM(PARTICIPATION.NOMBRE_BUT), 0) as NB
from JOUEUR_EQUIPE_V_RENCONTRE
inner join PARTICIPATION on (PARTICIPATION.ID_RENCONTRE=JOUEUR_EQUIPE_V_RENCONTRE.ID_RENCONTRE
                             and JOUEUR_EQUIPE_V_RENCONTRE.ID_SPORTIF = PARTICIPATION.ID_JOUEUR)
group by JOUEUR_EQUIPE_V_RENCONTRE.ID_RENCONTRE,
         JOUEUR_EQUIPE_V_RENCONTRE.ID_EQUIPE,
         JOUEUR_EQUIPE_V_RENCONTRE.NOM_EQUIPE
order by M;


create view NB_BUT_RENCONTRE_R as
select JOUEUR_EQUIPE_R_RENCONTRE.ID_RENCONTRE as M,
       JOUEUR_EQUIPE_R_RENCONTRE.ID_EQUIPE as R,
       JOUEUR_EQUIPE_R_RENCONTRE.NOM_EQUIPE as NOMEQUIPE,
       IFNULL(SUM(PARTICIPATION.NOMBRE_BUT), 0) as NB
from JOUEUR_EQUIPE_R_RENCONTRE
inner join PARTICIPATION on (PARTICIPATION.ID_RENCONTRE=JOUEUR_EQUIPE_R_RENCONTRE.ID_RENCONTRE
                             and JOUEUR_EQUIPE_R_RENCONTRE.ID_SPORTIF = PARTICIPATION.ID_JOUEUR)
group by JOUEUR_EQUIPE_R_RENCONTRE.ID_RENCONTRE,
         JOUEUR_EQUIPE_R_RENCONTRE.ID_EQUIPE,
         JOUEUR_EQUIPE_R_RENCONTRE.NOM_EQUIPE
order by M;


create view SCORE as
select NB_BUT_RENCONTRE_R.R as R,
       NB_BUT_RENCONTRE_R.NOMEQUIPE as HOME,
       NB_BUT_RENCONTRE_R.NB as SCOREHOME,
       NB_BUT_RENCONTRE_V.NB as SCOREAWAY,
       NB_BUT_RENCONTRE_V.NOMEQUIPE as AWAY,
       NB_BUT_RENCONTRE_V.V as V,
       NB_BUT_RENCONTRE_V.M as RENCONTRE
from NB_BUT_RENCONTRE_V
inner join NB_BUT_RENCONTRE_R on NB_BUT_RENCONTRE_V.M = NB_BUT_RENCONTRE_R.M;


create view WIN_R as
select EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.R
where SCOREHOME > SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         EQUIPE.NOM_EQUIPE ;


create view WIN_V as
select EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.V
where SCOREHOME < SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         EQUIPE.NOM_EQUIPE ;


create view WINS as
select ID_EQUIPE,
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
select EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.R
where SCOREHOME < SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         EQUIPE.NOM_EQUIPE ;


create view LOST_V as
select EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.V
where SCOREHOME > SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         EQUIPE.NOM_EQUIPE ;


create view LOSS as
select ID_EQUIPE,
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
select EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.R
where SCOREHOME = SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         EQUIPE.NOM_EQUIPE ;


create view DRAW_V as
select EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.V
where SCOREHOME = SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         EQUIPE.NOM_EQUIPE ;


create view DRAWS as
select ID_EQUIPE,
       NOM_EQUIPE,
       IFNULL(SUM(NB), 0) as DRAWS
from
    (select *
     from DRAW_R
     union all select *
     from DRAW_V) D
group by ID_EQUIPE,
         NOM_EQUIPE;


create view TABLE_S as
select EQUIPE.*,
       IFNULL(WINS, 0) as WINS,
       IFNULL(DRAWS, 0) as DRAWS,
       IFNULL(LOSSES, 0) as LOSSES,
       (3*IFNULL(WINS, 0) + IFNULL(DRAWS, 0)) as SCORE
from EQUIPE
left join WINS on WINS.ID_EQUIPE = EQUIPE.ID_EQUIPE
left outer join DRAWS on DRAWS.ID_EQUIPE = EQUIPE.ID_EQUIPE
left outer join LOSS on LOSS.ID_EQUIPE = EQUIPE.ID_EQUIPE;


create view `RANK` as
select RANK() OVER(
                   order by SCORE desc) R,
              TABLE_S.*
from TABLE_S
where ID_CATEGORIE = 7;

-- requete rank equipes pour une categorie
create view RANK_CATEG as
select TABLE_S.*
from TABLE_S
where ID_CATEGORIE = 7
order by SCORE desc, WINS desc, DRAWS desc, LOSSES;

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

-- requete l'equipe actuelle des joueurs
create view PLAYER_ACTUAL_TEAM as
select J.ID_JOUEUR ID_JOUEUR,  E.ID_EQUIPE ID_EQUIPE, E.NOM_EQUIPE NOM_EQUIPE, H.DATE_DEBUT DATE_DEBUT
                from (JOUEUR J  
                left outer join (select H.*
                                 from HISTORIQUE H
                                 where H.DATE_DEBUT <= CURDATE() and H.DATE_FIN is null) H on J.ID_JOUEUR = H.ID_SPORTIF) 
                left outer joiN EQUIPE E on E.ID_EQUIPE=H.ID_EQUIPE;