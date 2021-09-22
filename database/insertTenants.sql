INSERT INTO Account VALUES
    ("tsawyer", "rqv+8d7#", "tsawyer@gmail.com"),
    ("adavenport", "*oDhXwGM", "adavenport@gmail.com"),
    ("rrossi", "*K~1i|$l%", "rrossi@gmail.com");
INSERT INTO Tenant VALUES
    (111222333, "Theo", "Sawyer", "1970-11-16"),
    (888999111, "Alara", "Davenport", "1979-09-20"),
    (222111999, "Reginald", "Rossi", "1981-01-11");
INSERT INTO Contract VALUES
    (6, "2019-02-03", "2021-12-12", 820.00),
    (7, "2020-05-05", "2021-02-01", 790.00),
    (8, "2020-06-06", "2021-03-21", 930.00);
INSERT INTO Utilities VALUES
    (206, 2.1),
    (207, 2.2),
    (208, 2.4);
INSERT INTO ApartmentSpace VALUES
    (9006, 7002, 8, 3, "Hardwood", "1 bedroom unit with balcony space", "clean", "no", 160),
    (9007, 7002, 9, 3, "Hardwood", "1 bedroom unit", "clean", "no", 160),
    (9008, 7002, 9, 5, "Hardwood", "2 bedroom", "clean", "no", 190);
INSERT INTO PaymentMethod VALUES
    (20030155, "2021-05-17", 2000.00),
    (20030156, "2021-05-19", 1950.00),
    (20030157, "2021-08-15", 2150.00);
INSERT INTO ETransfer VALUES
    (20030155, 6006),
    (20030156, 6007),
    (20030157, 6008);
INSERT INTO TransferInfo VALUES
    (6006, "tsawyer@gmail.com"),
    (6007, "adavenport@gmail.com"),
    (6008, "rrossi@gmail.com");
INSERT INTO Cheque VALUES
    (20030155, 1609),
    (20030156, 1610),
    (20030157, 1611);
INSERT INTO Cash VALUES
    (20030155, 100105),
    (20030156, 100106),
    (20030157, 100107);
INSERT INTO Tenant_Account VALUES
    ("Theo", "Sawyer", "tsawyer", "tsawyer@gmail.com", "6043322137", 20030155, 6, 9006, 1),
    ("Alara", "Davenport", "adavenport", "adavenport@gmail.com", "7789228317", 20030156, 7, 9007, 0),
    ("Reginald", "Rossi", "rrossi", "rrossi@gmail.com", "6045672391", 20030157, 8, 9008, 2);