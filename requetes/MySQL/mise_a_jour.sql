delete from INDIVIDU
            where ID_INDIVIDU = 1;
            
insert into INDIVIDU (NOM_INDIVIDU, PRENOM_INDIVIDU, ADRESSE) 
            values ('JUNIOR', 'NEYMAR','4 avenue champs elysee PARIS' );
            
insert into HISTORIQUE (ID_SPORTIF, ID_EQUIPE, DATE_DEBUT)
            values (13 , 5, '2019-01-15');

delete from HISTORIQUE
            where ID_HISTORIQUE = 5;

insert into ROLE_PERSONNEL (ID_ROLE, ID_PERSONNEL) 
            values (29, 4);

delete from ROLE_PERSONNEL where ID_ROLE = 24 and  ID_PERSONNEL = 4;

insert into ROLE (NOM_ROLE) 
            values ('PRESIDENT');


insert into RENCONTRE (ID_SAISON, ID_STADE, ID_EQUIPE_R, ID_EQUIPE_V, DATE_RENCONTRE)
            values (2 , 5, 69, 83, '2020-01-01');

delete from RENCONTRE
            where ID_RENCONTRE = 3;

                                                                                    
insert into SPORTIF (ID_SPORTIF) 
            values (5);

                                                                                                                  
insert into JOUEUR (ID_JOUEUR, NUMERO_LICENCE, DATE_NAISSANCE) 
            values (21,2,'1996-01-31');

insert into PARTICIPATION (ID_JOUEUR, ID_RENCONTRE, ID_POSTE, NOMBRE_BUT, NOMBRE_FAUTE)
            values (30, 2, 1,10,0);

delete from PARTICIPATION
            where ID_PARTICIPATION = 4;

insert into EQUIPE (NOM_EQUIPE, ID_CATEGORIE, ID_CLUB)
            ('HBC BORDEAUX EDH', 1 , 1 );
            
delete from EQUIPE
            where ID_EQUIPE = 2;    
                                                    
insert into CLUB (NOM_CLUB, DATE_CREATION)
             ('PSG HANDBALL', 1941 );
                                                                                                                                                                            
delete from CLUB
            where ID_CLUB = 2;
