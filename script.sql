create database testevaluation;
use testevaluation;

create table utilisateur(
	id integer auto_increment primary key,
	nom varchar(20),
	prenom varchar(30),
	email varchar(50),
	mdp varchar(100),
	estValider integer
);

create table superAdmin(
	id integer auto_increment primary key,
	nom varchar(20),
	prenom varchar(30),
	email varchar(30),
	mdp varchar(100)
);

insert into superAdmin (nom,prenom,email,mdp) values('Rakotobe','Njaka Mahefa','njakamahefa@gmail.com',sha1('mdp'));

create table matiere(
	id integer auto_increment primary key,
	nomMatiere varchar(10),
	seuil decimal(10,2)
);

insert into matiere(nomMatiere,seuil) values('Lait',10),('sucre',20),('parfum',30),('conservateur',10),('colorant',05),('Fraise',10),('banane',20);

create table stockmatiere(
	id integer auto_increment primary key,
	idmatiere integer,
	quantiteinit decimal(10,2),
	quantitereste decimal(10,2),
	dateAchat datetime default CURRENT_TIMESTAMP,
	prixAchat decimal(10,2),
	FOREIGN KEY (idmatiere) REFERENCES matiere(id)
); 


create table mvtStockMatiere(
	id integer auto_increment primary key,
	idstock integer,
	entree decimal(10,2),
	sortie decimal(10,2),
	dateMouvement datetime default CURRENT_TIMESTAMP,
	FOREIGN KEY (idstock) REFERENCES stockmatiere(id)
);

create view achatnec as
	select m.id,m.nomMatiere,m.seuil,sum(sm.quantitereste) as reste
	from stockmatiere sm
	left join matiere m
	on m.id=sm.idmatiere
	group by m.nomMatiere,m.seuil;

create view mouve as
	select mv.entree, mv.sortie, mv.dateMouvement,sm.idmatiere
	from mvtStockMatiere mv
	left join stockmatiere sm
	on mv.idstock = sm.id;


create table Produit(
	id integer auto_increment primary key,
	nomProduit varchar(30)
);

insert into Produit(nomProduit) values('Yaourt au fraise'),('Yaourt a la banane'),('Beurre'),('Creme fraiche'),('Glace au chocolat'),
	('Glace a la vanille');

create table Formule(
	id integer auto_increment primary key,
	idProduit integer,
	idmatiere integer,
	pourcentage decimal(10,2),
	FOREIGN KEY (idProduit) REFERENCES Produit(id),
	FOREIGN KEY (idmatiere) REFERENCES matiere(id)
);

insert into Formule(idProduit,idmatiere,pourcentage) values(1,6,10);
insert into Formule(idProduit,idmatiere,pourcentage) values(1,1,80);
insert into Formule(idProduit,idmatiere,pourcentage) values(1,2,10);
insert into Formule(idProduit,idmatiere,pourcentage) values(2,3,10);
insert into Formule(idProduit,idmatiere,pourcentage) values(2,4,70);
insert into Formule(idProduit,idmatiere,pourcentage) values(2,5,20);



create table stockproduit(
	id integer auto_increment primary key,
	idProduit integer,
	quantiteinit decimal(10,2),
	quantitereste decimal(10,2),
	dateFabrication datetime default CURRENT_TIMESTAMP,
	FOREIGN KEY (idProduit) REFERENCES Produit(id)
);


create table vente(
	id integer auto_increment primary key,
	idstock integer,
	quantite integer,
	dateVente datetime default CURRENT_TIMESTAMP,
	prixVente decimal(10,2),
	FOREIGN KEY (idstock) REFERENCES stockproduit(id)
);

create table mvtStockProduit(
	id integer auto_increment primary key,
	idstock integer,
	entree decimal(10,2),
	sortie decimal(10,2),
	dateMouvement datetime default CURRENT_TIMESTAMP,
	FOREIGN KEY (idstock) REFERENCES stockproduit(id)	
);

create view formuleMatiere as 
    select f.idProduit,f.idmatiere,f.pourcentage,sm.reste
    from formule f 
    left join achatnec sm 
    on f.idmatiere=sm.id;

select count(idmatiere) as isa from formuleMatiere where idProduit=1;


DELIMITER //
CREATE PROCEDURE insertProduit
(IN x integer,IN quantite decimal)
BEGIN
	DECLARE idstock integer;
	insert into stockproduit(idProduit,quantiteinit,quantitereste) values(x,quantite,quantite);
    SELECT max(id) into idstock from stockproduit where idProduit=x;
    insert into mvtStockProduit (idstock,entree,sortie) values(idstock,quantite,0);
END //
DELIMITER ;



DELIMITER //
CREATE PROCEDURE insertAchat
(IN x integer,IN quantite decimal,IN prix decimal)
BEGIN
	DECLARE idstock integer;
	insert into stockmatiere(idMatiere,quantiteinit,quantitereste,prixAchat) values(x,quantite,quantite,prix);
    SELECT max(id) into idstock from stockmatiere where idmatiere=x;
    insert into mvtStockMatiere (idstock,entree,sortie) values(idstock,quantite,0);
END //
DELIMITER ;





DELIMITER //
CREATE PROCEDURE updatestockMatiere
(IN idm integer,IN quantite decimal)
BEGIN
	DECLARE idstock integer;
	DECLARE quantiteao decimal;
	DECLARE q decimal default 0;
	
    SELECT min(id) into idstock from stockmatiere where idmatiere=idm and quantitereste>0;
    SELECT quantitereste into quantiteao from stockmatiere where id=idstock;
    IF quantiteao<quantite THEN
	   insert into mvtStockMatiere (idstock,entree,sortie) values(idstock,0,quantiteao);
	   update stockmatiere set quantitereste=0 where id=idstock;
	   select quantite-quantiteao into q;
	  SELECT min(id) into idstock from stockmatiere where idmatiere=idm and quantitereste>0;
    	SELECT quantitereste into quantiteao from stockmatiere where id=idstock;
    	insert into mvtStockMatiere (idstock,entree,sortie) values(idstock,0,q);
	   update stockmatiere set quantitereste=quantiteao-q where id=idstock;
	ELSE
	   insert into mvtStockMatiere (idstock,entree,sortie) values(idstock,0,quantite);
	   	select quantiteao-quantite into q;
	   update stockmatiere set quantitereste=q where id=idstock;
	END IF;
END //
DELIMITER ;



create view mouveProduit as
	select mv.entree, mv.sortie, mv.dateMouvement,sm.idProduit
	from mvtStockProduit mv
	left join stockproduit sm
	on mv.idstock = sm.id;


create view Produitreste as 
	select sum(s.quantitereste) as reste,s.idProduit,p.nomProduit from stockproduit s 
	left join produit p 
	on s.idProduit=p.id 
	group by s.idProduit;


DELIMITER //
CREATE PROCEDURE updatestockProduit
(IN idp integer,IN quantite decimal)
BEGIN
	DECLARE idstock integer;
	DECLARE quantiteao decimal;
	DECLARE q decimal default 0;
	
    SELECT min(id) into idstock from stockproduit where idproduit=idp and quantitereste>0;
    SELECT quantitereste into quantiteao from stockproduit where id=idstock;
    IF quantiteao<quantite THEN
	   insert into mvtStockProduit (idstock,entree,sortie) values(idstock,0,quantiteao);
	   update stockproduit set quantitereste=0 where id=idstock;
	   select quantite-quantiteao into q;
	  SELECT min(id) into idstock from stockproduit where idproduit=idp and quantitereste>0;
    	SELECT quantitereste into quantiteao from stockproduit where id=idstock;
    	insert into mvtStockProduit (idstock,entree,sortie) values(idstock,0,q);
	   update stockproduit set quantitereste=quantiteao-q where id=idstock;
	ELSE
	   insert into mvtStockProduit (idstock,entree,sortie) values(idstock,0,quantite);
	   	select quantiteao-quantite into q;
	   update stockproduit set quantitereste=q where id=idstock;
	END IF;
END //
DELIMITER ;