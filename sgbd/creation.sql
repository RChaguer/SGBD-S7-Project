-- ============================================================
--   Nom de la base   :  HANDBALL                                
--   Nom de SGBD      :  ORACLE Version 7.0                    
--   Date de creation :  30/10/96  12:09                       
-- ============================================================

drop table CLUB cascade constraints;

drop table CATEGORIE cascade constraints;

drop table EQUIPE cascade constraints;

drop table MATCH cascade constraints;

drop table SAISON cascade constraints;

drop table STADE cascade constraints;

drop table INDIVIDU cascade constraints;

drop table PERSONNEL cascade constraints;

drop table ROLE cascade constraints;

drop table ROLE_PERSONNEL cascade constraints;

drop table SPORTIF cascade constraints;

drop table JOUEUR cascade constraints;

drop table PARTICIPATION cascade constraints;

drop table POSTE cascade constraints;

drop table HISTORIQUE cascade constraints;
-- ============================================================
--   Table : CLUB                                            
-- ============================================================

CREATE TABLE CLUB
(
    ID_CLUB             NUMBER(3)           not null,
    NOM_CLUB            CHAR(20)            not null,
    DATE_CREATION       NUMBER(5)                   ,
    constraint pk_club primary key (ID_CLUB)
);

-- ============================================================
--   Table : CATEGORIE                                            
-- ============================================================

CREATE TABLE CATEGORIE
(
    ID_CATEGORIE         NUMBER(3)           not null,
    NOM_CATEGORIE        CHAR(20)            not null,
    MIN_AGE              NUMBER(3)                   ,
    MAX_AGE              NUMBER(3)                   ,
    SEXE                 CHAR(20)                    ,
    constraint pk_categorie primary key (ID_CATEGORIE)
);

-- ============================================================
--   Table : EQUIPE                                         
-- ============================================================

CREATE TABLE EQUIPE
(
    ID_EQUIPE             NUMBER(3)           not null,
    ID_CATEGORIE          NUMBER(3)           not null,
    ID_CLUB               NUMBER(3)           not null,
    NOM_EQUIPE            CHAR(30)            not null,
    constraint pk_equipe primary key (ID_EQUIPE)
);

-- ============================================================
--   Table : SAISON
-- ============================================================

CREATE TABLE SAISON
(
    ID_SAISON             NUMBER(3)           not null,
    DATE_DEBUT            DATE                        ,
    DATE_FIN              DATE                        ,
    constraint pk_saison primary key (ID_SAISON)
);

-- ============================================================
--   Table : STADE
-- ============================================================

CREATE TABLE STADE
(
    ID_STADE             NUMBER(3)           not null,
    NOM_STADE            CHAR(20)            not null,
    VILLE                CHAR(20)                    ,
    constraint pk_stade primary key (ID_STADE)
);
-- ============================================================
--   Table : MATCH                                         
-- ============================================================

CREATE TABLE MATCH
(
    ID_MATCH              NUMBER(3)           not null,
    ID_SAISON             NUMBER(3)           not null,
    ID_STADE              NUMBER(3)           not null,
    ID_EQUIPE_R           NUMBER(3)           not null,
    ID_EQUIPE_V           NUMBER(3)           not null,
    DATE_MATCH            DATE                        ,
    constraint pk_match primary key (ID_MATCH)
);


-- ============================================================
--   Table : INDIVIDU
-- ============================================================

CREATE TABLE INDIVIDU
(
    ID_INDIVIDU           NUMBER(3)           not null,
    NOM_INDIVIDU          CHAR(20)            not null,
    PRENOM_INDIVIDU       CHAR(20)                    ,
    ADRESSE               CHAR(50)                    ,
    constraint pk_individu primary key (ID_INDIVIDU)
);

-- ============================================================
--   Table : PERSONNEL
-- ===========================================================

CREATE TABLE PERSONNEL
(
    ID_PERSONNEL           NUMBER(3)           not null,
    ID_CLUB                NUMBER(3)           not null,
    constraint pk_personnel primary key (ID_PERSONNEL)
);

-- ============================================================
--   Table : ROLE
-- ===========================================================

CREATE TABLE ROLE
(
    ID_ROLE                 NUMBER(3)           not null,
    NOM_ROLE                CHAR(20)            not null,
    constraint pk_role primary key (ID_ROLE)
);

-- ============================================================
--   Table : ROLE_PERSONNEL
-- ===========================================================

CREATE TABLE ROLE_PERSONNEL
(
    ID_PERSONNEL             NUMBER(3)           not null,
    ID_ROLE                  NUMBER(3)           not null,
    constraint pk_role_personnel primary key (ID_PERSONNEL,ID_ROLE)
);

-- ============================================================
--   Table : SPORTIF
-- ===========================================================

CREATE TABLE SPORTIF
(
    ID_SPORTIF                NUMBER(3)           not null,
    constraint pk_spotif primary key (ID_SPORTIF)
);

-- ============================================================
--   Table : JOUEUR
-- ===========================================================

CREATE TABLE JOUEUR
(
    ID_JOUEUR                NUMBER(3)           not null,
    NUMERO_LICENCE           NUMBER(3)           not null,
    DATE_NAISSANCE           DATE                        ,   
    constraint pk_joueur primary key (ID_JOUEUR)
);


-- ============================================================
--   Table : PARTICIPATION
-- ===========================================================

CREATE TABLE PARTICIPATION
(
    ID_PARTICIPATION         NUMBER(3)           not null,
    ID_JOUEUR                NUMBER(3)           not null,
    ID_POSTE                 NUMBER(3)           not null,
    ID_MATCH                 NUMBER(3)           not null,
    NOMBRE_BUT               NUMBER(3)                   ,
    NOMBRE_FAUTE             NUMBER(3)                   ,
    constraint pk_participation primary key (ID_PARTICIPATION)
);

-- ============================================================
--   Table : POSTE
-- ===========================================================

CREATE TABLE POSTE
(
    ID_POSTE                  NUMBER(3)           not null,
    NOM_POSTE                 CHAR(20)            not null,
    constraint pk_poste primary key (ID_POSTE)
);



-- ============================================================
--   Table : HISTORIQUE
-- ===========================================================

CREATE TABLE HISTORIQUE
(
    ID_HISTORIQUE             NUMBER(3)           not null,
    ID_EQUIPE                 NUMBER(3)           not null,
    ID_SPORTIF                NUMBER(3)           not null,
    DATE_DEBUT                DATE                        ,
    DATE_FIN                  DATE                        ,          
    constraint pk_historique primary key (ID_HISTORIQUE)
);

alter table EQUIPE
    add constraint fk1_equipe foreign key (ID_CATEGORIE)
        references  CATEGORIE (ID_CATEGORIE);

alter table EQUIPE
    add constraint fk2_equipe foreign key (ID_CLUB)
        references  CLUB (ID_CLUB);

alter table MATCH
    add constraint fk1_saison foreign key (ID_SAISON)
        references  SAISON (ID_SAISON);

alter table MATCH
    add constraint fk2_stade foreign key (ID_STADE)
        references  STADE (ID_STADE);

alter table MATCH
    add constraint fk3_equipe foreign key (ID_EQUIPE_R)
        references  EQUIPE (ID_EQUIPE);

alter table MATCH
    add constraint fk4_equipe foreign key (ID_EQUIPE_V)
        references  EQUIPE (ID_EQUIPE);

alter table PERSONNEL
    add constraint fk1_personnel foreign key (ID_PERSONNEL)
        references  INDIVIDU (ID_INDIVIDU);

alter table PERSONNEL
    add constraint fk2_personnel foreign key (ID_CLUB)
        references  CLUB (ID_CLUB);

alter table ROLE_PERSONNEL
    add constraint fk1_role_personnel foreign key (ID_PERSONNEL)
        references  PERSONNEL (ID_PERSONNEL);

alter table ROLE_PERSONNEL
    add constraint fk2_role_personnel foreign key (ID_ROLE)
        references  ROLE (ID_ROLE);

alter table SPORTIF
    add constraint fk1_sportif  foreign key (ID_SPORTIF)
        references INDIVIDU (ID_INDIVIDU);

alter table JOUEUR
    add constraint fk1_joueur foreign key (ID_JOUEUR)
        references SPORTIF (ID_SPORTIF);



alter table PARTICIPATION
    add constraint fk1_participation foreign key (ID_JOUEUR)
        references JOUEUR  (ID_JOUEUR);

alter table PARTICIPATION
    add constraint fk2_participation foreign key (ID_POSTE)
        references POSTE  (ID_POSTE);

alter table PARTICIPATION
    add constraint fk3_participation foreign key (ID_MATCH)
        references MATCH  (ID_MATCH);


alter table HISTORIQUE
    add constraint fk1_historique foreign key (ID_EQUIPE)
        references EQUIPE  (ID_EQUIPE);

alter table HISTORIQUE
    add constraint fk2_historique foreign key (ID_SPORTIF)
        references SPORTIF  (ID_SPORTIF);