CREATE TABLE crypto(
   idCrypto SERIAL,
   crypto VARCHAR(50)  NOT NULL,
   PRIMARY KEY(idCrypto),
   UNIQUE(crypto)
);

CREATE TABLE transCrypto(
   idTransCrypto SERIAL,
   idUtilisateur INTEGER NOT NULL,
   entree NUMERIC(15,2)  ,
   sortie NUMERIC(15,2)  ,
   dateTransaction TIMESTAMP NOT NULL,
   idCrypto INTEGER NOT NULL,
   PRIMARY KEY(idTransCrypto),
   FOREIGN KEY(idCrypto) REFERENCES crypto(idCrypto)
);

CREATE TABLE fondUtilisateur(
   idTransFond SERIAL,
   entree NUMERIC(20,2)   NOT NULL,
   sortie NUMERIC(20,2)   NOT NULL,
   idUtilisateur INTEGER NOT NULL,
   PRIMARY KEY(idTransFond)
);
