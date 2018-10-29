CREATE TABLE Clientes(
	ID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
	Nombre varchar(20) NOT NULL,
	Apellidos varchar(30) NOT NULL,
	FechaNac date NOT NULL,
	Ciudad varchar(20) NOT NULL,
	Direccion varchar(40) NULL,
	Telefono char(9) NULL
);

CREATE TABLE Panes(
	ID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
	Nombre char(20) NOT NULL,
	Crujenticidad int NULL,
	Integral bit NOT NULL DEFAULT 0,
	Precio int NOT NULL
);

CREATE TABLE ClientesPanes (
    IDCliente int NOT NULL,
  	IDPan int NOT NULL,
    Cantidad int NOT NULL DEFAULT 1,
    CONSTRAINT PK_ClientesPanes PRIMARY KEY(IDCliente, IDPan),
    CONSTRAINT FK_ClientesPanes_Clientes FOREIGN KEY (IDCliente) REFERENCES Clientes(ID),
    CONSTRAINT FK_ClientesPanes_Panes FOREIGN KEY (IDPan) REFERENCES Panes(ID)
);