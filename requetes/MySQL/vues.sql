-- ======================================
-- =========== DROP VIEWS ===============
-- ======================================

drop view if exists JOUEUR_EQUIPE_R_RENCONTRE;
drop view if exists JOUEUR_EQUIPE_V_RENCONTRE;
drop view if exists JOUEURS_MATCH;
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
drop view if exists EQUIPE_PAR_SAISON;
drop view if exists STATS_CLUBS;
drop view if exists BUTS_PAR_MATCH;
drop view if exists BUTS_RECUS_PAR_MATCH;
drop view if exists AVG_CURRENT;
drop view if exists NEG_CURRENT;
drop view if exists PLAYER_ACTUAL_TEAM;
drop view if exists ENTRAIN_ACTUAL_TEAM;
drop view if exists JOUEURS_PAR_SAISON;
drop view if exists PARTICIPATIONS_PAR_MATCH;
drop view if exists PARTICIPATIONS_PAR_SAISON;
drop view if exists CLASS_JOUEUR;

-- =========================================
-- =========== DROP TRIGGERS ===============
-- =========================================
drop trigger if exists BEFORE_INSERT_MATCH;
drop trigger if exists BEFORE_INSERT_PARTICIPATION;


-- ===========================================
-- =========== DROP PROCEDURES ===============
-- ===========================================
drop procedure if exists INSERER_HISTORIQUE;


-- =================================
-- =========== VIEWS ===============
-- =================================

-- =============================================================================
-- vue pour stocker les joueurs des équipes visiteuses par rencontre
-- =============================================================================
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


-- =================================================================================
-- vue pour stocker les joueurs des équipes qui reçoient (à domicile) par rencontre
-- =================================================================================
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


-- ================================================
-- vue pour stocker tout les joueurs par rencontre
-- ================================================
create view JOUEURS_MATCH as
select JOUEUR.ID_JOUEUR,NOM_POSTE, ifnull(NOMBRE_BUT,0) as NOMBRE_BUT, ifnull(NOMBRE_FAUTE,0)as NOMBRE_FAUTE,NOM_EQUIPE,ID_CATEGORIE,ID_PARTICIPATION,RENCONTRE.ID_RENCONTRE
from  JOUEUR 
inner join PARTICIPATION on PARTICIPATION.ID_JOUEUR=JOUEUR.ID_JOUEUR
inner join POSTE on PARTICIPATION.ID_POSTE=POSTE.ID_POSTE
inner join RENCONTRE on RENCONTRE.ID_RENCONTRE=PARTICIPATION.ID_RENCONTRE
inner join HISTORIQUE on HISTORIQUE.ID_SPORTIF=JOUEUR.ID_JOUEUR
inner join EQUIPE on HISTORIQUE.ID_EQUIPE=EQUIPE.ID_EQUIPE
where DATE_RENCONTRE > HISTORIQUE.DATE_DEBUT and (DATE_RENCONTRE < HISTORIQUE.DATE_FIN or HISTORIQUE.DATE_FIN is null)
order by NOMBRE_BUT  desc;

-- =============================================================================
-- vue pour stocker les buts marqués par les équipes visiteuses par rencontre
-- =============================================================================
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


-- =============================================================================
-- vue pour stocker les buts marqués par les équipes qui reçoient par rencontre
-- =============================================================================
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


-- =============================================================================
-- vue pour stocker tout les scores des matchs joués dans tous les saisons
-- =============================================================================
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


-- ====================================================================================
-- vues pour k le nombre des matchs gagnés par saison pour les équipes visiteuses
-- ====================================================================================
create view WIN_R as
select SAISON,
       EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.R
where SCOREHOME > SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         SAISON,
         EQUIPE.NOM_EQUIPE ;


-- ======================================================================================
-- vues pour stocker le nombre des matchs gagnés par saison pour les équipes qui reçoient
-- ======================================================================================
create view WIN_V as
select SAISON,
       EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.V
where SCOREHOME < SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         SAISON,
         EQUIPE.NOM_EQUIPE ;


-- ====================================================================================
-- vues pour stocker le nombre des matchs gagnés par saison pour tous les équipes
-- ====================================================================================
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
         SAISON,
         NOM_EQUIPE;


-- =======================================================================================
-- vues pour stocker le nombre des matchs perdus par saison pour les équipes qui reçoient
-- =======================================================================================
create view LOST_R as
select SAISON,
       EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.R
where SCOREHOME < SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         SAISON,
         EQUIPE.NOM_EQUIPE ;


-- ======================================================================================
-- vues pour stocker le nombre des matchs perdus par saison pour les équipes visiteuses
-- ======================================================================================
create view LOST_V as
select SAISON,
       EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.V
where SCOREHOME > SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         SAISON,
         EQUIPE.NOM_EQUIPE ;


-- ====================================================================================
-- vues pour stocker le nombre des matchs perdus par saison pour tous les équipes
-- ====================================================================================
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
         SAISON,
         NOM_EQUIPE;


-- ====================================================================================
-- vues pour stocker le nombre des matchs nuls par saison pour les équipes qui reçoient
-- ====================================================================================
create view DRAW_R as
select SAISON,
       EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.R
where SCOREHOME = SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         SAISON,
         EQUIPE.NOM_EQUIPE ;


-- ====================================================================================
-- vues pour stocker le nombre des matchs nuls par saison pour les équipes visiteuses
-- ====================================================================================
create view DRAW_V as
select SAISON,
       EQUIPE.ID_EQUIPE,
       EQUIPE.NOM_EQUIPE,
       IFNULL(COUNT(ID_EQUIPE), 0) as NB
from EQUIPE
inner join SCORE on EQUIPE.ID_EQUIPE = SCORE.V
where SCOREHOME = SCOREAWAY
group by EQUIPE.ID_EQUIPE,
         SAISON,
         EQUIPE.NOM_EQUIPE ;


-- ====================================================================================
-- vues pour stocker le nombre des matchs nuls par saison pour tous les équipes 
-- ====================================================================================
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
         SAISON,
         NOM_EQUIPE;


-- ==========================================
-- vues pour stocker les équipes par saison 
-- ==========================================
create view EQUIPE_PAR_SAISON as
select ID_SAISON, ID_EQUIPE, NOM_EQUIPE,ID_CATEGORIE, ID_CLUB
from EQUIPE,SAISON;

-- =============================================================
-- vues pour stocker les buts marqués par les équipes par match 
-- =============================================================
create view BUTS_PAR_MATCH as
select * from NB_BUT_RENCONTRE_V  union select * from NB_BUT_RENCONTRE_R;


-- =============================================================
-- vues pour stocker les buts reçus par les équipes par match 
-- =============================================================
create view BUTS_RECUS_PAR_MATCH as
 select RENCONTRE,R,HOME, sum(SCOREAWAY) as NB,SAISON
 from SCORE
 group by R,SAISON
 union
 select RENCONTRE, V,AWAY, sum(SCOREHOME), SAISON
 from SCORE
 group by V,SAISON ;

-- ==============================================================================================
-- vue pour stocker la moyenne des buts marqués par rencontre pour une equipe à la date actuelle
-- ==============================================================================================
create view AVG_CURRENT as
select  M,V,NOMEQUIPE as "NOM EQUIPE", sum(NB) as "SOMME_POINTS_MARQUES",avg(NB) as "MOYENNE_POINTS_MARQUES",SAISON
from BUTS_PAR_MATCH inner join RENCONTRE on ID_RENCONTRE=M
where DATE_RENCONTRE < CURRENT_DATE
group by V,SAISON;


-- ====================================================================================
-- vue pour la moyenne des buts reçus par rencontre pour une equipe à la date actuelle
-- ====================================================================================
create view NEG_CURRENT as
select RENCONTRE,R, -sum(NB) as neg,SAISON
from BUTS_RECUS_PAR_MATCH inner join RENCONTRE on ID_RENCONTRE=RENCONTRE
where DATE_RENCONTRE < CURRENT_DATE
group by R,SAISON;
-- ==================================================================
-- vue pour les statistiques generales des équipes par saisons
-- nombre de matchs gagnés/perdus/nuls, nombre de buts marqués/reçus
-- moyenne de buts marqués par rencontre par saison
-- ==================================================================
create view TABLE_S as
select E.ID_EQUIPE,
       E.NOM_EQUIPE,
       E.ID_CATEGORIE,
       E.ID_CLUB,
       IFNULL(WINS, 0) as WINS,
       IFNULL(DRAWS, 0) as DRAWS,
       IFNULL(LOSSES, 0) as LOSSES,
       (3*IFNULL(WINS, 0) + IFNULL(DRAWS, 0)) as SCORE,
       E.ID_SAISON,
       ifnull(SOMME_POINTS_MARQUES,0) as "SOMME_POINTS_MARQUES" ,
       ifnull(neg,0) as"SOMME_POINTS_RECUS",
       ifnull(SOMME_POINTS_MARQUES+neg,0) as DIFFERENCE,
       ifnull(MOYENNE_POINTS_MARQUES,0) as "MOYENNE_POINTS_MARQUES"


from EQUIPE_PAR_SAISON E
left outer join WINS on WINS.ID_EQUIPE = E.ID_EQUIPE and WINS.SAISON = E.ID_SAISON
left outer join DRAWS on DRAWS.ID_EQUIPE = E.ID_EQUIPE and DRAWS.SAISON = E.ID_SAISON
left outer join LOSS on LOSS.ID_EQUIPE = E.ID_EQUIPE and LOSS.SAISON = E.ID_SAISON
left outer join AVG_CURRENT A on E.ID_EQUIPE = V and E.ID_SAISON=A.SAISON
left outer join NEG_CURRENT N on E.ID_EQUIPE = N.R and E.ID_SAISON=N.SAISON;


-- ==================================================================
-- vue pour les statistiques generales des clubs par saisons
-- nombre de matchs gagnés/perdus/nuls
-- ==================================================================
create view STATS_CLUBS as
select CLUB.*,
       SUM(TABLE_S.WINS) as WINS,
       SUM(TABLE_S.DRAWS) as DRAWS,
       SUM(TABLE_S.LOSSES) as LOSSES,
       (3*SUM(TABLE_S.WINS) + SUM(TABLE_S.DRAWS)) as SCORE,
       TABLE_S.ID_SAISON
from TABLE_S inner join CLUB on TABLE_S.ID_CLUB = CLUB.ID_CLUB
group by ID_CLUB,TABLE_S.ID_SAISON;



-- ====================================================
-- vue pour stocker les equipes actuelles des joueurs
-- ====================================================
create view PLAYER_ACTUAL_TEAM as
select J.ID_JOUEUR ID_JOUEUR,  E.ID_EQUIPE ID_EQUIPE, E.NOM_EQUIPE NOM_EQUIPE, H.DATE_DEBUT DATE_DEBUT
                from (JOUEUR J
                left outer join (select H.*
                                 from HISTORIQUE H
                                 where H.DATE_DEBUT <= CURDATE() and H.DATE_FIN is null) H on J.ID_JOUEUR = H.ID_SPORTIF)
                left outer joiN EQUIPE E on E.ID_EQUIPE=H.ID_EQUIPE;


-- ====================================================
-- vue pour stocker les equipes actuelles des joueurs
-- ====================================================
create view ENTRAIN_ACTUAL_TEAM as
select S.ID_SPORTIF ID_ENTRAINEUR,  E.ID_EQUIPE ID_EQUIPE, E.NOM_EQUIPE NOM_EQUIPE, H.DATE_DEBUT DATE_DEBUT
                from (SPORTIF S
                left join JOUEUR J on J.ID_JOUEUR = S.ID_SPORTIF  
                left outer join (select H.*
                                 from HISTORIQUE H
                                 where H.DATE_DEBUT <= CURDATE() and H.DATE_FIN is null) H on S.ID_SPORTIF = H.ID_SPORTIF) 
                left outer join EQUIPE E on E.ID_EQUIPE=H.ID_EQUIPE
                where J.ID_JOUEUR is null;


-- ====================================================
-- vue pour stocker les joueurs par saison
-- ====================================================
create view JOUEURS_PAR_SAISON as
select ID_JOUEUR,ID_SAISON
from JOUEUR,SAISON;


-- ====================================================
-- vue pour stocker les participations par match
-- ====================================================
create view PARTICIPATIONS_PAR_MATCH as
select PARTICIPATION.*,ID_SAISON,DATE_RENCONTRE
from PARTICIPATION inner join RENCONTRE on RENCONTRE.ID_RENCONTRE=PARTICIPATION.ID_RENCONTRE;


-- ====================================================
-- vue pour stocker les participations par saison
-- ====================================================
create view PARTICIPATIONS_PAR_SAISON as
select JS.ID_JOUEUR,
       JS.ID_SAISON,
       ID_PARTICIPATION,
       NOMBRE_BUT,
       NOMBRE_FAUTE,
       PM.DATE_RENCONTRE
from JOUEURS_PAR_SAISON JS left join PARTICIPATIONS_PAR_MATCH PM on
JS.ID_JOUEUR=PM.ID_JOUEUR and JS.ID_SAISON=PM.ID_SAISON ;

-- ==================================================================
-- vue pour les statistiques generales des joueurs par saisons
-- nombre de buts marqués, nombre de fautes commises
-- moyenne de buts marqués par rencontre par saison
-- ==================================================================
create view CLASS_JOUEUR as
select PS.ID_JOUEUR ,CATEGORIE.ID_CATEGORIE, ifnull(sum(NOMBRE_BUT),0) as BUTS, ifnull(sum(NOMBRE_FAUTE),0) as FAUTE, ifnull(avg(NOMBRE_BUT),0) as 'MOYENNE_BUTS',PS.ID_SAISON
from PARTICIPATIONS_PAR_SAISON PS 
left join HISTORIQUE on PS.ID_JOUEUR=ID_SPORTIF
left join EQUIPE on HISTORIQUE.ID_EQUIPE = EQUIPE.ID_EQUIPE
left join CATEGORIE on CATEGORIE.ID_CATEGORIE=EQUIPE.ID_CATEGORIE
where DATE_RENCONTRE < CURRENT_DATE or DATE_RENCONTRE is null
group by ID_JOUEUR,ID_SAISON
order by BUTS desc ,PS.ID_SAISON desc;




-- ====================================
-- =========== TRIGGERS ===============
-- ====================================

-- ==========================================================================================
-- declencheur avant l'insertion d'une rencontre, il met en oeuvre les contraintes suivantes:
-- ** les equipes entrées dans une rencontre doivent etre differentes
-- ** la date de rencontre doit etre incluse dans la saison
-- ==========================================================================================

DELIMITER |
create trigger BEFORE_INSERT_MATCH before insert
on RENCONTRE for each row
begin
     if NEW.ID_EQUIPE_R = NEW.ID_EQUIPE_V 
      then     
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'ENTRER DEUX EQUIPES DIFFERENTES';
     end if;
     if NEW.DATE_RENCONTRE 
     not BETWEEN (select DATE_DEBUT
                       from  SAISON 
                     where ID_SAISON = NEW.ID_SAISON)
                    and 
                    ( select DATE_FIN
                       from  SAISON 
                     where ID_SAISON = NEW.ID_SAISON)           
      then
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'DATE DE RENCONTRE DOIT ETRE INCLUSE A LA SAISON';

     end if;
    
end |
DELIMITER ;


-- ==============================================================================================
-- declencheur avant l'insertion d'une participation, il met en oeuvre les contraintes suivantes:
-- ** on ne peut pas ajouter une participation d'un joueur qui ne joue pas dans une des équipes 
-- de la rencontre
-- ** on ne peut pas ajouter une participation d'un joueur plusieurs fois dans la meme rencontre
-- ==============================================================================================
DELIMITER |
create trigger BEFORE_INSERT_PARTICIPATION before insert
on PARTICIPATION for each row
begin
     if NEW.ID_JOUEUR 
      not in ( select JOUEUR.ID_JOUEUR
               from JOUEUR 
               inner join SPORTIF on JOUEUR.ID_JOUEUR=SPORTIF.ID_SPORTIF
               inner join HISTORIQUE on SPORTIF.ID_SPORTIF=HISTORIQUE.ID_SPORTIF
             	inner join PARTICIPATION on PARTICIPATION.ID_JOUEUR= HISTORIQUE.ID_SPORTIF
               inner join RENCONTRE on RENCONTRE.ID_RENCONTRE=PARTICIPATION.ID_RENCONTRE
               where (HISTORIQUE.ID_EQUIPE = RENCONTRE.ID_EQUIPE_R or HISTORIQUE.ID_EQUIPE = RENCONTRE.ID_EQUIPE_V)
and ( DATE_RENCONTRE > HISTORIQUE.DATE_DEBUT and (DATE_RENCONTRE < HISTORIQUE.DATE_FIN or HISTORIQUE.DATE_FIN is null )))
      then
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'JOUEUR N APPARTIENT A AUCUNE EQUIPE DE LA RENCONTRE';

     end if;

    select ID_JOUEUR, ID_RENCONTRE into @var1,@var2
    from PARTICIPATION
    where NEW.ID_JOUEUR = PARTICIPATION.ID_JOUEUR and NEW.ID_RENCONTRE=PARTICIPATION.ID_RENCONTRE;
    if @var1 is not null or @var2 is not null
      then
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'UN JOUEUR NE PEUX PAS EXISTER PLUSIEURS FOIS DANS LA MEME RENCONTRE';
    end if;
end
DELIMITER ;


-- ======================================
-- =========== PROCEDURES ===============
-- ======================================

DELIMITER |
create procedure INSERER_JOUEUR (in NOM char(30), in PRENOM char(30), in ADRESSE char(50), in NUMERO_LICENCE int, in DATE_NAISSANCE date)
begin
  start transaction;
    declare id int;

    insert into INDIVIDU (NOM_INDIVIDU, PRENOM_INDIVIDU, ADRESSE) 
     values(NOM, PRENOM, ADRESSE);

    set id = LAST_INSERT_ID();

    insert into SPORTIF (ID_SPORTIF) 
     values(id);

    insert into JOUEUR (ID_JOUEUR, NUMERO_LICENCE, DATE_NAISSANCE)
    values(id, NUMERO_LICENCE, DATE_NAISSANCE);
    
  commit;
end
DELIMITER ;

DELIMITER |
create procedure INSERER_ENTRAINEUR (in NOM char(30), in PRENOM char(30), in ADRESSE char(50))
begin
  start transaction;
    declare id int;

    insert into INDIVIDU (NOM_INDIVIDU, PRENOM_INDIVIDU, ADRESSE) 
     values(NOM, PRENOM, ADRESSE);

    set id = LAST_INSERT_ID();

    insert into SPORTIF (ID_SPORTIF) 
     values(id);
   
  commit;
end
DELIMITER ;

DELIMITER |
create procedure INSERER_PERSONNEL (in NOM char(30), in PRENOM char(30), in ADRESSE char(50), in CLUB int)
begin
  start transaction;
    declare id int;

    insert into INDIVIDU (NOM_INDIVIDU, PRENOM_INDIVIDU, ADRESSE) 
     values(NOM, PRENOM, ADRESSE);

    set id = LAST_INSERT_ID();

    insert into PERSONNEL (ID_PERSONNEL, ID_CLUB) 
     values(id, CLUB);
   
  commit;
end
DELIMITER ;

-- ========================================================
-- procedure stockée pour insérer un historique 
-- de telle façon à ce que la date de fin du contrat
-- du sportif dans son équipe précédente devient 
-- celle de début dans son contrat avec sa nouvelle équipe 
-- ========================================================

DELIMITER |
create procedure INSERER_HISTORIQUE (in ID_EQ INT, in ID_SP INT, in DATE_D DATE, in DATE_F DATE)
begin
set @old = (select DATE_FIN from historique where ID_SPORTIF=ID_SP and DATE_FIN is null);
update historique
set
HISTORIQUE.DATE_FIN = DATE_D
where ID_SPORTIF=ID_SP and @old is null;
insert into HISTORIQUE (ID_HISTORIQUE, ID_EQUIPE, ID_SPORTIF, DATE_DEBUT, DATE_FIN) 
values( null, ID_EQ ,ID_SP, DATE_D, DATE_F); 
end
DELIMITER ;