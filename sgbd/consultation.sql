drop view joueur_equipe_r_match;
drop view joueur_equipe_v_match;
drop view nb_but_match_V;
drop view nb_but_match_R;
drop view score;
drop view joueur_equipe_r_match;
drop view joueur_equipe_v_match;
drop view nb_but_match_V;
drop view nb_but_match_R;
drop view score;
drop view win_r;
drop view win_v;
drop view wins;
drop view lost_r;
drop view lost_v;
drop view losses;
drop view draw_r;
drop view draw_v;
drop view draws;
drop view table_s;
drop view rank;



create view joueur_equipe_v_match as
select distinct historique.id_sportif, historique.id_equipe, equipe.nom_equipe, match.id_match
from historique inner join match on historique.id_equipe = match.id_equipe_v
inner join participation on participation.id_joueur= historique.id_sportif
inner join equipe on historique.id_equipe = equipe.id_equipe
where (match.date_match > historique.date_debut and (match.date_match < historique.date_fin or historique.date_fin is null))
order by match.id_match;

create view joueur_equipe_r_match as
select distinct historique.id_sportif, historique.id_equipe, equipe.nom_equipe, match.id_match
from historique inner join match on historique.id_equipe = match.id_equipe_r
inner join participation on participation.id_joueur= historique.id_sportif
inner join equipe on historique.id_equipe = equipe.id_equipe
where (match.date_match > historique.date_debut and (match.date_match < historique.date_fin or historique.date_fin is null))
order by match.id_match;

create view nb_but_match_V as 
select  joueur_equipe_v_match.id_match as m, joueur_equipe_v_match.id_equipe as v, joueur_equipe_v_match.nom_equipe as nomequipe, nvl(SUM(participation.nombre_but),0) as nb
from joueur_equipe_v_match inner join participation on (participation.id_match=joueur_equipe_v_match.id_match and
joueur_equipe_v_match.id_sportif = participation.id_joueur) 
group by joueur_equipe_v_match.id_match , joueur_equipe_v_match.id_equipe, joueur_equipe_v_match.nom_equipe
order by m;


create view nb_but_match_R as 
select  joueur_equipe_r_match.id_match as m, joueur_equipe_r_match.id_equipe as r, joueur_equipe_r_match.nom_equipe as nomequipe, nvl(SUM(participation.nombre_but),0) as nb
from joueur_equipe_r_match inner join participation on (participation.id_match=joueur_equipe_r_match.id_match and
joueur_equipe_r_match.id_sportif = participation.id_joueur) 
group by joueur_equipe_r_match.id_match , joueur_equipe_r_match.id_equipe, joueur_equipe_r_match.nom_equipe
order by m;

create view score as 
select  nb_but_match_R.R as R, nb_but_match_R.nomequipe as home, nb_but_match_R.nb as scorehome, nb_but_match_V.nb as scoreaway, nb_but_match_V.nomequipe as away, nb_but_match_V.V as V, nb_but_match_V.M as match
from nb_but_match_V inner join nb_but_match_R on nb_but_match_V.M = nb_but_match_R.M;



create view win_r as
select equipe.id_equipe, equipe.nom_equipe, nvl(count(id_equipe),0) as nb
from equipe inner join score on equipe.id_equipe = score.r 
where scorehome > scoreaway
group by  equipe.id_equipe, equipe.nom_equipe ;

create view win_v as
select equipe.id_equipe, equipe.nom_equipe, nvl(count(id_equipe),0) as nb
from equipe inner join score on equipe.id_equipe = score.v
where scorehome < scoreaway
group by  equipe.id_equipe, equipe.nom_equipe ;

create view wins as
select id_equipe,nom_equipe, nvl(sum(nb),0) as wins
from(
select * 
from win_r union all select * from win_v)
group by id_equipe, nom_equipe;

create view lost_r as
select equipe.id_equipe, equipe.nom_equipe, nvl(count(id_equipe),0) as nb
from equipe inner join score on equipe.id_equipe = score.r 
where scorehome < scoreaway
group by  equipe.id_equipe, equipe.nom_equipe ;

create view lost_v as
select equipe.id_equipe, equipe.nom_equipe, nvl(count(id_equipe),0) as nb
from equipe inner join score on equipe.id_equipe = score.v
where scorehome > scoreaway
group by  equipe.id_equipe, equipe.nom_equipe ;

create view loss as
select id_equipe,nom_equipe, nvl(sum(nb),0) as losses
from(
select * 
from lost_r union all select * from lost_v)
group by id_equipe, nom_equipe;

create view draw_r as
select equipe.id_equipe, equipe.nom_equipe, nvl(count(id_equipe),0) as nb
from equipe inner join score on equipe.id_equipe = score.r 
where scorehome = scoreaway
group by  equipe.id_equipe, equipe.nom_equipe ;

create view draw_v as
select equipe.id_equipe, equipe.nom_equipe, nvl(count(id_equipe),0) as nb
from equipe inner join score on equipe.id_equipe = score.v
where scorehome = scoreaway
group by  equipe.id_equipe, equipe.nom_equipe ;

create view draws as
select id_equipe,nom_equipe, nvl(sum(nb),0) as draws
from(
select * 
from draw_r union all select * from draw_v)
group by id_equipe, nom_equipe;

create view table_s as
select equipe.nom_equipe, nvl(wins,0) as wins, nvl(draws,0) as draws, nvl(losses,0) as losses, (3*nvl(wins,0) + nvl(draws,0)) as score
from  wins left join equipe using(id_equipe)
full outer join draws using(id_equipe)
full outer join loss using(id_equipe); 

create view rank as 
SELECT rank() OVER( ORDER BY  score desc)  rank, table_s.*
from table_s;