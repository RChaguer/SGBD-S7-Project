drop view if exists joueur_equipe_r_rencontre;
drop view if exists joueur_equipe_v_rencontre;
drop view if exists nb_but_rencontre_V;
drop view if exists nb_but_rencontre_R;
drop view if exists score;
drop view if exists joueur_equipe_r_rencontre;
drop view if exists joueur_equipe_v_rencontre;
drop view if exists nb_but_rencontre_V;
drop view if exists nb_but_rencontre_R;
drop view if exists score;
drop view if exists win_r;
drop view if exists win_v;
drop view if exists wins;
drop view if exists lost_r;
drop view if exists lost_v;
drop view if exists loss;
drop view if exists draw_r;
drop view if exists draw_v;
drop view if exists draws;
drop view if exists table_s;
drop view if exists `rank`;



create view joueur_equipe_v_rencontre as
select distinct historique.id_sportif, historique.id_equipe, equipe.nom_equipe, rencontre.id_rencontre
from historique inner join rencontre on historique.id_equipe = rencontre.id_equipe_v
inner join participation on participation.id_joueur= historique.id_sportif
inner join equipe on historique.id_equipe = equipe.id_equipe
where (rencontre.date_rencontre > historique.date_debut and (historique.date_fin is null or rencontre.date_rencontre < historique.date_fin))
order by rencontre.id_rencontre;

create view joueur_equipe_r_rencontre as
select distinct historique.id_sportif, historique.id_equipe, equipe.nom_equipe, rencontre.id_rencontre
from historique inner join rencontre on historique.id_equipe = rencontre.id_equipe_r
inner join participation on participation.id_joueur= historique.id_sportif
inner join equipe on historique.id_equipe = equipe.id_equipe
where (rencontre.date_rencontre > historique.date_debut and (historique.date_fin is null or rencontre.date_rencontre < historique.date_fin))
order by rencontre.id_rencontre;

create view nb_but_rencontre_V as 
select  joueur_equipe_v_rencontre.id_rencontre as m, joueur_equipe_v_rencontre.id_equipe as v, joueur_equipe_v_rencontre.nom_equipe as nomequipe, IFNULL(SUM(participation.nombre_but),0) as nb
from joueur_equipe_v_rencontre inner join participation on (participation.id_rencontre=joueur_equipe_v_rencontre.id_rencontre and
joueur_equipe_v_rencontre.id_sportif = participation.id_joueur) 
group by joueur_equipe_v_rencontre.id_rencontre , joueur_equipe_v_rencontre.id_equipe, joueur_equipe_v_rencontre.nom_equipe
order by m;


create view nb_but_rencontre_R as 
select  joueur_equipe_r_rencontre.id_rencontre as m, joueur_equipe_r_rencontre.id_equipe as r, joueur_equipe_r_rencontre.nom_equipe as nomequipe, IFNULL(SUM(participation.nombre_but),0) as nb
from joueur_equipe_r_rencontre inner join participation on (participation.id_rencontre=joueur_equipe_r_rencontre.id_rencontre and
joueur_equipe_r_rencontre.id_sportif = participation.id_joueur) 
group by joueur_equipe_r_rencontre.id_rencontre , joueur_equipe_r_rencontre.id_equipe, joueur_equipe_r_rencontre.nom_equipe
order by m;

create view score as 
select  nb_but_rencontre_R.R as R, nb_but_rencontre_R.nomequipe as home, nb_but_rencontre_R.nb as scorehome, nb_but_rencontre_V.nb as scoreaway, nb_but_rencontre_V.nomequipe as away, nb_but_rencontre_V.V as V, nb_but_rencontre_V.M as rencontre
from nb_but_rencontre_V inner join nb_but_rencontre_R on nb_but_rencontre_V.M = nb_but_rencontre_R.M;



create view win_r as
select equipe.id_equipe, equipe.nom_equipe, IFNULL(count(id_equipe),0) as nb
from equipe inner join score on equipe.id_equipe = score.r 
where scorehome > scoreaway
group by  equipe.id_equipe, equipe.nom_equipe ;

create view win_v as
select equipe.id_equipe, equipe.nom_equipe, IFNULL(count(id_equipe),0) as nb
from equipe inner join score on equipe.id_equipe = score.v
where scorehome < scoreaway
group by  equipe.id_equipe, equipe.nom_equipe ;

create view wins as
select id_equipe,nom_equipe, IFNULL(sum(nb),0) as wins
from(
select * 
from win_r union all select * from win_v) W
group by id_equipe, nom_equipe;

create view lost_r as
select equipe.id_equipe, equipe.nom_equipe, IFNULL(count(id_equipe),0) as nb
from equipe inner join score on equipe.id_equipe = score.r 
where scorehome < scoreaway
group by  equipe.id_equipe, equipe.nom_equipe ;

create view lost_v as
select equipe.id_equipe, equipe.nom_equipe, IFNULL(count(id_equipe),0) as nb
from equipe inner join score on equipe.id_equipe = score.v
where scorehome > scoreaway
group by  equipe.id_equipe, equipe.nom_equipe ;

create view loss as
select id_equipe,nom_equipe, IFNULL(sum(nb),0) as losses
from(
select * 
from lost_r union all select * from lost_v) L
group by id_equipe, nom_equipe;

create view draw_r as
select equipe.id_equipe, equipe.nom_equipe, IFNULL(count(id_equipe),0) as nb
from equipe inner join score on equipe.id_equipe = score.r 
where scorehome = scoreaway
group by  equipe.id_equipe, equipe.nom_equipe ;

create view draw_v as
select equipe.id_equipe, equipe.nom_equipe, IFNULL(count(id_equipe),0) as nb
from equipe inner join score on equipe.id_equipe = score.v
where scorehome = scoreaway
group by  equipe.id_equipe, equipe.nom_equipe ;

create view draws as
select id_equipe,nom_equipe, IFNULL(sum(nb),0) as draws
from(
select * 
from draw_r union all select * from draw_v) D
group by id_equipe, nom_equipe;

create view table_s as
select equipe.*, IFNULL(wins,0) as wins, IFNULL(draws,0) as draws, IFNULL(losses,0) as losses, (3*IFNULL(wins,0) + IFNULL(draws,0)) as score
from  equipe left join wins on wins.id_equipe = equipe.id_equipe
left outer join draws on draws.id_equipe = equipe.id_equipe
left outer join loss on loss.id_equipe = equipe.id_equipe;


create view `rank` as 
SELECT RANK() OVER( ORDER BY  score desc)  `rank`, table_s.*
from table_s
where id_categorie = 7;
