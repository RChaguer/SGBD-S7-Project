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
delete from FAUTE ;
delete from BUT ;
delete from HISTORIQUE ;

commit ;

-- ============================================================
--    creation des donnees
-- ============================================================

-- CLUB

insert into CLUB values (  1 , 'HBC BORDEAUX'           , 1986 ) ;
insert into CLUB values (  2 , 'MONTPELLIER HANDBALL'   , 1982 ) ;
insert into CLUB values (  3 , 'PSG HANDBALL'           , 1941 ) ;
insert into CLUB values (  4 , 'MARSEILLE'              , 1961 ) ;
insert into CLUB values (  5 , 'FENIX TOULOUSE'         , 1964 ) ;
insert into CLUB values (  6 , 'HBC NANTES'             , 1953 ) ;

commit ;

-- CATEGORIE

insert into CATEGORIE values (  1 , 'EDH_M'       , 7  , 9  , 'MALE'   ) ;
insert into CATEGORIE values (  2 , 'POUSSINS_M'  , 10 , 11 , 'MALE'   ) ;
insert into CATEGORIE values (  3 , 'BENJAMINS_M' , 12 , 13 , 'MALE'   ) ;
insert into CATEGORIE values (  4 , 'MINIMES_M'   , 14 , 15 , 'MALE'   ) ;
insert into CATEGORIE values (  5 , 'CADETS_M'    , 16 , 17 , 'MALE'   ) ;
insert into CATEGORIE values (  6 , 'JUNIOR_M'    , 18 , 19 , 'MALE'   ) ;
insert into CATEGORIE values (  7 , 'SENIOR_M'    , 20 , null  , 'MALE'   ) ;
insert into CATEGORIE values (  8 , 'EDH_W'       , 7  , 9  , 'FEMALE' ) ; 
insert into CATEGORIE values (  9 , 'POUSSINS_W'  , 10 , 11 , 'FEMALE' ) ;
insert into CATEGORIE values (  10 , 'BENJAMINS_W' , 12 , 13 , 'FEMALE' ) ;
insert into CATEGORIE values (  11 , 'MINIMES_W'   , 14 , 15 , 'FEMALE' ) ;
insert into CATEGORIE values (  12 , 'CADETS_W'    , 16 , 17 , 'FEMALE' ) ;
insert into CATEGORIE values (  13 , 'JUNIOR_W'    , 18 , 19 , 'FEMALE' ) ;
insert into CATEGORIE values (  14 , 'SENIOR_W'    , 20 , null   , 'FEMALE' ) ;

commit ;

-- EQUIPE

insert into EQUIPE values (  1  , 1 , 1        , 'HBC BORDEAUX EDH'  ) ;
insert into EQUIPE values (  2  , 8 , 1        , 'HBC BORDEAUX EDH'  ) ;
insert into EQUIPE values (  3  , 2 , 1        , 'HBC BORDEAUX POUSSINS'  ) ;
insert into EQUIPE values (  4  , 9 , 1        , 'HBC BORDEAUX POUSSINS'  ) ;
insert into EQUIPE values (  5  , 3 , 1        , 'HBC BORDEAUX BENJAMINS'  ) ;
insert into EQUIPE values (  6  , 10 , 1       , 'HBC BORDEAUX BENJAMINS'  ) ;
insert into EQUIPE values (  7  , 4 , 1        , 'HBC BORDEAUX MINIMES'  ) ;
insert into EQUIPE values (  8  , 11 , 1       , 'HBC BORDEAUX MINIMES'  ) ;
insert into EQUIPE values (  9  , 5 , 1        , 'HBC BORDEAUX CADETS'  ) ;
insert into EQUIPE values (  10  , 12 , 1       , 'HBC BORDEAUX CADETS'  ) ;
insert into EQUIPE values (  11  , 6 , 1        , 'HBC BORDEAUX JUNIOR'  ) ;
insert into EQUIPE values (  12 , 13 , 1       , 'HBC BORDEAUX JUNIOR'  ) ;
insert into EQUIPE values (  13 , 7 , 1        , 'HBC BORDEAUX '  ) ;
insert into EQUIPE values (  14 , 14 , 1       , 'HBC BORDEAUX '  ) ;

insert into EQUIPE values (  15  , 1 , 2        , 'MONTPELLIER HANDBALL EDH'  ) ;
insert into EQUIPE values (  16 , 8 , 2        , 'MONTPELLIER HANDBALL EDH'  ) ;
insert into EQUIPE values (  17  , 2 , 2        , 'MONTPELLIER HANDBALL POUSSINS'  ) ;
insert into EQUIPE values (  18 , 9 , 2        , 'MONTPELLIER HANDBALL POUSSINS'  ) ;
insert into EQUIPE values (  19 , 3 , 2        , 'MONTPELLIER HANDBALL BENJAMINS'  ) ;
insert into EQUIPE values (  20  , 10 , 2       , 'MONTPELLIER HANDBALL BENJAMINS'  ) ;
insert into EQUIPE values (  21  , 4 , 2        , 'MONTPELLIER HANDBALL MINIMES'  ) ;
insert into EQUIPE values (  22  , 11 , 2       , 'MONTPELLIER HANDBALL MINIMES'  ) ;
insert into EQUIPE values (  23  , 5 , 2        , 'MONTPELLIER HANDBALL CADETS'  ) ;
insert into EQUIPE values (  24  , 12 , 2       , 'MONTPELLIER HANDBALL CADETS'  ) ;
insert into EQUIPE values (  25  , 6 , 2        , 'MONTPELLIER HANDBALL JUNIOR'  ) ;
insert into EQUIPE values (  26 , 13 , 2       , 'MONTPELLIER HANDBALL JUNIOR'  ) ;
insert into EQUIPE values (  27 , 7 , 2        , 'MONTPELLIER HANDBALL '  ) ;
insert into EQUIPE values (  28 , 14 , 2       , 'MONTPELLIER HANDBALL '  ) ;

insert into EQUIPE values (  29  , 1 , 3        , 'PSG HANDBALL EDH'  ) ;
insert into EQUIPE values (  30  , 8 , 3        , 'PSG HANDBALL EDH'  ) ;
insert into EQUIPE values (  31  , 2 , 3        , 'PSG HANDBALL POUSSINS'  ) ;
insert into EQUIPE values (  32  , 9 , 3        , 'PSG HANDBALL POUSSINS'  ) ;
insert into EQUIPE values (  33  , 3 , 3        , 'PSG HANDBALL BENJAMINS'  ) ;
insert into EQUIPE values (  34  , 10 , 3       , 'PSG HANDBALL BENJAMINS'  ) ;
insert into EQUIPE values (  35  , 4 , 3        , 'PSG HANDBALL MINIMES'  ) ;
insert into EQUIPE values (  36  , 11 , 3       , 'PSG HANDBALL MINIMES'  ) ;
insert into EQUIPE values (  37  , 5 , 3        , 'PSG HANDBALL CADETS'  ) ;
insert into EQUIPE values (  38 , 12 , 3       , 'PSG HANDBALL CADETS'  ) ;
insert into EQUIPE values (  39  , 6 , 3        , 'PSG HANDBALL JUNIOR'  ) ;
insert into EQUIPE values (  40 , 13 , 3       , 'PSG HANDBALL JUNIOR'  ) ;
insert into EQUIPE values (  41 , 7 , 3        , 'PSG HANDBALL  '  ) ;
insert into EQUIPE values (  42 , 14 , 3       , 'PSG HANDBALL '  ) ;

insert into EQUIPE values (  43  , 1 , 4        , 'MARSEILLE EDH'  ) ;
insert into EQUIPE values (  44  , 8 , 4        , 'MARSEILLE EDH'  ) ;
insert into EQUIPE values (  45  , 2 , 4        , 'MARSEILLE POUSSINS'  ) ;
insert into EQUIPE values (  46  , 9 , 4        , 'MARSEILLE POUSSINS'  ) ;
insert into EQUIPE values (  47  , 3 , 4        , 'MARSEILLE BENJAMINS'  ) ;
insert into EQUIPE values (  48 , 10 , 4       , 'MARSEILLE BENJAMINS'  ) ;
insert into EQUIPE values (  49  , 4 , 4        , 'MARSEILLE MINIMES'  ) ;
insert into EQUIPE values (  50  , 11 , 4       , 'MARSEILLE MINIMES'  ) ;
insert into EQUIPE values (  51  , 5 , 4        , 'MARSEILLE CADETS'  ) ;
insert into EQUIPE values (  52  , 12 , 4       , 'MARSEILLE CADETS'  ) ;
insert into EQUIPE values (  53  , 6 , 4        , 'MARSEILLE JUNIOR'  ) ;
insert into EQUIPE values (  54 , 13 , 4       , 'MARSEILLE JUNIOR'  ) ;
insert into EQUIPE values (  55 , 7 , 4        , 'MARSEILLE'  ) ;
insert into EQUIPE values (  56 , 14 , 4       , 'MARSEILLE'  ) ;

insert into EQUIPE values (  57  , 1 , 5        , 'FENIX TOULOUSE EDH'  ) ;
insert into EQUIPE values (  58  , 8 , 5        , 'FENIX TOULOUSE EDH'  ) ;
insert into EQUIPE values (  59  , 2 , 5        , 'FENIX TOULOUSE POUSSINS'  ) ;
insert into EQUIPE values (  60  , 9 , 5        , 'FENIX TOULOUSE POUSSINS'  ) ;
insert into EQUIPE values (  61  , 3 , 5        , 'FENIX TOULOUSE BENJAMINS'  ) ;
insert into EQUIPE values (  62  , 10 , 5       , 'FENIX TOULOUSE BENJAMINS'  ) ;
insert into EQUIPE values (  63  , 4 , 5        , 'FENIX TOULOUSE MINIMES'  ) ;
insert into EQUIPE values (  64  , 11 , 5       , 'FENIX TOULOUSE MINIMES'  ) ;
insert into EQUIPE values (  65  , 5 , 5        , 'FENIX TOULOUSE CADETS'  ) ;
insert into EQUIPE values (  66  , 12 , 5       , 'FENIX TOULOUSE CADETS'  ) ;
insert into EQUIPE values (  67  , 6 , 5        , 'FENIX TOULOUSE JUNIOR'  ) ;
insert into EQUIPE values (  68 , 13 , 5       , 'FENIX TOULOUSE JUNIOR'  ) ;
insert into EQUIPE values (  69 , 7 , 5        , 'FENIX TOULOUSE'  ) ;
insert into EQUIPE values (  70 , 14 , 5       , 'FENIX TOULOUSE'  ) ;

insert into EQUIPE values (  71  , 1 , 6        , 'HBC NANTES EDH'  ) ;
insert into EQUIPE values (  72  , 8 , 6        , 'HBC NANTES EDH'  ) ;
insert into EQUIPE values (  73  , 2 , 6        , 'HBC NANTES POUSSINS'  ) ;
insert into EQUIPE values (  74  , 9 , 6        , 'HBC NANTES POUSSINS'  ) ;
insert into EQUIPE values (  75  , 3 , 6        , 'HBC NANTES BENJAMINS'  ) ;
insert into EQUIPE values (  76  , 10 , 6       , 'HBC NANTES BENJAMINS'  ) ;
insert into EQUIPE values (  77  , 4 , 6        , 'HBC NANTES MINIMES'  ) ;
insert into EQUIPE values (  78  , 11 , 6       , 'HBC NANTES MINIMES'  ) ;
insert into EQUIPE values (  79  , 5 , 6        , 'HBC NANTES CADETS'  ) ;
insert into EQUIPE values (  80  , 12 , 6       , 'HBC NANTES CADETS'  ) ;
insert into EQUIPE values (  81 , 6 , 6        , 'HBC NANTES JUNIOR'  ) ;
insert into EQUIPE values (  82 , 13 , 6       , 'HBC NANTES JUNIOR'  ) ;
insert into EQUIPE values (  83 , 7 , 6        , 'HBC NANTES'  ) ;
insert into EQUIPE values (  84 , 14 , 6       , 'HBC NANTES'  ) ;

commit ;


--SAISON
insert into SAISON values (1 , '1-JAN-2021', '1-JAN-2021');

commit ;

--STADE 

insert into STADE values (1 , 'PARIS STADE', 'PARIS');
insert into STADE values (2 , 'BORDEAUX STADE', 'BORDEAUX');
insert into STADE values (3 , 'MARSEILLE STADE', 'MARSEILLE');
insert into STADE values (4 , 'TOULOUSE STADE', 'TOULOUSE');
insert into STADE values (5 , 'NANTES STADE', 'NANTES');
insert into STADE values (6 , 'MONTPELLIER STADE', 'MONTPELLIER');


commit ;

--RENCONTRE

insert into RENCONTRE values (1 , 1 , 2, 13, 27, '01-JAN-2020');
insert into RENCONTRE values (2 , 1 , 1, 41, 55, '01-JAN-2020');
insert into RENCONTRE values (3 , 1 , 5, 69, 83, '01-JAN-2020');

insert into RENCONTRE values (4 , 1 , 5 , 83, 13, '08-JAN-2020');
insert into RENCONTRE values (5 , 1 , 6, 27, 55, '08-JAN-2020');
insert into RENCONTRE values (6 , 1 , 4, 41, 69, '08-JAN-2020');

insert into RENCONTRE values (7 , 1 , 2, 13, 69, '15-JAN-2020');
insert into RENCONTRE values (8 , 1 , 1, 27, 41, '15-JAN-2020');
insert into RENCONTRE values (9 , 1 , 3, 55, 83, '15-JAN-2020');

commit ;

--INDIVIDU

insert into INDIVIDU values (1,'BAHHOU','HOUSSAM','2 rue Francois Mitterand Paris 75000');
insert into INDIVIDU values (2,'CHAGUER','REDA','20 Rue de Segur Bordeaux 33000');
insert into INDIVIDU values (3,'BENMENDIL','HAMZA','3 rue Jean Jaures Bordeaux 33000');
insert into INDIVIDU values (4,'BOULLIT','FAYCAL','5 rue Allemagne Toulouse');
insert into INDIVIDU values (5,'OMARI','ISMAIL','34 rue belvedere Paris 75000');
insert into INDIVIDU values (6,'TALBI','ANAS','5 avenue Neil Armstrong Merignac 33700');
insert into INDIVIDU values (7,'KINI','WALID','12 Avenue des Pythagores Pessac 33600');
insert into INDIVIDU values (8,'LAFFANI','YASSIR','14 rue des martyres bordeaux 33000');
insert into INDIVIDU values (9,'BOUCHEMMAMA','HAITAM','55 avenue des cristalines Toulouse');
insert into INDIVIDU values (10,'HAJBI','MOHAMED','13 rue des factures bordeaux 33000');
insert into INDIVIDU values (11,'ZERRAD','ZAYD','29 rue des jolis Grenoble 38000');
insert into INDIVIDU values (12,'ZOUBAIRI','SAAD','14 rue Italie pessac 33600');
insert into INDIVIDU values (13,'MARGOUM','SAAD','7 avenue de France Paris 75000');
insert into INDIVIDU values (14,'AMGHAR','MOHAMED','87 place Espagne Barcelone');
insert into INDIVIDU values (15,'BOUDALI','MOHAMED','25 Avenue Hamilcar Toulouse');
insert into INDIVIDU values (16,'IZEKKI','JALAL','2 rue Francois Mitterand Paris 75000');
insert into INDIVIDU values (17,'ABIDI','SAAD','20 Rue de Segur Bordeaux 33000');
insert into INDIVIDU values (18,'MARKAZ','AHMED','3 rue Jean Jaures Bordeaux 33000');
insert into INDIVIDU values (19,'HAMMADI','MOHCINE','5 rue Allemagne Toulouse');
insert into INDIVIDU values (20,'MOUGOU','YASSINE','34 rue belvedere Paris 75000');
insert into INDIVIDU values (21,'AGTAIB','BADR','5 avenue Neil Armstrong Merignac 33700');
insert into INDIVIDU values (22,'LASRI','AYOUB','12 Avenue des Pythagores Pessac 33600');
insert into INDIVIDU values (23,'DUPONT','PIERRE','14 rue des martyres bordeaux 33000');
insert into INDIVIDU values (24,'DUPONT','FREDERIC','55 avenue des cristalines Toulouse');
insert into INDIVIDU values (25,'ANDRE','HENRI','13 rue des factures bordeaux 33000');
insert into INDIVIDU values (26,'LIONEL','MESSI','29 rue des jolis Grenoble 38000');
insert into INDIVIDU values (27,'MBAPE','KILIEN','14 rue Italie pessac 33600');
insert into INDIVIDU values (28,'LAMOUR','QUENTIN','7 avenue de France Paris 75000');
insert into INDIVIDU values (29,'PIERRE','HUGO','87 place Espagne Barcelone');
insert into INDIVIDU values (30,'LAMOUR','HUGO','25 Avenue Hamilcar Toulouse');
insert into INDIVIDU values (31,'FAIZ','MEHDI','2 rue Francois Mitterand Paris 75000');
insert into INDIVIDU values (32,'HALA','ALI','20 Rue de Segur Bordeaux 33000');
insert into INDIVIDU values (33,'ISSAOUI','ALI','3 rue Jean Jaures Bordeaux 33000');
insert into INDIVIDU values (34,'HALA','MEHDI','5 rue Allemagne Toulouse');
insert into INDIVIDU values (35,'GOND','OLIVIER','34 rue belvedere Paris 75000');
insert into INDIVIDU values (36,'GOND','DAVID','5 avenue Neil Armstrong Merignac 33700');
insert into INDIVIDU values (37,'GOND','EMMANUEL','12 Avenue des Pythagores Pessac 33600');
insert into INDIVIDU values (38,'MACRON','DAVID','14 rue des martyres bordeaux 33000');
insert into INDIVIDU values (39,'MARTIN','PIERRE','55 avenue des cristalines Toulouse');
insert into INDIVIDU values (40,'GATTI','ALEXIS','13 rue des factures bordeaux 33000');
insert into INDIVIDU values (41,'SAVY','MAXIME','29 rue des jolis Grenoble 38000');
insert into INDIVIDU values (42,'GIRARDET','FABIEN','14 rue Italie pessac 33600');
insert into INDIVIDU values (43,'DUPUIS','JULIAN','7 avenue de France Paris 75000');
insert into INDIVIDU values (44,'PRINGALLE','ANTOINE','87 place Espagne Barcelone');
insert into INDIVIDU values (45,'NADIR','SOUHAIL','34 rue belvedere Paris 75000');
insert into INDIVIDU values (46,'MICHAEL','CLEMENT','5 avenue Neil Armstrong Merignac 33700');
insert into INDIVIDU values (47,'BARAK','OBAMA','12 Avenue des Pythagores Pessac 33600');
insert into INDIVIDU values (48,'TRUMP','DONALD','14 rue des martyres bordeaux 33000');
insert into INDIVIDU values (49,'BIDEN','FREDERIC','55 avenue des cristalines Toulouse');
insert into INDIVIDU values (50,'BIDEN','JOE','13 rue des factures bordeaux 33000');
insert into INDIVIDU values (51,'ROGER','FEDERER','29 rue des jolis Grenoble 38000');
insert into INDIVIDU values (52,'RAPHAEL','NADAL','14 rue Italie pessac 33600');
insert into INDIVIDU values (53,'NOVAK','DJOKOVIC','7 avenue de France Paris 75000');
insert into INDIVIDU values (54,'ANDY','MURRAY','87 place Espagne Barcelone');

commit ;

--PERSONNEL

insert into PERSONNEL values (1,1);
insert into PERSONNEL values (51,1);
insert into PERSONNEL values (43,1);
insert into PERSONNEL values (44,1);

insert into PERSONNEL values (2,2);
insert into PERSONNEL values (52,2);
insert into PERSONNEL values (33,2);
insert into PERSONNEL values (34,2);

insert into PERSONNEL values (3,3);
insert into PERSONNEL values (53,3);
insert into PERSONNEL values (23,3);
insert into PERSONNEL values (24,3);

insert into PERSONNEL values (4,4);
insert into PERSONNEL values (54,4);
insert into PERSONNEL values (13,4);
insert into PERSONNEL values (14,4);

insert into PERSONNEL values (5,5);
insert into PERSONNEL values (26,5);
insert into PERSONNEL values (15,5);
insert into PERSONNEL values (16,5);

insert into PERSONNEL values (9,6);
insert into PERSONNEL values (10,6);
insert into PERSONNEL values (17,6);
insert into PERSONNEL values (18,6);

commit;

--ROLE

insert into ROLE values (1,'PRESIDENT');
insert into ROLE values (2,'VICE PRESIDENT');
insert into ROLE values (3,'SECRETAIRE');
insert into ROLE values (4,'TRESORIO');

commit;

--ROLE_PERSONNEL

insert into ROLE_PERSONNEL values (1,1);
insert into ROLE_PERSONNEL values (51,2);
insert into ROLE_PERSONNEL values (43,3);
insert into ROLE_PERSONNEL values (44,4);

insert into ROLE_PERSONNEL values (2,1);
insert into ROLE_PERSONNEL values (52,2);
insert into ROLE_PERSONNEL values (33,3);
insert into ROLE_PERSONNEL values (34,4);

insert into ROLE_PERSONNEL values (3,1);
insert into ROLE_PERSONNEL values (53,2);
insert into ROLE_PERSONNEL values (23,3);
insert into ROLE_PERSONNEL values (24,4);

insert into ROLE_PERSONNEL values (4,1);
insert into ROLE_PERSONNEL values (54,2);
insert into ROLE_PERSONNEL values (13,3);
insert into ROLE_PERSONNEL values (14,4);

insert into ROLE_PERSONNEL values (5,1);
insert into ROLE_PERSONNEL values (26,2);
insert into ROLE_PERSONNEL values (15,3);
insert into ROLE_PERSONNEL values (16,4);

insert into ROLE_PERSONNEL values (9,1);
insert into ROLE_PERSONNEL values (10,2);
insert into ROLE_PERSONNEL values (17,3);
insert into ROLE_PERSONNEL values (18,4);

commit;

--SPORTIF

insert into SPORTIF values (6);
insert into SPORTIF values (7);
insert into SPORTIF values (8);
insert into SPORTIF values (11);
insert into SPORTIF values (12);

insert into SPORTIF values (19);
insert into SPORTIF values (20);
insert into SPORTIF values (21);
insert into SPORTIF values (22);
insert into SPORTIF values (25);

insert into SPORTIF values (27);
insert into SPORTIF values (28);
insert into SPORTIF values (29);
insert into SPORTIF values (30);
insert into SPORTIF values (31);

insert into SPORTIF values (32);
insert into SPORTIF values (35);
insert into SPORTIF values (36);
insert into SPORTIF values (37);
insert into SPORTIF values (38);

insert into SPORTIF values (39);
insert into SPORTIF values (40);
insert into SPORTIF values (41);
insert into SPORTIF values (42);
insert into SPORTIF values (45);

insert into SPORTIF values (46);
insert into SPORTIF values (47);
insert into SPORTIF values (48);
insert into SPORTIF values (49);
insert into SPORTIF values (50);

commit;

--JOUEUR


insert into JOUEUR values (7,1,'15-JAN-1990');
insert into JOUEUR values (8,2,'13-APR-1991');
insert into JOUEUR values (11,3,'25-MAY-1994');
insert into JOUEUR values (12,4,'20-DEC-1997');

insert into JOUEUR values (20,1,'29-APR-1999');
insert into JOUEUR values (21,2,'31-JAN-1996');
insert into JOUEUR values (22,3,'15-MAR-1992');
insert into JOUEUR values (25,4,'19-JUN-1993');

insert into JOUEUR values (28,1,'24-JAN-1995');
insert into JOUEUR values (29,2,'15-NOV-1997');
insert into JOUEUR values (30,3,'20-DEC-1997');
insert into JOUEUR values (31,4,'15-JAN-1992');

insert into JOUEUR values (35,1,'10-MAY-1998');
insert into JOUEUR values (36,2,'08-JUL-1998');
insert into JOUEUR values (37,3,'01-JAN-1996');
insert into JOUEUR values (38,4,'11-OCT-1994');

insert into JOUEUR values (40,1,'05-AUG-1996');
insert into JOUEUR values (41,2,'02-FEB-1999');
insert into JOUEUR values (42,3,'27-NOV-1999');
insert into JOUEUR values (45,4,'17-APR-1993');

insert into JOUEUR values (47,1,'12-JAN-1998');
insert into JOUEUR values (48,2,'19-FEB-1997');
insert into JOUEUR values (49,3,'17-DEC-1995');
insert into JOUEUR values (50,4,'02-FEB-1999');

commit;

--POSTE

insert into POSTE values (1,'AILIER');
insert into POSTE values (2,'AVANT CENTRE');
insert into POSTE values (3,'ARRIERE CENTRALE');
insert into POSTE values (4,'GARDIENT');

commit;

--HISTORIQUE

insert into HISTORIQUE values (1 , 13, 6 ,'15-JAN-2019', null);
insert into HISTORIQUE values (2 , 13, 7 ,'15-JAN-2019', null);
insert into HISTORIQUE values (3 , 13, 8 ,'15-JAN-2019', null);
insert into HISTORIQUE values (4 , 13, 11,'15-JAN-2019', null);
insert into HISTORIQUE values (5 , 13, 12,'15-JAN-2019', null);

insert into HISTORIQUE values (6 , 27, 19,'15-JAN-2019', null);
insert into HISTORIQUE values (7 , 27, 20,'15-JAN-2019', '12-DEC-2019');
insert into HISTORIQUE values (8 , 27, 21,'15-JAN-2019', null);
insert into HISTORIQUE values (9 , 27, 22,'15-JAN-2019', null);
insert into HISTORIQUE values (10 ,27, 25,'15-JAN-2019', null);

insert into HISTORIQUE values (11 , 41, 27,'15-JAN-2019', null);
insert into HISTORIQUE values (12 , 41, 28,'15-JAN-2019', null);
insert into HISTORIQUE values (13 , 41, 29,'15-JAN-2019', null);
insert into HISTORIQUE values (14 , 41, 30,'15-JAN-2019', null);
insert into HISTORIQUE values (15 , 41, 31,'15-JAN-2019', null);

insert into HISTORIQUE values (16 , 55, 32,'15-JAN-2019', null);
insert into HISTORIQUE values (17 , 55, 35,'15-JAN-2019', null);
insert into HISTORIQUE values (18 , 55, 36,'15-JAN-2019', null);
insert into HISTORIQUE values (19 , 55, 37,'15-JAN-2019', null);
insert into HISTORIQUE values (20 , 55, 38,'15-JAN-2019', null);

insert into HISTORIQUE values (21 , 69, 39,'15-JAN-2019', null);
insert into HISTORIQUE values (22 , 69, 40,'15-JAN-2019', '12-DEC-2019');
insert into HISTORIQUE values (23 , 69, 41,'15-JAN-2019', null);
insert into HISTORIQUE values (24 , 69, 42,'15-JAN-2019', null);
insert into HISTORIQUE values (25 , 69, 45,'15-JAN-2019', null);

insert into HISTORIQUE values (26 , 83, 46,'15-JAN-2019', null);
insert into HISTORIQUE values (27 , 83, 47,'15-JAN-2019', null);
insert into HISTORIQUE values (28 , 83, 48,'15-JAN-2019', null);
insert into HISTORIQUE values (29 , 83, 49,'15-JAN-2019', null);
insert into HISTORIQUE values (30 , 83, 50,'15-JAN-2019', null);

commit;

--PARTICIPATION

insert into PARTICIPATION values (1, 8, 2, 1,5,null);
insert into PARTICIPATION values (2, 11, 3, 1,6,1);
insert into PARTICIPATION values (3, 12, 4, 1,null,null);

insert into PARTICIPATION values (4, 21, 1, 1,4,1);
insert into PARTICIPATION values (5, 22, 3, 1,7,2);
insert into PARTICIPATION values (6, 25, 4, 1,null,null);

insert into PARTICIPATION values (7, 29, 2, 2,7,null);
insert into PARTICIPATION values (8, 30, 1, 2,10,null);
insert into PARTICIPATION values (9, 31, 4, 2,null,null);

insert into PARTICIPATION values (10, 36, 2, 2,null,2);
insert into PARTICIPATION values (11, 37, 3, 2,null,null);
insert into PARTICIPATION values (12, 38, 4, 2,null,null);

insert into PARTICIPATION values (13, 41, 2,3,16,null);
insert into PARTICIPATION values (14,42,1,3,null,null);
insert into PARTICIPATION values (15,45,4,3,null,null);

insert into PARTICIPATION values (16,48,1,3,5,null);
insert into PARTICIPATION values (17,49,3,3,8,null);
insert into PARTICIPATION values (18,50,4,3,null,null);

insert into PARTICIPATION values (19,8,2,4,9,null);
insert into PARTICIPATION values (20,11,3,4,null,null);
insert into PARTICIPATION values (21,12,4,4,null,null);

insert into PARTICIPATION values (22,21,1,5,7,1);
insert into PARTICIPATION values (23,22,3,5,9,null);
insert into PARTICIPATION values (24,25,4,5,null,null);

insert into PARTICIPATION values (25,29,2,6,9,null);
insert into PARTICIPATION values (26,30,1,6,10,null);
insert into PARTICIPATION values (27,31,4,6,null,null);

insert into PARTICIPATION values (28,36,2,5,6,null);
insert into PARTICIPATION values (29,37,3,5,7,null);
insert into PARTICIPATION values (30,38,4,5,null,null);

insert into PARTICIPATION values (31,41,2,6,14,null);
insert into PARTICIPATION values (32,42,1,6,7,null);
insert into PARTICIPATION values (33,45,4,6,null,null);

insert into PARTICIPATION values (34,48,1,4,9,null);
insert into PARTICIPATION values (35,49,3,4,15,null);
insert into PARTICIPATION values (36,50,4,4,null,null);

insert into PARTICIPATION values (37,8,2,7,9,2);
insert into PARTICIPATION values (38,11,3,7,12,null);
insert into PARTICIPATION values (39,12,4,7,null,null);

insert into PARTICIPATION values (40,21,1,8,15,null);
insert into PARTICIPATION values (41,22,3,8,12,null);
insert into PARTICIPATION values (42,25,4,8,null,null);

insert into PARTICIPATION values (43,29,2,8,7,null);
insert into PARTICIPATION values (44,30,1,8,6,null);
insert into PARTICIPATION values (45,31,4,8,null,null);

insert into PARTICIPATION values (46,36,2,9,7,null);
insert into PARTICIPATION values (47,37,3,9,9,null);
insert into PARTICIPATION values (48,38,4,9,null,null);

insert into PARTICIPATION values (49,41,2,7,null,null);
insert into PARTICIPATION values (50,42,1,7,12,null);
insert into PARTICIPATION values (51,45,4,7,null,null);

insert into PARTICIPATION values (52,48,1,9,12,null);
insert into PARTICIPATION values (53,49,3,9,null,2);
insert into PARTICIPATION values (54,50,4,9,null,null);

commit;





