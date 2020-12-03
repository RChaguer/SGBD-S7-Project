-- ============================================================
--   Nom de la base   :  HANDBALL                                
--   Nom de SGBD      :  MySQL                    
--   Date de creation :  30/10/96  12:09                       
-- ============================================================

SET FOREIGN_KEY_CHECKS=0;
drop table if exists CLUB  ;

drop table if exists CATEGORIE;

drop table if exists EQUIPE;

drop table if exists RENCONTRE;

drop table if exists SAISON;

drop table if exists STADE;

drop table if exists INDIVIDU;

drop table if exists PERSONNEL;

drop table if exists ROLE;

drop table if exists ROLE_PERSONNEL;

drop table if exists SPORTIF;

drop table if exists JOUEUR;

drop table if exists PARTICIPATION;

drop table if exists POSTE;

drop table if exists HISTORIQUE;

SET FOREIGN_KEY_CHECKS=1;
-- ============================================================
--   Table : CLUB                                            
-- ============================================================

create table CLUB
(
    ID_CLUB             INT             not null  auto_increment,
    NOM_CLUB            CHAR(30)        not null,
    DATE_CREATION       INT                     ,
    constraint pk_club primary key (ID_CLUB)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ============================================================
--   Table : CATEGORIE                                            
-- ============================================================

create table CATEGORIE
(
    ID_CATEGORIE         INT             not null auto_increment,
    NOM_CATEGORIE        CHAR(30)        not null,
    MIN_AGE              INT                     ,
    MAX_AGE              INT                     ,
    SEXE                 CHAR(10)                ,
    constraint pk_categorie primary key (ID_CATEGORIE)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ============================================================
--   Table : EQUIPE                                         
-- ============================================================

create table EQUIPE
(
    ID_EQUIPE             INT           not null  auto_increment,
    ID_CATEGORIE          INT           not null,
    ID_CLUB               INT           not null,
    NOM_EQUIPE            CHAR(30)      not null,
    constraint pk_equipe primary key (ID_EQUIPE)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ============================================================
--   Table : SAISON
-- ============================================================

create table SAISON
(
    ID_SAISON             INT           not null   auto_increment,
    DATE_DEBUT            DATE                  ,
    DATE_FIN              DATE                  ,
    LABEL                 CHAR(20)            , 
    constraint pk_saison primary key (ID_SAISON)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ============================================================
--   Table : STADE
-- ============================================================

create table STADE
(
    ID_STADE             INT           not null   auto_increment,
    NOM_STADE            CHAR(30)      not null,
    VILLE                CHAR(30)              ,
    constraint pk_stade primary key (ID_STADE)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- ============================================================
--   Table : RENCONTRE                                         
-- ============================================================

create table RENCONTRE
(
    ID_RENCONTRE              INT           not null   auto_increment,
    ID_SAISON             INT           not null,
    ID_STADE              INT           not null,
    ID_EQUIPE_R           INT           not null,
    ID_EQUIPE_V           INT           not null,
    DATE_RENCONTRE            DATE                        ,
    constraint pk_RENCONTRE primary key (ID_RENCONTRE)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- ============================================================
--   Table : INDIVIDU
-- ============================================================

create table INDIVIDU
(
    ID_INDIVIDU           INT           not null   auto_increment,
    NOM_INDIVIDU          CHAR(30)      not null,
    PRENOM_INDIVIDU       CHAR(30)              ,
    ADRESSE               CHAR(50)              ,
    constraint pk_individu primary key (ID_INDIVIDU)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ============================================================
--   Table : PERSONNEL
-- ===========================================================

create table PERSONNEL
(
    ID_PERSONNEL           INT           not null ,
    ID_CLUB                INT           not null,
    constraint pk_personnel primary key (ID_PERSONNEL)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ============================================================
--   Table : ROLE
-- ===========================================================

create table ROLE
(
    ID_ROLE                 INT           not null   auto_increment,
    NOM_ROLE                CHAR(30)      not null,
    constraint pk_role primary key (ID_ROLE)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ============================================================
--   Table : ROLE_PERSONNEL
-- ===========================================================

create table ROLE_PERSONNEL
(
    ID_PERSONNEL             INT           not null,
    ID_ROLE                  INT           not null,
    constraint pk_role_personnel primary key (ID_PERSONNEL,ID_ROLE)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ============================================================
--   Table : SPORTIF
-- ===========================================================

create table SPORTIF
(
    ID_SPORTIF                INT           not null,
    constraint pk_spotif primary key (ID_SPORTIF)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ============================================================
--   Table : JOUEUR
-- ===========================================================

create table JOUEUR
(
    ID_JOUEUR                INT           not null,
    NUMERO_LICENCE           INT           not null,
    DATE_NAISSANCE           DATE                        ,   
    constraint pk_joueur primary key (ID_JOUEUR)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- ============================================================
--   Table : PARTICIPATION
-- ===========================================================

create table PARTICIPATION
(
    ID_PARTICIPATION         INT           not null auto_increment,
    ID_JOUEUR                INT           not null,
    ID_POSTE                 INT           not null,
    ID_RENCONTRE                 INT           not null,
    NOMBRE_BUT               INT                   ,
    NOMBRE_FAUTE             INT                   ,
    constraint pk_participation primary key (ID_PARTICIPATION)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ============================================================
--   Table : POSTE
-- ===========================================================

create table POSTE
(
    ID_POSTE                  INT           not null  auto_increment,
    NOM_POSTE                 CHAR(30)      not null,
    constraint pk_poste primary key (ID_POSTE)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ============================================================
--   Table : HISTORIQUE
-- ===========================================================

create table HISTORIQUE
(
    ID_HISTORIQUE             INT           not null  auto_increment,
    ID_EQUIPE                 INT           not null,
    ID_SPORTIF                INT           not null,
    DATE_DEBUT                DATE                  ,
    DATE_FIN                  DATE                  ,          
    constraint pk_historique primary key (ID_HISTORIQUE)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

alter table EQUIPE
    add constraint fk1_equipe foreign key (ID_CATEGORIE)
        references  CATEGORIE (ID_CATEGORIE)
        on delete cascade
        on update cascade;

alter table EQUIPE
    add constraint fk2_equipe foreign key (ID_CLUB)
        references  CLUB (ID_CLUB)
        on delete cascade
        on update cascade;

alter table RENCONTRE
    add constraint fk1_saison foreign key (ID_SAISON)
        references  SAISON (ID_SAISON)
        on delete cascade
        on update cascade;

alter table RENCONTRE
    add constraint fk2_stade foreign key (ID_STADE)
        references  STADE (ID_STADE)
        on delete cascade
        on update cascade;

alter table RENCONTRE
    add constraint fk3_equipe foreign key (ID_EQUIPE_R)
        references  EQUIPE (ID_EQUIPE)
        on delete cascade
        on update cascade;

alter table RENCONTRE
    add constraint fk4_equipe foreign key (ID_EQUIPE_V)
        references  EQUIPE (ID_EQUIPE)
        on delete cascade
        on update cascade;

alter table PERSONNEL
    add constraint fk1_personnel foreign key (ID_PERSONNEL)
        references  INDIVIDU (ID_INDIVIDU)
        on delete cascade
        on update cascade;

alter table PERSONNEL
    add constraint fk2_personnel foreign key (ID_CLUB)
        references  CLUB (ID_CLUB)
        on delete cascade
        on update cascade;

alter table ROLE_PERSONNEL
    add constraint fk1_role_personnel foreign key (ID_PERSONNEL)
        references  PERSONNEL (ID_PERSONNEL)
        on delete cascade
        on update cascade;

alter table ROLE_PERSONNEL
    add constraint fk2_role_personnel foreign key (ID_ROLE)
        references  ROLE (ID_ROLE)
        on delete cascade
        on update cascade;

alter table SPORTIF
    add constraint fk1_sportif  foreign key (ID_SPORTIF)
        references INDIVIDU (ID_INDIVIDU)
        on delete cascade
        on update cascade;

alter table JOUEUR
    add constraint fk1_joueur foreign key (ID_JOUEUR)
        references SPORTIF (ID_SPORTIF)
        on delete cascade
        on update cascade;



alter table PARTICIPATION
    add constraint fk1_participation foreign key (ID_JOUEUR)
        references JOUEUR  (ID_JOUEUR)
        on delete cascade
        on update cascade;

alter table PARTICIPATION
    add constraint fk2_participation foreign key (ID_POSTE)
        references POSTE  (ID_POSTE)
        on delete cascade
        on update cascade;

alter table PARTICIPATION
    add constraint fk3_participation foreign key (ID_RENCONTRE)
        references RENCONTRE  (ID_RENCONTRE)
        on delete cascade
        on update cascade;


alter table HISTORIQUE
    add constraint fk1_historique foreign key (ID_EQUIPE)
        references EQUIPE  (ID_EQUIPE)
        on delete cascade
        on update cascade;

alter table HISTORIQUE
    add constraint fk2_historique foreign key (ID_SPORTIF)
        references SPORTIF  (ID_SPORTIF)
        on delete cascade
        on update cascade;