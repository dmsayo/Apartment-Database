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
