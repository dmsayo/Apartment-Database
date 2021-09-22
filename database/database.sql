-- CREATE TABLES SQL

-- Tenant(SIN, FirstName, LastName, DateOfBirth)
CREATE TABLE Tenant(
    SIN INTEGER,
    FirstName CHAR(30),
    LastName CHAR(30),
    DateOfBirth DATE,
    PRIMARY KEY (SIN),
    CONSTRAINT unique_tenant UNIQUE(FirstName, LastName)
);

-- Landlord(SIN, FirstName, LastName, DoB)
CREATE TABLE Landlord(
    SIN INTEGER PRIMARY KEY,
    FirstName CHAR(30),
    LastName CHAR(30),
    DateOfBirth DATE,
    CONSTRAINT unique_landlord UNIQUE(FirstName, LastName)
);

-- Contract(ContractID:INTEGER, StartDate:DATE, EndDate:DATE, RentalFee:REAL)
CREATE TABLE Contract(
    ContractID INTEGER PRIMARY KEY,
    StartDate DATE,
    EndDate DATE,
    RentalFee Real
);

-- Facilities(RoomID:INTEGER, AreaSize:REAL, HoursOfOperation:CHAR(50), Capacity:INTEGER)
CREATE TABLE Facilities(
    RoomID INTEGER PRIMARY KEY,
    AreaSize REAL,
    HoursOfOperation CHAR(50),
    Capacity INTEGER  
);

-- Account(Username:CHAR(30), Password:CHAR(30), Email:CHAR(30))
CREATE TABLE Account(
       Username CHAR(30) PRIMARY KEY,
       Password CHAR(30),
       Email CHAR(30)
);

-- Utilities(PricePerUnit:REAL, UtilityID:Integer)
CREATE TABLE Utilities(
       UtilityID INTEGER PRIMARY KEY,
       PricePerUnit REAL
);

-- TenantDependant(FirstName:CHAR(30), LastName:CHAR(30), TenantSIN:INTEGER, DateOfBirth:DATE)
CREATE TABLE TenantDependant(
    FirstName CHAR(30),
    LastName CHAR(30),
    TenantSIN INTEGER,
    DateOfBirth DATE,
    PRIMARY KEY (FirstName, LastName, TenantSIN),
    FOREIGN KEY (TenantSIN) REFERENCES Tenant(SIN) ON DELETE CASCADE
);

-- TracksUsage(ContractID:INTEGER, UtilityID:INTEGER)
CREATE TABLE TracksUsage(
    ContractID INTEGER,
    UtilityID INTEGER,
    PRIMARY KEY (ContractID, UtilityID),
    FOREIGN KEY (ContractID) REFERENCES Contract(ContractID) ON DELETE CASCADE,
    FOREIGN KEY (UtilityID) REFERENCES Utilities(UtilityID) ON DELETE CASCADE
);


-- Book(TenantSIN:INTEGER, FacilityRoomID:INTEGER, BookingID:INTEGER, Duration:INTEGER, BookingDate:DATE)
CREATE TABLE Book(
    TenantSIN INTEGER,
    FacilityRoomID INTEGER,
    BookingID INTEGER,
    Duration INTEGER,
    BookingDATE DATE,
    PRIMARY KEY (TenantSIN, FacilityRoomID),
    FOREIGN KEY (TenantSIN) REFERENCES Tenant(SIN) ON DELETE CASCADE,
    FOREIGN KEY (FacilityRoomID) REFERENCES Facilities(RoomID) ON DELETE CASCADE
);

-- Laundry(RoomID:INTEGER, LaundryMachineNo:INTEGER)
CREATE TABLE Laundry(
    RoomID INTEGER PRIMARY KEY,
    LaundryMachineNo INTEGER,
    FOREIGN KEY (RoomID) REFERENCES Facilities(RoomID)
);

-- Sauna(RoomID:INTEGER)
CREATE TABLE Sauna(
    RoomID INTEGER PRIMARY KEY,
    FOREIGN KEY (RoomID) REFERENCES Facilities(RoomID)
);

-- Pool(RoomID:INTEGER)
CREATE TABLE Pool(
    RoomID INTEGER PRIMARY KEY,
    FOREIGN KEY (RoomID) REFERENCES Facilities(RoomID)
);

-- Gym(RoomID:INTEGER)
CREATE TABLE Gym(
    RoomID INTEGER PRIMARY KEY,
    FOREIGN KEY (RoomID) REFERENCES Facilities(RoomID)
);

-- GymEquipment(EquipmentID:INTEGER, Description:TEXT)
CREATE TABLE GymEquipment(
    EquipmentID INTEGER PRIMARY KEY,
    Description TEXT
);

-- GymContains(RoomID:INTEGER, GymEquipmentID:INTEGER)
CREATE TABLE GymContains(
    RoomID INTEGER,
    GymEquipmentID INTEGER,
    PRIMARY KEY (RoomID, GymEquipmentID),
    FOREIGN KEY (RoomID) REFERENCES Gym(RoomID),
    FOREIGN KEY (GymEquipmentID) REFERENCES GymEquipment(EquipmentID) 
);

-- ParkingSpaces(SpotID:INTEGER, LotNumber:INTEGER, TenantSIN:INTEGER)
CREATE TABLE ParkingSpaces (
     SpotID INTEGER,
     LotNumber INTEGER,
     TenantSIN INTEGER UNIQUE,
     PRIMARY KEY (SpotID, LotNumber),
     FOREIGN KEY (TenantSIN) REFERENCES Tenant (SIN) 
                ON DELETE CASCADE
                ON UPDATE CASCADE
);

-- ApartmentBuilding(BuildingID:INTEGER, LandlordSIN:INTEGER, Address:CHAR(50))
CREATE TABLE ApartmentBuilding(
    BuildingID INTEGER PRIMARY KEY,
    LandlordSIN INTEGER NOT NULL UNIQUE,
    Address CHAR(50) UNIQUE,
    FOREIGN KEY (LandlordSIN) REFERENCES Landlord(SIN)
);

-- ApartmentBuilding_Address(Address:CHAR(50), City:CHAR(50), Province:CHAR(2), Country:CHAR(50))
CREATE TABLE ApartmentBuilding_Address(
    Address CHAR(50) PRIMARY KEY,
    City CHAR(50),
    Province CHAR(2),
    Country CHAR(50),
    FOREIGN KEY (Address) REFERENCES ApartmentBuilding(Address)
);

-- ApartmentSpace(RoomID:INTEGER, BuildingID:INTEGER, FloorNo:INTEGER, NumberOfRooms:INTEGER, FlooringType: CHAR(40), Description:TEXT, ApartmentCondition:CHAR(100), IsFurnished:CHAR(3))
CREATE TABLE ApartmentSpace(
    RoomID INTEGER PRIMARY KEY,
    BuildingID INTEGER NOT NULL,
    FloorNo INTEGER,
    NumberOfRooms INTEGER,
    FlooringType CHAR(40),
    Description TEXT,
    ApartmentCondition CHAR(100),
    IsFurnished CHAR(3),
      AreaSize INTEGER,
    FOREIGN KEY (BuildingID) REFERENCES ApartmentBuilding(BuildingID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Gas(UtilityID:INTEGER, AmtGasConsumed:REAL)
CREATE TABLE Gas(
       UtilityID INTEGER Primary Key,
       AmtGasConsumed REAL, 
       FOREIGN KEY(UtilityID) references Utilities(UtilityID)
              ON DELETE CASCADE 
              ON UPDATE CASCADE
);

-- Internet(UtilityID:INTEGER, MonthsPaid:INTEGER)
CREATE TABLE Internet (
       UtilityID INTEGER PRIMARY KEY,
       MonthsPaid INTEGER,
       FOREIGN KEY (UtilityID) REFERENCES Utilities(UtilityID)
              ON DELETE CASCADE 
              ON UPDATE CASCADE
);

-- Electricity(UtilityID:INTEGER, kWhConsumed:REAL)
CREATE TABLE Electricity(
    UtilityID INTEGER PRIMARY KEY,
    kWhConsumed REAL,
    FOREIGN KEY (UtilityID) REFERENCES Utilities(UtilityID)
          ON UPDATE CASCADE
          ON DELETE CASCADE
);

-- Hydro(UtilityID:INTEGER, WaterConsumed:REAL)
CREATE TABLE Hydro (
       UtilityID INTEGER PRIMARY KEY,
       WaterConsumed REAL,
       FOREIGN KEY (UtilityID) REFERENCES Utilities(UtilityID)
              ON DELETE CASCADE 
              ON UPDATE CASCADE
);

-- PaymentMethod(TransactionID:INTEGER, TransactionDate:DATE, PaymentAmount:REAL)
CREATE TABLE PaymentMethod(
    TransactionID INTEGER PRIMARY KEY,
    TransactionDate DATE,
    PaymentAmount REAL
);

-- ETransfer(TransactionID: INTEGER, PayerID: INTEGER)
CREATE TABLE ETransfer (
    TransactionID INTEGER PRIMARY KEY,
    PayerID INTEGER NOT NULL UNIQUE,
    FOREIGN KEY (TransactionID) REFERENCES PaymentMethod(TransactionID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- TransferInfo(PayerID: INTEGER, PayeeEmail: CHAR(50))
CREATE TABLE TransferInfo (
       PayerID INTEGER PRIMARY KEY,
       PayeeEmail CHAR(50),
       FOREIGN KEY(PayerID) REFERENCES ETransfer (PayerID)
               ON DELETE CASCADE 
               ON UPDATE CASCADE
);

-- Cheque(TransactionID: INTEGER, ChequeNumber:INTEGER)
CREATE TABLE Cheque(
    TransactionID INTEGER PRIMARY KEY,
    ChequeNumber INTEGER,
    FOREIGN KEY (TransactionID) REFERENCES PaymentMethod(TransactionID)
);

-- Cash(TransactionID: INTEGER, ReceiptNumber: INTEGER)
CREATE TABLE Cash(
    TransactionID INTEGER PRIMARY KEY,
    ReceiptNumber INTEGER,
    FOREIGN KEY (TransactionID) REFERENCES PaymentMethod(TransactionID)
);

-- Landlord_Account(FirstName, LastName, Email, TelephoneNum, AccountUsername)
CREATE TABLE Landlord_Account(
    FirstName CHAR(30),
    LastName CHAR(30),
    Email CHAR(50),
    TelephoneNumber TEXT,
    AccountUsername CHAR(60) NOT NULL UNIQUE,
    PRIMARY KEY(FirstName, LastName),
    FOREIGN KEY(FirstName, LastName) REFERENCES Landlord(FirstName, LastName) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(AccountUsername) REFERENCES Account(Username) ON UPDATE CASCADE
);

-- Tenant_Account(FirstName, LastName, AccountUserName, Email, TelephoneNumber, NumOfIncidents, TransactionID, ContractID, ApartmentRoomID)
CREATE TABLE Tenant_Account(
    FirstName CHAR(30),
    LastName CHAR(30),
    AccountUsername CHAR(30),
    Email CHAR(50),
    TelephoneNum TEXT,
    TransactionID INTEGER,
    ContractID INTEGER NOT NULL UNIQUE,
    ApartmentRoomID INTEGER NOT NULL UNIQUE,
    NumOfIncidents INTEGER,
    PRIMARY KEY (FirstName, LastName),
    FOREIGN KEY (FirstName, LastName) REFERENCES Tenant(FirstName, LastName)
        ON DELETE CASCADE
         ON UPDATE CASCADE,
    FOREIGN KEY (ContractID) REFERENCES Contract(ContractID)
        ON DELETE NO ACTION
        ON UPDATE CASCADE,
    FOREIGN KEY (TransactionID) REFERENCES PaymentMethod(TransactionID)
        ON DELETE NO ACTION
        ON UPDATE CASCADE,
    FOREIGN KEY (AccountUsername) REFERENCES Account(Username) ON UPDATE CASCADE,
    FOREIGN KEY (ApartmentRoomID) REFERENCES ApartmentSpace(RoomID)
        ON DELETE NO ACTION
        ON UPDATE CASCADE
);

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