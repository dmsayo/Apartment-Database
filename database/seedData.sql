INSERT INTO Facilities VALUES
    (101, 100, "8:00 AM - 8:00 PM", 10),
    (201, 100, "8:00 AM - 8:00 PM", 10),
    (301, 100, "8:00 AM - 8:00 PM", 10),
    (401, 100, "8:00 AM - 8:00 PM", 10),
    (501, 100, "8:00 AM - 8:00 PM", 10),
    (102, 50, "6:00 AM - 10:00 PM", 5),
    (202, 50, "6:00 AM - 10:00 PM", 5),
    (302, 50, "6:00 AM - 10:00 PM", 5),
    (402, 50, "6:00 AM - 10:00 PM", 5),
    (502, 50, "6:00 AM - 10:00 PM", 5),
    (103, 50, "6:00 AM - 9:00 PM", 25),
    (203, 50, "6:00 AM - 9:00 PM", 25),
    (303, 50, "6:00 AM - 9:00 PM", 25),
    (403, 50, "6:00 AM - 9:00 PM", 25),
    (503, 50, "6:00 AM - 9:00 PM", 25),
    (104, 50, "7:00 AM - 8:00 PM", 15),
    (204, 50, "7:00 AM - 8:00 PM", 15),
    (304, 50, "7:00 AM - 8:00 PM", 15),
    (404, 50, "7:00 AM - 8:00 PM", 15),
    (504, 50, "7:00 AM - 8:00 PM", 15);

INSERT INTO Account VALUES
    ("candace.shaw", ":?&h6ZdC", "c.shaw@gmail.com"),
    ("lucybauers", "%Xe3-tZc", "lucilleb@gmail.com"),
    ("reuben_spears", "X8wu[fQ6", "r_spears@gmail.com"),
    ("edempsey", "_D3r]M9?", "dempseyethan@gmail.com"),
    ("tameraw", "d,YN2Pb", "tamerawinthrop@gmail.com"),
    ("kstrong", "8Jh]P%XH", "kstrong@gmail.com"),
    ("calhouns", "9{RZq4@F", "sidracalhoun@gmail.com"),
    ("frubio", "9ahLH>VV", "filip_rubio@gmail.com"),
    ("haleynav", "@3^uJx.B", "haleynaveed@gmail.com"),
    ("mblake", "V@{mq62f", "myrtle19@gmail.com");

INSERT INTO Landlord VALUES
    (504741051, "Candace", "Shaw", "1971-05-31"),
    (622035732, "Lucille", "Bauers", "1959-10-31"),
    (660226977, "Reuben", "Spears", "1969-09-08"),
    (775369575, "Ethan", "Dempsey", "1971-02-25"),
    (892392948, "Tamera", "Winthrop", "1972-12-14");

INSERT INTO Tenant VALUES
    (777333222, "Khadija", "Strong", "1970-05-15"),
    (444222111, "Sidra", "Calhoun", "1959-06-16"),
    (111222111, "Filip", "Rubio", "1968-09-06"),
    (888333444, "Naveed", "Haley", "1969-01-27"),
    (444111666, "Myrtle", "Blake", "1970-11-16");

INSERT INTO ApartmentBuilding VALUES
    (7001, 504741051, "1837  Hillcrest Circle"),
    (7002, 622035732, "1439  Hillview Drive"),
    (7003, 660226977, "3933  Kembery Drive"),
    (7004, 775369575, "1876  University Drive"),
    (7005, 892392948, "2666  Benson Park Square");

INSERT INTO Utilities VALUES
    (201, 0.22),
    (202, 2.0),
    (203, 0.99),
    (204, 4.6),
    (205, 1.9);

INSERT INTO TenantDependant VALUES
    ("Milla", "Strong", 777333222, "1999-01-11"),
    ("Nina", "Calhoun", 444222111, "1990-02-13"),
    ("Arbaaz", "Rubio", 111222111, "1990-07-21"),
    ("Cory", "Haley", 888333444, "1999-03-22"),
    ("Ben", "Blake", 444111666, "1990-09-13");

INSERT INTO Contract VALUES
    (1, "2019-05-31", "2020-05-31", 3000.00),
    (2, "2020-06-15", "2022-06-15", 1800.00),
    (3, "2020-12-15", "2021-12-15", 980.00),
    (4, "2018-01-10", "2021-01-10", 4500.00),
    (5, "2020-07-02", "2021-01-02", 650.00);

INSERT INTO TracksUsage VALUES
    (1, 201),
    (2, 202),
    (3, 203),
    (4, 204),
    (5, 205);

INSERT INTO Book VALUES
    (777333222, 101, 1001, 3, "2021-05-01"),
    (444222111, 201, 1001, 6, "2021-05-02"),
    (111222111, 301, 1001, 5, "2021-05-03"),
    (888333444, 401, 1001, 2, "2021-05-04"),
    (444111666, 501, 1001, 2, "2021-05-05");

INSERT INTO Laundry VALUES
    (101, 1),
    (201, 2),
    (301, 3),
    (401, 4),
    (501, 5);

INSERT INTO Sauna VALUES
    (102),
    (202),
    (302),
    (402),
    (502);

INSERT INTO Pool VALUES
    (103),
    (203),
    (303),
    (403),
    (503);

INSERT INTO Gym VALUES
    (104),
    (204),
    (304),
    (404),
    (504);

INSERT INTO GymEquipment VALUES
    (1, "Treadmill"),
    (2, "Kettlebell"),
    (3, "Dumbbell Rack"),
    (4, "Bicycle"),
    (5, "45lbs. Weights");

INSERT INTO GymContains VALUES
    (104, 1),
    (104, 2),
    (104, 3),
    (104, 4),
    (104, 5),
    (204, 1),
    (204, 4),
    (204, 2),
    (204, 3),
    (304, 1),
    (304, 4),
    (404, 1),
    (404, 4),
    (504, 1),
    (504, 4);

INSERT INTO ParkingSpaces VALUES
    (1, 1, 777333222),
    (1, 2, 444222111),
    (2, 1, 111222111),
    (3, 1, 888333444),
    (4, 2, 444111666);

INSERT INTO ApartmentBuilding_Address VALUES
    ("1837  Hillcrest Circle", "North Vancouver", "BC", "Canada"),
    ("1439  Hillview Drive", "West Vancouver", "BC", "Canada"),
    ("3933  Kembery Drive", "New Westminster", "BC", "Canada"),
    ("1876  University Drive", "Coquitlam", "BC", "Canada"),
    ("2666  Benson Park Square", "Toronto", "ON", "Canada");

INSERT INTO ApartmentSpace VALUES
    (9001, 7001, 1, 3, "Hardwood", "fully furnished 1-bedroom", "clean", "yes", 130),
    (9002, 7002, 4, 6, "Hardwood", "2 bedroom unit with laundry", "clean", "no", 175),
    (9003, 7003, 3, 5, "Marble", "1 bedroom 2 baths, w/ marble flooring", "clean", "no", 150),
    (9004, 7004, 4, 7, "Carpet", "2 bedroom unit with nice kitchen", "clean", "no", 190),
    (9005, 7005, 2, 3, "Carpet", "1 bedroom", "clean", "no", 130);

INSERT INTO Gas VALUES
    (201, 47),
    (202, 51),
    (203, 89),
    (204, 20),
    (205, 21);

INSERT INTO Internet VALUES     
    (201, 100),
    (202, 75),
    (203, 60),
    (204, 80),
    (205, 95);

INSERT INTO Electricity VALUES
    (201, 88),
    (202, 12),
    (203, 45),
    (204, 10),
    (205, 99);

INSERT INTO Hydro VALUES
    (201, 25.6),
    (202, 100.2),
    (203, 10.19),
    (204, 46.9),
    (205, 50.23);

INSERT INTO PaymentMethod VALUES
    (20030150, "2021-05-01", 2000.00),
    (20030151, "2021-05-06", 1956.67),
    (20030152, "2021-05-31", 2010.10),
    (20030153, "2021-05-20", 2300.68),
    (20030154, "2021-05-16", 2100.23);

INSERT INTO ETransfer VALUES
    (20030150, 6001),
    (20030151, 6002),
    (20030152, 6003),
    (20030153, 6004),
    (20030154, 6005);

INSERT INTO TransferInfo VALUES
    (6001, "john@hotmail.com"),
    (6002, "jason@gmail.com"),
    (6003, "linda@gmail.com"),
    (6004, "barbara@hotmail.com"),
    (6005, "evan@shaw.ca");

INSERT INTO Cheque VALUES 
    (20030150, 1024),
    (20030151, 6348),
    (20030152, 2401),
    (20030153, 1003),
    (20030154, 1608);

INSERT INTO Cash VALUES 
    (20030150, 100100),
    (20030151, 100101),
    (20030152, 100102),
    (20030153, 100103),
    (20030154, 100104);

INSERT INTO Tenant_Account VALUES
    ("Khadija", "Strong", "kstrong", "kstrong@gmail.com", "6045768013", 20030150, 1, 9001, 0),
    ("Sidra", "Calhoun", "calhouns", "sidracalhoun@gmail.com", "60457893911", 20030151, 2, 9002, 0),
    ("Filip", "Rubio", "frubio", "filip_rubio@gmail.com", "6045552944", 20030152, 3, 9003, 1),
    ("Naveed", "Haley", "haleynav", "haleynaveed@gmail.com", "6045102890", 20030153, 4, 9004, 2),
    ("Myrtle", "Blake", "mblake", "myrtle19@gmail.com", "60412345796", 20030154, 5, 9005, 0);

INSERT INTO Landlord_Account VALUES
    ("Candace", "Shaw", "c.shaw@gmail.com", "6045513132", "candace.shaw"),
    ("Lucille", "Bauers", "lucilleb@gmail.com", "6040905897", "lucybauers"),
    ("Reuben", "Spears", "r_spears@gmail.com", "6043345130", "reuben_spears"),
    ("Ethan", "Dempsey", "dempseyethan@gmail.com", "6045801111", "edempsey"),
    ("Tamera", "Winthrop", "tamerawinthrop@gmail.com", "6045551234", "tameraw");
