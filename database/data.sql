insert into crypto(crypto) values   ('BitCoin'),
                                    ('Ethereum'),
                                    ('ValCoin');

insert into fondUtilisateur(entree,sortie,"idUtilisateur") values (1000,0,1),
                                                                    (0,500,1);

insert into "transCrypto"("idUtilisateur",entree,sortie,"prixUnitaire","dateTransaction","idCrypto") values (1,10,0,200,'2024-10-10',1),
                                                                                                            (1,5,0,100,'2024-10-11',1),
                                                                                                            (1,0,7,200,'2024-10-10',2);

insert into "cryptoPrix"("prixUnitaire","dateHeure","idCrypto") values(10000,'2024-10-10T10:00:00.0',1);
insert into "cryptoPrix"("prixUnitaire","dateHeure","idCrypto") values(10000,'2024-10-10T10:00:00.0',2);
insert into "cryptoPrix"("prixUnitaire","dateHeure","idCrypto") values(20000,'2024-10-10T10:00:00.0',3);
