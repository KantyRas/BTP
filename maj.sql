-- Active: 1714575637011@@127.0.0.1@5432@evaluation@public
create table profil (
    idprofil serial primary key,
    nomprofil varchar(255)
);

create table utilisateur(
    idutilisateur serial primary key,
    idprofil int references profil(idprofil) default 2,
    numero varchar(25),
    email varchar(75) default null,
    password varchar(255) default null
);
select * from utilisateur;


create table unite(
    idunite serial primary key,
    unite varchar(10)
);

create table typemaison(
    idtypemaison serial primary key,
    typemaison varchar(75),
    description varchar(255),
    dureeconstruction double precision,
    prix double precision
);
CREATE TABLE typemaison_history (
    idtypemaison_history SERIAL PRIMARY KEY,
    idtypemaison INT REFERENCES typemaison(idtypemaison),
    prix double precision,
    dureeconstruction double precision,
    description varchar(255),
    date_debut_validite date,
    date_fin_validite date
);

drop table typemaison;
create table travauxmaison(
    idtravaux serial primary key,
    idtypemaison int references typemaison(idtypemaison),
    designation varchar(255),
    idunite int references unite(idunite),
    quantite double precision,
    prixunitaire double precision,
    total double precision
);
CREATE TABLE travauxmaison_history (
    idtravaux_history SERIAL PRIMARY KEY,
    idtravaux INT REFERENCES travauxmaison(idtravaux),
    idtypemaison INT,
    designation varchar(255),
    idunite INT,
    quantite double precision,
    prixunitaire double precision,
    total double precision,
    date_debut_validite date,
    date_fin_validite date
);

drop table travauxmaison;
create table typefinition(
    idtypefinition serial primary key,
    typefinition varchar(75),
    augmentaion_prix double precision
);
CREATE TABLE typefinition_history (
    idtypefinition_history SERIAL PRIMARY KEY,
    idtypefinition INT REFERENCES typefinition(idtypefinition),
    typefinition varchar(75),
    augmentaion_prix double precision,
    date_debut_validite date,
    date_fin_validite date
);

drop table typefinition;

create table devis(
    iddevis serial primary key,
    idclient int REFERENCES utilisateur(idutilisateur),
    description varchar(255),
    idtypemaison int references typemaison(idtypemaison),
    idtypefinition int references typefinition(idtypefinition),
    datedebut date,
    datefin date,
    datecreation date default now(),
    montant_total double precision
);
SELECT EXTRACT(MONTH FROM datecreation) AS mois,
       SUM(montant_total) AS somme_montant_total
FROM devis
WHERE EXTRACT(YEAR FROM datecreation) = 2024
GROUP BY EXTRACT(MONTH FROM datecreation)
ORDER BY mois;


create table facturation(
    idfacture serial primary key,
    iddevis int references devis(iddevis),
    date_paiement date,
    montant_payer double precision
);

insert into profil (nomprofil) values ('BTP:Admin'),('client');
insert into utilisateur (idprofil,numero,email,password) values (1,'0348764540','kanty@gmail.com','0000');
insert into unite (unite) values ('kg'),('m3'),('m2'),('u');
insert into typemaison (typemaison,description,dureeconstruction,prix) values ('Maison1','2 chambres + 1 terrasse + 1 douche',21,10000),('Maison2','1 chambre + 1 douche',25,12000);
insert into travauxmaison (idtypemaison,designation,idunite,quantite,prixunitaire,total) values 
(1,'decapage des terrains',3,101.36,3072.87,311466.1),
(1,'dressage du plateforme',3,101.36,3736.26,378711.32),
(1,'remblai douvrage',2,15.59,37563.26,585761.49),
(2,'maconnerie de moellons',2,9.62,172114.40,1656299.89),
(2,'remblai technique',2,15.59,37563.26,585761.49);
insert into typefinition (typefinition,augmentaion_prix) values ('Standard',0),('Gold',10),('Premium',5),('VIP',15);

drop table facturation;
select * from devis;

drop table devis;

-- maka detail devis
SELECT 
    d.iddevis,
    d.idclient,
    d.description AS description_devis,
    t.typemaison,
    t.description AS description_typemaison,
    d.idtypemaison,
    f.typefinition,
    f.augmentaion_prix,
    d.idtypefinition,
    d.datedebut,
    d.datefin,
    d.datecreation,
    d.montant_total
FROM 
    devis d
JOIN 
    typemaison t ON d.idtypemaison = t.idtypemaison
JOIN 
    typefinition f ON d.idtypefinition = f.idtypefinition
WHERE 
    d.iddevis = 1;

-- maka detail travaux
SELECT 
idtravaux,
idtypemaison,
designation,
t.idunite,
u.unite,
quantite,
prixunitaire,
total
FROM 
    travauxmaison t
JOIN 
unite u on t.idunite = u.idunite
WHERE 
    idtypemaison = 2 GROUP BY t.idtravaux,u.unite;

CREATE or replace VIEW reste_a_payer_devis AS
SELECT d.iddevis, 
       d.montant_total AS montant_initial,
       d.montant_total - COALESCE(SUM(f.montant_payer), 0) AS reste_a_payer
FROM devis d
LEFT JOIN facturation f ON d.iddevis = f.iddevis
GROUP BY d.iddevis, d.montant_total;



drop view reste_a_payer_devis;
select * from facturation;
select idfacture,iddevis,date_paiement,montant_payer
from facturation f      
join devis d on d.iddevis = f.iddevis

create table v_travaux(
    type_maison varchar(255),
    description varchar(255),
    surface double precision,
    code_travaux int,
    type_travaux varchar(255),
    unite varchar(20),
    prix_unitaire double precision,
    quantite double precision,
    duree_travaux double precision
);
drop table v_travaux;

create table v_devis(
    client VARCHAR(75),
    ref_devis varchar(255),
    type_maison varchar(255),
    finition varchar(255),
    taux_finition double precision,
    date_devis date,
    date_debut date,
    lieu VARCHAR(255) 
);
select * from v_devis;
drop table v_devis;

create table v_paiement(
    ref_devis varchar(75),
    ref_paiement varchar(255),
    date_paiement date,
    montant double precision
);

drop table v_paiement;


/*create table projet(
    idprojet serial primary key,
    idclient int REFERENCES utilisateur(idutilisateur),
    description varchar(75),
    datedebut date,
    idtypemaison int references typemaison(idtypemaison),
    idtypefinition int references typefinition(idtypefinition),
    datefin date
);*/

/*create table detailDevis(
    iddetail serial primary key,
    iddevis int references devis(iddevis),
    designation varchar(255),
    idunite int references unite(idunite),
    quantite double precision,
    prixunitaire double precision,
    total double precision
);*/
SELECT idtravaux,idtypemaison,designation,t.idunite,u.unite,quantite,prixunitaire,total FROM travauxmaison t JOIN unite u on t.idunite = u.idunite GROUP BY t.idtravaux,u.unite ORDER BY t.idtravaux;