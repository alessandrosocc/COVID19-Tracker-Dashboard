create database covid19;
use covid19;
create table totale(
    data date,
    primary key(data),
    contagiati int,
    dimessi int,
    deceduti int,
    tamponi int 
);
create table account(
    token varchar(20),
    password varchar(128),
    attivo boolean,
    ruolo varchar(5),
    primary key(token)
 );
create table accessi(
        data date,
        ora time,
        ip varchar(15),
        token varchar(20),
        primary key(token),
        FOREIGN key (token) REFERENCES account(token)
);
create table istituzioni(
           regione varchar(20),
           nome varchar(30),
           struttura varchar(30),
           citta varchar(20),
           token varchar(20),
           primary key(token),
          foreign key (token) references account(token)
);
create table registri(
               id int AUTO_INCREMENT,
               data date,
               positivi int,
               dimessi int,
               decessi int, 
               tamponi int,
               token varchar(20),
               primary key(id),
               foreign key (token) REFERENCES istituzioni(token)
);
