insert into etudiant(nom,prenom,"dateNaissance") values     ('RABENARIVO','Ryan Lizka','2004-08-12'),
                                            ('RAMARO','Tahiry Kevin','2005-11-12'),
                                            ('MBOLATIANA','Rihantiana tiarintsoa','2002-10-20'),
                                            ('RAMILISON','Malko Tsilavo','2004-06-10'),
                                            ('RABEFOTAKA','Tsiory Diary Luc','2003-05-10');

insert into semestre("idSemestre",semestre) values      ('S'||nextval('seq_semestre'),'Semestre 1');
insert into semestre("idSemestre",semestre) values      ('S'||nextval('seq_semestre'),'Semestre 2');

insert into matiere("idMatiere",intitule,credit,"idSemestre") values  ('INF'||nextval('seq_matiere_inf_l1'),'Programmation procedurale',7,'S1'),
                                                        ('INF'||nextval('seq_matiere_inf_l1'),'Base de donnees relationnel',5,'S2'),
                                                        ('INF'||nextval('seq_matiere_inf_l1'),'Base administration systeme',5,'S2'),
                                                        ('INF'||nextval('seq_matiere_inf_l1'),'HTML et introduction au Web',5,'S1'),
                                                        ('INF'||nextval('seq_matiere_inf_l1'),'Maintenance materiel et logiciel',4,'S2'),
                                                        ('INF'||nextval('seq_matiere_inf_l1'),'Complement de progammation',6,'S2'),
                                                        ('INF'||nextval('seq_matiere_inf_l1'),'Informatique de base',4,'S1'),
                                                        ('MTH'||nextval('seq_matiere_math_l1'),'Arithmetique et nombre',4,'S1'),
                                                        ('MTH'||nextval('seq_matiere_math_l1'),'Analyse mathematique',6,'S1'),
                                                        ('MTH'||nextval('seq_matiere_math_l1'),'Calcul vectoriel et matriciel',6,'S2'),
                                                        ('MTH'||nextval('seq_matiere_math_l1'),'Probabilite et Statistique',4,'S2'),
                                                        ('ORG'||nextval('seq_matiere_org_l1'),'Technique de communication',4,'S1');

insert into examen("idExamen","dateExamen") values    ('EX00'||nextval('seq_examen'),'2024-01-28');
insert into examen("idExamen","dateExamen") values    ('EX00'||nextval('seq_examen'),'2024-05-27');

-- Attribution des notes aux étudiants pour les matières du Semestre 1 (EX001)
insert into examen_etudiant(id,"idMatiere", "idEtudiant", "idExamen", note,"idSemestre") values
    (nextval('seq_examen_etudiant'),'INF101', 'ETU001', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'INF104', 'ETU001', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'INF107', 'ETU001', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'MTH100', 'ETU001', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'MTH101', 'ETU001', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'ORG100', 'ETU001', 'EX001', round((random() * 20)::numeric, 2),'S1'),

    (nextval('seq_examen_etudiant'),'INF101', 'ETU002', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'INF104', 'ETU002', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'INF107', 'ETU002', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'MTH100', 'ETU002', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'MTH101', 'ETU002', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'ORG100', 'ETU002', 'EX001', round((random() * 20)::numeric, 2),'S1'),

    (nextval('seq_examen_etudiant'),'INF101', 'ETU003', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'INF104', 'ETU003', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'INF107', 'ETU003', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'MTH100', 'ETU003', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'MTH101', 'ETU003', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'ORG100', 'ETU003', 'EX001', round((random() * 20)::numeric, 2),'S1'),

    (nextval('seq_examen_etudiant'),'INF101', 'ETU004', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'INF104', 'ETU004', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'INF107', 'ETU004', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'MTH100', 'ETU004', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'MTH101', 'ETU004', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'ORG100', 'ETU004', 'EX001', round((random() * 20)::numeric, 2),'S1'),

    (nextval('seq_examen_etudiant'),'INF101', 'ETU005', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'INF104', 'ETU005', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'INF107', 'ETU005', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'MTH100', 'ETU005', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'MTH101', 'ETU005', 'EX001', round((random() * 20)::numeric, 2),'S1'),
    (nextval('seq_examen_etudiant'),'ORG100', 'ETU005', 'EX001', round((random() * 20)::numeric, 2),'S1');

-- Attribution des notes aux étudiants pour les matières du Semestre 2 (EX002)
insert into examen_etudiant(id,"idMatiere", "idEtudiant", "idExamen", note,"idSemestre") values
    (nextval('seq_examen_etudiant'),'INF102', 'ETU001', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'INF103', 'ETU001', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'INF105', 'ETU001', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'INF106', 'ETU001', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'MTH102', 'ETU001', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'MTH103', 'ETU001', 'EX002', round((random() * 20)::numeric, 2),'S2'),

    (nextval('seq_examen_etudiant'),'INF102', 'ETU002', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'INF103', 'ETU002', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'INF105', 'ETU002', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'INF106', 'ETU002', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'MTH102', 'ETU002', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'MTH103', 'ETU002', 'EX002', round((random() * 20)::numeric, 2),'S2'),

    (nextval('seq_examen_etudiant'),'INF102', 'ETU003', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'INF103', 'ETU003', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'INF105', 'ETU003', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'INF106', 'ETU003', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'MTH102', 'ETU003', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'MTH103', 'ETU003', 'EX002', round((random() * 20)::numeric, 2),'S2'),

    (nextval('seq_examen_etudiant'),'INF102', 'ETU004', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'INF103', 'ETU004', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'INF105', 'ETU004', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'INF106', 'ETU004', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'MTH102', 'ETU004', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'MTH103', 'ETU004', 'EX002', round((random() * 20)::numeric, 2),'S2'),

    (nextval('seq_examen_etudiant'),'INF102', 'ETU005', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'INF103', 'ETU005', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'INF105', 'ETU005', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'INF106', 'ETU005', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'MTH102', 'ETU005', 'EX002', round((random() * 20)::numeric, 2),'S2'),
    (nextval('seq_examen_etudiant'),'MTH103', 'ETU005', 'EX002', round((random() * 20)::numeric, 2),'S2');

insert into inscription("idInscription","dateInscription","idSemestre","idEtudiant") values('INS000'||nextval('seq_inscription'),'2024-10-10','S1','ETU005');