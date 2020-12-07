-- ==============================================
-- ============== STATISTIQUES ==================
-- ==============================================


-- requete pour affichier la moyenne des points marqués par rencontre à une date donnée
-- (ici la date est'2020-01-08')
select DATE_RENCONTRE as 'DATE',
       ifnull(avg(SCOREHOME+SCOREAWAY),0) as 'MOYENNE DES POINTS MARQUES',
       LABEL SAISON
    from SCORE inner join rencontre on SCORE.RENCONTRE=RENCONTRE.ID_RENCONTRE
    inner join SAISON on SAISON.ID_SAISON=RENCONTRE.ID_SAISON
    where DATE_RENCONTRE = '2020-01-08';


-- meme requete qu'avant mais en affichiant la moyenne des points marqués par rencontre 
-- à toutes les dates qui existent
select DATE_RENCONTRE as 'DATE',
       ifnull(avg(SCOREHOME+SCOREAWAY),0) as 'MOYENNE DES POINTS MARQUES',
       LABEL SAISON
    from SCORE inner join rencontre on SCORE.RENCONTRE=RENCONTRE.ID_RENCONTRE
    right join SAISON on SAISON.ID_SAISON=RENCONTRE.ID_SAISON
    group by DATE_RENCONTRE ;


-- requete pour affichier la moyenne des points marqués depuis le début d'une saison donnée
-- (ici ID_SAISON =2)
select ifnull(avg(SCOREHOME+SCOREAWAY),0) as 'MOYENNE DES POINTS MARQUES',
       LABEL SAISON
    from SCORE inner join RENCONTRE on SCORE.RENCONTRE=RENCONTRE.ID_RENCONTRE
    inner join SAISON on SAISON.ID_SAISON=RENCONTRE.ID_SAISON
    where RENCONTRE.ID_SAISON =2;
    

-- meme requete qu'avant mais en affichiant la moyenne des points marqués depuis le début
-- de la saison pour toutes les saison qui existent
select ifnull(avg(SCOREHOME+SCOREAWAY),0) as 'MOYENNE DES POINTS MARQUES',
       LABEL SAISON
    from SCORE inner join RENCONTRE on SCORE.RENCONTRE=RENCONTRE.ID_RENCONTRE
    right join SAISON on SAISON.ID_SAISON=RENCONTRE.ID_SAISON
    group by RENCONTRE.ID_SAISON;


-- classement des meilleurs joueurs entre deux dates  pour une catégorie
-- ( ici date1 = '2020-01-01' et date2 = '2020-01-09' et ID_CATEGORIE = 7)
select I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM, 
       ifnull(SUM(JM.NOMBRE_BUT),0) BUTS, ifnull(SUM(JM.NOMBRE_FAUTE),0) FAUTES, 
       JM.NOM_EQUIPE EQUIPE
    from JOUEURS_MATCH JM inner join INDIVIDU I on JM.ID_JOUEUR = I.ID_INDIVIDU
    inner join RENCONTRE R on JM.ID_RENCONTRE = R.ID_RENCONTRE
    where DATE_RENCONTRE between '2020-01-01' and '2020-01-09' 
    and JM.ID_CATEGORIE=7
    group by I.ID_INDIVIDU
    order by BUTS desc;


-- requete pour le classement de tous les équipes dans tous les catégories
-- et toutes les saisons
select  RANK() OVER(
            order by SUM(SCORE) desc) RANG,
        TS.ID_EQUIPE,
        TS.NOM_EQUIPE as NOM,
        C.NOM_CLUB,
        G.NOM_CATEGORIE,
        SUM(WINS) as WINS,
        SUM(DRAWS) as DRAWS,
        SUM(LOSSES) as LOSSES,
        SUM(SCORE) as SCORE,
        SUM(SOMME_POINTS_MARQUES) as BUTS_M, 
        SUM(SOMME_POINTS_RECUS) as BUTS_R,
        SUM(DIFFERENCE) as DIFFERENCE
    from TABLE_S TS 
    inner join CATEGORIE G on TS.ID_CATEGORIE=G.ID_CATEGORIE
    inner join CLUB C on TS.ID_CLUB = C.ID_CLUB
    group by TS.ID_EQUIPE;


-- requete pour le classement de tous les équipes d'une catégorie
-- donnée pour une saison donnée (ici ID_CATEGORIE= 7 and ID_SAISON=2)
select  RANK() OVER(
            order by SCORE desc) RANG,
        TS.ID_EQUIPE,
        TS.NOM_EQUIPE as NOM,
        C.NOM_CLUB,
        G.NOM_CATEGORIE,
        WINS,DRAWS,LOSSES,SCORE,
        SOMME_POINTS_MARQUES as BUTS_M, 
        SOMME_POINTS_RECUS as BUTS_R,
        DIFFERENCE, 
        MOYENNE_POINTS_MARQUES as MOYENNE,
        LABEL SAISON
    from TABLE_S TS 
    inner join CATEGORIE G on TS.ID_CATEGORIE=G.ID_CATEGORIE
    inner join CLUB C on TS.ID_CLUB = C.ID_CLUB
    left join SAISON on TS.ID_SAISON=SAISON.ID_SAISON
    where TS.ID_SAISON = 2 and TS.ID_CATEGORIE = 7 
    group by TS.ID_EQUIPE;


-- requete pour le classement de tous les joueurs dans tous les catégories
-- et toutes les saisons
select  RANK() OVER(
            order by BUTS desc) RANG,
    CJ.ID_JOUEUR,
    I.NOM_INDIVIDU as NOM,
    I.PRENOM_INDIVIDU as PRENOM,
    C.NOM_CATEGORIE,
    ifnull(SUM(BUTS),0) as BUTS, 
    ifnull(SUM(FAUTE),0) as FAUTES
    from CLASS_JOUEUR CJ inner join INDIVIDU I on CJ.ID_JOUEUR = I.ID_INDIVIDU
    inner join CATEGORIE C on CJ.ID_CATEGORIE = C.ID_CATEGORIE
    group by CJ.ID_JOUEUR;


-- requete pour le classement de tous les joueurs d'une catégorie
-- donnée pour une saison donnée (ici ID_CATEGORIE= 7 and ID_SAISON=2)
select  RANK() OVER(
            order by BUTS desc) RANG,
        CJ.ID_JOUEUR,
        I.NOM_INDIVIDU as NOM,
        I.PRENOM_INDIVIDU as PRENOM,
        ifnull(SUM(BUTS),0) as BUTS, 
        ifnull(SUM(FAUTE),0) as FAUTES, 
        ifnull(avg(NULLIF(`MOYENNE_BUTS`,0)),0) as MOYENNE,
        LABEL SAISON
    from CLASS_JOUEUR CJ inner join INDIVIDU I on CJ.ID_JOUEUR = I.ID_INDIVIDU
    left join SAISON on CJ.ID_SAISON=SAISON.ID_SAISON
    where CJ.ID_SAISON = 2 and CJ.ID_CATEGORIE = 7 
    group by CJ.ID_JOUEUR;


-- requete pour le classement de tous les clubs dans toutes les saisons
select ROW_NUMBER() OVER(
        order by (3*IFNULL(SUM(WINS), 0) + IFNULL(SUM(DRAWS), 0)) desc ) RANG ,
    CLUB.ID_CLUB ID,
    CLUB.NOM_CLUB NOM,
    IFNULL(SUM(STATS_CLUBS.WINS), 0) WINS,
    IFNULL(SUM(STATS_CLUBS.DRAWS), 0) DRAWS,
    IFNULL(SUM(STATS_CLUBS.LOSSES), 0) LOSSES,
    (3*IFNULL(SUM(WINS), 0) + IFNULL(SUM(DRAWS), 0)) as SCORE
    from STATS_CLUBS right outer join CLUB on STATS_CLUBS.ID_CLUB = CLUB.ID_CLUB
    group by STATS_CLUBS.ID_CLUB;


-- requete pour le classement de tous les clubs dans une saison donnée (ici ID_SAISON=2)
select ROW_NUMBER() OVER(
        order by (3*IFNULL(SUM(WINS), 0) + IFNULL(SUM(DRAWS), 0)) desc ) RANG ,
    CLUB.ID_CLUB ID,
    CLUB.NOM_CLUB NOM,
    IFNULL(SUM(STATS_CLUBS.WINS), 0) WINS,
    IFNULL(SUM(STATS_CLUBS.DRAWS), 0) DRAWS,
    IFNULL(SUM(STATS_CLUBS.LOSSES), 0) LOSSES,
    (3*IFNULL(SUM(WINS), 0) + IFNULL(SUM(DRAWS), 0)) as SCORE,
    LABEL SAISON
    from STATS_CLUBS right outer join CLUB on STATS_CLUBS.ID_CLUB = CLUB.ID_CLUB
    left join SAISON on STATS_CLUBS.ID_SAISON=SAISON.ID_SAISON
    where STATS_CLUBS.ID_SAISON = 2
    group by STATS_CLUBS.ID_CLUB;
