-- ============================================================
--    suppression des donnees
-- ============================================================

delete from CLUB ;
delete from CATEGORIE ;
delete from EQUIPE ;
delete from RENCONTRE ;
delete from SAISON ;
delete from STADE ;
delete from INDIVIDU ;
delete from PERSONNEL ;
delete from ROLE ;
delete from ROLE_PERSONNEL ;
delete from SPORTIF ;
delete from JOUEUR ;
delete from PARTICIPATION ;
delete from POSTE ;
delete from HISTORIQUE ;

commit ;

-- ============================================================
--    creation des donnees
-- ============================================================

-- CLUB
insert into CLUB (ID_CLUB, NOM_CLUB, DATE_CREATION)
values 
        (  1 , 'HBC BORDEAUX'           , 1986 ),
        (  2 , 'MONTPELLIER HANDBALL'   , 1982 ),
        (  3 , 'PSG HANDBALL'           , 1941 ),
        (  4 , 'MARSEILLE'              , 1961 ),
        (  5 , 'FENIX TOULOUSE'         , 1964 ),
        (  6 , 'HBC NANTES'             , 1953 );

commit ;

-- CATEGORIE
insert into CATEGORIE (ID_CATEGORIE, NOM_CATEGORIE, MIN_AGE, MAX_AGE, SEXE)
values 
        (  1 , 'EDH_M'       , 7  , 9  , 'MALE'   ),
        (  2 , 'POUSSINS_M'  , 10 , 11 , 'MALE'   ),
        (  3 , 'BENJAMINS_M' , 12 , 13 , 'MALE'   ),
        (  4 , 'MINIMES_M'   , 14 , 15 , 'MALE'   ),
        (  5 , 'CADETS_M'    , 16 , 17 , 'MALE'   ),
        (  6 , 'JUNIOR_M'    , 18 , 19 , 'MALE'   ),
        (  7 , 'SENIOR_M'    , 20 , null  , 'MALE'   ),
        (  8 , 'EDH_W'       , 7  , 9  , 'FEMALE' ), 
        (  9 , 'POUSSINS_W'  , 10 , 11 , 'FEMALE' ),
        (  10 , 'BENJAMINS_W' , 12 , 13 , 'FEMALE' ),
        (  11 , 'MINIMES_W'   , 14 , 15 , 'FEMALE' ),
        (  12 , 'CADETS_W'    , 16 , 17 , 'FEMALE' ),
        (  13 , 'JUNIOR_W'    , 18 , 19 , 'FEMALE' ),
        (  14 , 'SENIOR_W'    , 20 , null   , 'FEMALE' );

commit ;

-- EQUIPE
insert into EQUIPE (ID_EQUIPE, ID_CATEGORIE, ID_CLUB, NOM_EQUIPE)
values 
        (  1  , 1 , 1        , 'HBC BORDEAUX EDH'  ),
        (  2  , 8 , 1        , 'HBC BORDEAUX EDH'  ),
        (  3  , 2 , 1        , 'HBC BORDEAUX POUSSINS'  ),
        (  4  , 9 , 1        , 'HBC BORDEAUX POUSSINS'  ),
        (  5  , 3 , 1        , 'HBC BORDEAUX BENJAMINS'  ),
        (  6  , 10 , 1       , 'HBC BORDEAUX BENJAMINS'  ),
        (  7  , 4 , 1        , 'HBC BORDEAUX MINIMES'  ),
        (  8  , 11 , 1       , 'HBC BORDEAUX MINIMES'  ),
        (  9  , 5 , 1        , 'HBC BORDEAUX CADETS'  ),
        (  10  , 12 , 1       , 'HBC BORDEAUX CADETS'  ),
        (  11  , 6 , 1        , 'HBC BORDEAUX JUNIOR'  ),
        (  12 , 13 , 1       , 'HBC BORDEAUX JUNIOR'  ),
        (  13 , 7 , 1        , 'HBC BORDEAUX '  ),
        (  14 , 14 , 1       , 'HBC BORDEAUX '  ),

        (  15  , 1 , 2        , 'MONTPELLIER HANDBALL EDH'  ),
        (  16 , 8 , 2        , 'MONTPELLIER HANDBALL EDH'  ),
        (  17  , 2 , 2        , 'MONTPELLIER HANDBALL POUSSINS'  ),
        (  18 , 9 , 2        , 'MONTPELLIER HANDBALL POUSSINS'  ),
        (  19 , 3 , 2        , 'MONTPELLIER HANDBALL BENJAMINS'  ),
        (  20  , 10 , 2       , 'MONTPELLIER HANDBALL BENJAMINS'  ),
        (  21  , 4 , 2        , 'MONTPELLIER HANDBALL MINIMES'  ),
        (  22  , 11 , 2       , 'MONTPELLIER HANDBALL MINIMES'  ),
        (  23  , 5 , 2        , 'MONTPELLIER HANDBALL CADETS'  ),
        (  24  , 12 , 2       , 'MONTPELLIER HANDBALL CADETS'  ),
        (  25  , 6 , 2        , 'MONTPELLIER HANDBALL JUNIOR'  ),
        (  26 , 13 , 2       , 'MONTPELLIER HANDBALL JUNIOR'  ),
        (  27 , 7 , 2        , 'MONTPELLIER HANDBALL '  ),
        (  28 , 14 , 2       , 'MONTPELLIER HANDBALL '  ),

        (  29  , 1 , 3        , 'PSG HANDBALL EDH'  ),
        (  30  , 8 , 3        , 'PSG HANDBALL EDH'  ),
        (  31  , 2 , 3        , 'PSG HANDBALL POUSSINS'  ),
        (  32  , 9 , 3        , 'PSG HANDBALL POUSSINS'  ),
        (  33  , 3 , 3        , 'PSG HANDBALL BENJAMINS'  ),
        (  34  , 10 , 3       , 'PSG HANDBALL BENJAMINS'  ),
        (  35  , 4 , 3        , 'PSG HANDBALL MINIMES'  ),
        (  36  , 11 , 3       , 'PSG HANDBALL MINIMES'  ),
        (  37  , 5 , 3        , 'PSG HANDBALL CADETS'  ),
        (  38 , 12 , 3       , 'PSG HANDBALL CADETS'  ),
        (  39  , 6 , 3        , 'PSG HANDBALL JUNIOR'  ),
        (  40 , 13 , 3       , 'PSG HANDBALL JUNIOR'  ),
        (  41 , 7 , 3        , 'PSG HANDBALL  '  ),
        (  42 , 14 , 3       , 'PSG HANDBALL '  ),

        (  43  , 1 , 4        , 'MARSEILLE EDH'  ),
        (  44  , 8 , 4        , 'MARSEILLE EDH'  ),
        (  45  , 2 , 4        , 'MARSEILLE POUSSINS'  ),
        (  46  , 9 , 4        , 'MARSEILLE POUSSINS'  ),
        (  47  , 3 , 4        , 'MARSEILLE BENJAMINS'  ),
        (  48 , 10 , 4       , 'MARSEILLE BENJAMINS'  ),
        (  49  , 4 , 4        , 'MARSEILLE MINIMES'  ),
        (  50  , 11 , 4       , 'MARSEILLE MINIMES'  ),
        (  51  , 5 , 4        , 'MARSEILLE CADETS'  ),
        (  52  , 12 , 4       , 'MARSEILLE CADETS'  ),
        (  53  , 6 , 4        , 'MARSEILLE JUNIOR'  ),
        (  54 , 13 , 4       , 'MARSEILLE JUNIOR'  ),
        (  55 , 7 , 4        , 'MARSEILLE'  ),
        (  56 , 14 , 4       , 'MARSEILLE'  ),

        (  57  , 1 , 5        , 'FENIX TOULOUSE EDH'  ),
        (  58  , 8 , 5        , 'FENIX TOULOUSE EDH'  ),
        (  59  , 2 , 5        , 'FENIX TOULOUSE POUSSINS'  ),
        (  60  , 9 , 5        , 'FENIX TOULOUSE POUSSINS'  ),
        (  61  , 3 , 5        , 'FENIX TOULOUSE BENJAMINS'  ),
        (  62  , 10 , 5       , 'FENIX TOULOUSE BENJAMINS'  ),
        (  63  , 4 , 5        , 'FENIX TOULOUSE MINIMES'  ),
        (  64  , 11 , 5       , 'FENIX TOULOUSE MINIMES'  ),
        (  65  , 5 , 5        , 'FENIX TOULOUSE CADETS'  ),
        (  66  , 12 , 5       , 'FENIX TOULOUSE CADETS'  ),
        (  67  , 6 , 5        , 'FENIX TOULOUSE JUNIOR'  ),
        (  68 , 13 , 5       , 'FENIX TOULOUSE JUNIOR'  ),
        (  69 , 7 , 5        , 'FENIX TOULOUSE'  ),
        (  70 , 14 , 5       , 'FENIX TOULOUSE'  ),

        (  71  , 1 , 6        , 'HBC NANTES EDH'  ),
        (  72  , 8 , 6        , 'HBC NANTES EDH'  ),
        (  73  , 2 , 6        , 'HBC NANTES POUSSINS'  ),
        (  74  , 9 , 6        , 'HBC NANTES POUSSINS'  ),
        (  75  , 3 , 6        , 'HBC NANTES BENJAMINS'  ),
        (  76  , 10 , 6       , 'HBC NANTES BENJAMINS'  ),
        (  77  , 4 , 6        , 'HBC NANTES MINIMES'  ),
        (  78  , 11 , 6       , 'HBC NANTES MINIMES'  ),
        (  79  , 5 , 6        , 'HBC NANTES CADETS'  ),
        (  80  , 12 , 6       , 'HBC NANTES CADETS'  ),
        (  81 , 6 , 6        , 'HBC NANTES JUNIOR'  ),
        (  82 , 13 , 6       , 'HBC NANTES JUNIOR'  ),
        (  83 , 7 , 6        , 'HBC NANTES'  ),
        (  84 , 14 , 6       , 'HBC NANTES'  );

commit ;


-- SAISON
insert into SAISON (ID_SAISON, DATE_DEBUT, DATE_FIN)
values 
        (1 , '2020-01-01', '2021-01-01');

commit ;

-- STADE 
insert into STADE (ID_STADE, NOM_STADE, VILLE)
values 
        (1 , 'PARIS STADE', 'PARIS'),
        (2 , 'BORDEAUX STADE', 'BORDEAUX'),
        (3 , 'MARSEILLE STADE', 'MARSEILLE'),
        (4 , 'TOULOUSE STADE', 'TOULOUSE'),
        (5 , 'NANTES STADE', 'NANTES'),
        (6 , 'MONTPELLIER STADE', 'MONTPELLIER');


commit ;

-- RENCONTRE
insert into RENCONTRE (ID_RENCONTRE, ID_SAISON, ID_STADE, ID_EQUIPE_R, ID_EQUIPE_V, DATE_RENCONTRE)
values 
        (1 , 1 , 2, 13, 27, '2020-01-01'),
        (2 , 1 , 1, 41, 55, '2020-01-01'),
        (3 , 1 , 5, 69, 83, '2020-01-01'),
        (4 , 1 , 5 , 83, 13, '2020-01-08'),
        (5 , 1 , 6, 27, 55, '2020-01-08'),
        (6 , 1 , 4, 41, 69, '2020-01-08'),
        (7 , 1 , 2, 13, 69, '2020-01-15'),
        (8 , 1 , 1, 27, 41, '2020-01-15'),
        (9 , 1 , 3, 55, 83, '2020-01-15');

commit ;

-- INDIVIDU
insert into INDIVIDU (ID_INDIVIDU, NOM_INDIVIDU, PRENOM_INDIVIDU, ADRESSE)
values 
        (1,'BAHHOU','HOUSSAM','2 rue Francois Mitterand Paris 75000'),
        (2,'CHAGUER','REDA','20 Rue de Segur Bordeaux 33000'),
        (3,'BENMENDIL','HAMZA','3 rue Jean Jaures Bordeaux 33000'),
        (4,'BOULLIT','FAYCAL','5 rue Allemagne Toulouse'),
        (5,'OMARI','ISMAIL','34 rue belvedere Paris 75000'),
        (6,'TALBI','ANAS','5 avenue Neil Armstrong Merignac 33700'),
        (7,'KINI','WALID','12 Avenue des Pythagores Pessac 33600'),
        (8,'LAFFANI','YASSIR','14 rue des 03tyres bordeaux 33000'),
        (9,'BOUCHEMMAMA','HAITAM','55 avenue des cristalines Toulouse'),
        (10,'HAJBI','MOHAMED','13 rue des factures bordeaux 33000'),
        (11,'ZERRAD','ZAYD','29 rue des jolis Grenoble 38000'),
        (12,'ZOUBAIRI','SAAD','14 rue Italie pessac 33600'),
        (13,'03GOUM','SAAD','7 avenue de France Paris 75000'),
        (14,'AMGHAR','MOHAMED','87 place Espagne Barcelone'),
        (15,'BOUDALI','MOHAMED','25 Avenue Hamilcar Toulouse'),
        (16,'IZEKKI','JALAL','2 rue Francois Mitterand Paris 75000'),
        (17,'ABIDI','SAAD','20 Rue de Segur Bordeaux 33000'),
        (18,'MARKAZ','AHMED','3 rue Jean Jaures Bordeaux 33000'),
        (19,'HAMMADI','MOHCINE','5 rue Allemagne Toulouse'),
        (20,'MOUGOU','YASSINE','34 rue belvedere Paris 75000'),
        (21,'AGTAIB','BADR','5 avenue Neil Armstrong Merignac 33700'),
        (22,'LASRI','AYOUB','12 Avenue des Pythagores Pessac 33600'),
        (23,'DUPONT','PIERRE','14 rue des martyres bordeaux 33000'),
        (24,'DUPONT','FREDERIC','55 avenue des cristalines Toulouse'),
        (25,'ANDRE','HENRI','13 rue des factures bordeaux 33000'),
        (26,'LIONEL','MESSI','29 rue des jolis Grenoble 38000'),
        (27,'MBAPE','KILIEN','14 rue Italie pessac 33600'),
        (28,'LAMOUR','QUENTIN','7 avenue de France Paris 75000'),
        (29,'PIERRE','HUGO','87 place Espagne Barcelone'),
        (30,'LAMOUR','HUGO','25 Avenue Hamilcar Toulouse'),
        (31,'FAIZ','MEHDI','2 rue Francois Mitterand Paris 75000'),
        (32,'HALA','ALI','20 Rue de Segur Bordeaux 33000'),
        (33,'ISSAOUI','ALI','3 rue Jean Jaures Bordeaux 33000'),
        (34,'HALA','MEHDI','5 rue Allemagne Toulouse'),
        (35,'GOND','OLIVIER','34 rue belvedere Paris 75000'),
        (36,'GOND','DAVID','5 avenue Neil Armstrong Merignac 33700'),
        (37,'GOND','EMMANUEL','12 Avenue des Pythagores Pessac 33600'),
        (38,'MACRON','DAVID','14 rue des martyres bordeaux 33000'),
        (39,'MARTIN','PIERRE','55 avenue des cristalines Toulouse'),
        (40,'GATTI','ALEXIS','13 rue des factures bordeaux 33000'),
        (41,'SAVY','MAXIME','29 rue des jolis Grenoble 38000'),
        (42,'GIRARDET','FABIEN','14 rue Italie pessac 33600'),
        (43,'DUPUIS','JULIAN','7 avenue de France Paris 75000'),
        (44,'PRINGALLE','ANTOINE','87 place Espagne Barcelone'),
        (45,'NADIR','SOUHAIL','34 rue belvedere Paris 75000'),
        (46,'MICHAEL','CLEMENT','5 avenue Neil Armstrong Merignac 33700'),
        (47,'BARAK','OBAMA','12 Avenue des Pythagores Pessac 33600'),
        (48,'TRUMP','DONALD','14 rue des 03tyres bordeaux 33000'),
        (49,'BIDEN','FREDERIC','55 avenue des cristalines Toulouse'),
        (50,'BIDEN','JOE','13 rue des factures bordeaux 33000'),
        (51,'ROGER','FEDERER','29 rue des jolis Grenoble 38000'),
        (52,'RAPHAEL','NADAL','14 rue Italie pessac 33600'),
        (53,'NOVAK','DJOKOVIC','7 avenue de France Paris 75000'),
        (54,'ANDY','MURRAY','87 place Espagne Barcelone');

commit ;

-- PERSONNEL
insert into PERSONNEL (ID_PERSONNEL, ID_CLUB)
values 
        (1,1),
        (51,1),
        (43,1),
        (44,1),
        (2,2),
        (52,2),
        (33,2),
        (34,2),
        (3,3),
        (53,3),
        (23,3),
        (24,3),
        (4,4),
        (54,4),
        (13,4),
        (14,4),
        (5,5),
        (26,5),
        (15,5),
        (16,5),
        (9,6),
        (10,6),
        (17,6),
        (18,6);

commit;

-- ROLE
insert into ROLE (ID_ROLE, NOM_ROLE)
values 
        (1,'PRESIDENT'),
        (2,'VICE PRESIDENT'),
        (3,'SECRETAIRE'),
        (4,'TRESORIO');

commit;

-- ROLE_PERSONNEL
insert into ROLE_PERSONNEL (ID_PERSONNEL, ID_ROLE)
values 
        (1,1),
        (51,2),
        (43,3),
        (44,4),
        (2,1),
        (52,2),
        (33,3),
        (34,4),
        (3,1),
        (53,2),
        (23,3),
        (24,4),
        (4,1),
        (54,2),
        (13,3),
        (14,4),
        (5,1),
        (26,2),
        (15,3),
        (16,4),
        (9,1),
        (10,2),
        (17,3),
        (18,4);

commit;

-- SPORTIF
insert into SPORTIF (ID_SPORTIF)
values 
        (6),
        (7),
        (8),
        (11),
        (12),
        (19),
        (20),
        (21),
        (22),
        (25),
        (27),
        (28),
        (29),
        (30),
        (31),
        (32),
        (35),
        (36),
        (37),
        (38),
        (39),
        (40),
        (41),
        (42),
        (45),
        (46),
        (47),
        (48),
        (49),
        (50);

commit;

-- JOUEUR

insert into JOUEUR (ID_JOUEUR, NUMERO_LICENCE, DATE_NAISSANCE)
values 
        (7,1,'1990-01-15'),
        (8,2,'1991-04-13'),
        (11,3,'1994-05-25'),
        (12,4,'1997-12-20'),

        (20,1,'1999-04-29'),
        (21,2,'1996-01-31'),
        (22,3,'1992-03-15'),
        (25,4,'1993-06-19'),

        (28,1,'1995-01-24'),
        (29,2,'1997-11-15'),
        (30,3,'1997-12-20'),
        (31,4,'1992-01-15'),

        (35,1,'1998-05-10'),
        (36,2,'1998-07-08'),
        (37,3,'1996-01-01'),
        (38,4,'1994-10-11'),

        (40,1,'1996-08-05'),
        (41,2,'1999-02-02'),
        (42,3,'1999-11-27'),
        (45,4,'1993-04-17'),

        (47,1,'1998-01-12'),
        (48,2,'1997-02-19'),
        (49,3,'1995-12-17'),
        (50,4,'1999-02-02');

commit;

-- POSTE
insert into POSTE (ID_POSTE, NOM_POSTE)
values 
        (1,'AILIER'),
        (2,'AVANT CENTRE'),
        (3,'ARRIERE CENTRALE'),
        (4,'GARDIENT');

commit;

-- HISTORIQUE
insert into HISTORIQUE (ID_HISTORIQUE, ID_EQUIPE, ID_SPORTIF, DATE_DEBUT, DATE_FIN)
values 
        (1 , 13, 6 ,'2019-01-15', null),
        (2 , 13, 7 ,'2019-01-15', null),
        (3 , 13, 8 ,'2019-01-15', null),
        (4 , 13, 11,'2019-01-15', null),
        (5 , 13, 12,'2019-01-15', null),

        (6 , 27, 19,'2019-01-15', null),
        (7 , 27, 20,'2019-01-15', '2019-12-12'),
        (8 , 27, 21,'2019-01-15', null),
        (9 , 27, 22,'2019-01-15', null),
        (10 ,27, 25,'2019-01-15', null),

        (11 , 41, 27,'2019-01-15', null),
        (12 , 41, 28,'2019-01-15', null),
        (13 , 41, 29,'2019-01-15', null),
        (14 , 41, 30,'2019-01-15', null),
        (15 , 41, 31,'2019-01-15', null),

        (16 , 55, 32,'2019-01-15', null),
        (17 , 55, 35,'2019-01-15', null),
        (18 , 55, 36,'2019-01-15', null),
        (19 , 55, 37,'2019-01-15', null),
        (20 , 55, 38,'2019-01-15', null),

        (21 , 69, 39,'2019-01-15', null),
        (22 , 69, 40,'2019-01-15', '2019-12-12'),
        (23 , 69, 41,'2019-01-15', null),
        (24 , 69, 42,'2019-01-15', null),
        (25 , 69, 45,'2019-01-15', null),

        (26 , 83, 46,'2019-01-15', null),
        (27 , 83, 47,'2019-01-15', null),
        (28 , 83, 48,'2019-01-15', null),
        (29 , 83, 49,'2019-01-15', null),
        (30 , 83, 50,'2019-01-15', null);

commit;

-- PARTICIPATION

insert into PARTICIPATION (ID_PARTICIPATION, ID_JOUEUR, ID_POSTE, ID_RENCONTRE, NOMBRE_BUT, NOMBRE_FAUTE)
values
        (1, 8, 2, 1,5,0),
        (2, 11, 3, 1,6,1),
        (3, 12, 4, 1,0,0),

        (4, 21, 1, 1,4,1),
        (5, 22, 3, 1,7,2),
        (6, 25, 4, 1,0,0),

        (7, 29, 2, 2,7,0),
        (8, 30, 1, 2,10,0),
        (9, 31, 4, 2,0,0),

        (10, 36, 2, 2,0,2),
        (11, 37, 3, 2,0,0),
        (12, 38, 4, 2,0,0),

        (13, 41, 2,3,16,0),
        (14,42,1,3,0,0),
        (15,45,4,3,0,0),

        (16,48,1,3,5,0),
        (17,49,3,3,8,0),
        (18,50,4,3,0,0),

        (19,8,2,4,9,0),
        (20,11,3,4,0,0),
        (21,12,4,4,0,0),

        (22,21,1,5,7,1),
        (23,22,3,5,9,0),
        (24,25,4,5,0,0),

        (25,29,2,6,9,0),
        (26,30,1,6,10,0),
        (27,31,4,6,0,0),

        (28,36,2,5,6,0),
        (29,37,3,5,7,0),
        (30,38,4,5,0,0),

        (31,41,2,6,14,0),
        (32,42,1,6,7,0),
        (33,45,4,6,0,0),

        (34,48,1,4,9,0),
        (35,49,3,4,15,0),
        (36,50,4,4,0,0),

        (37,8,2,7,9,2),
        (38,11,3,7,12,0),
        (39,12,4,7,0,0),

        (40,21,1,15,0,0),
        (41,22,3,8,12,0),
        (42,25,4,8,0,0),

        (43,29,2,8,7,0),
        (44,30,1,8,6,0),
        (45,31,4,8,0,0),

        (46,36,2,9,7,0),
        (47,37,3,9,9,0),
        (48,38,4,9,0,0),

        (49,41,2,7,0,0),
        (50,42,1,7,12,0),
        (51,45,4,7,0,0),

        (52,48,1,9,12,0),
        (53,49,3,9,0,2),
        (54,50,4,9,0,0);

commit;





