DROP TABLE nominas;
DROP TABLE rec_medico;
DROP TABLE asignaciones_v;
DROP TABLE asignaciones_h;
DROP TABLE gastos_combustibles;
DROP TABLE revisiones_itv;
DROP TABLE revisiones_mensuales;
DROP TABLE horarios;
DROP TABLE obras;
DROP TABLE vehiculos;
DROP TABLE trabajadores;

--secuencias
DROP SEQUENCE secuencia_nomina;
DROP SEQUENCE secuencia_rec_medico;
DROP SEQUENCE secuencia_asig_vehiculos;
DROP SEQUENCE secuencia_obras;
DROP SEQUENCE secuencia_horarios;
DROP SEQUENCE secuencia_asig_horarios;
DROP SEQUENCE secuencia_itv;
DROP SEQUENCE secuencia_rev_mensual;
DROP SEQUENCE secuencia_gastos_comb;

CREATE SEQUENCE secuencia_nomina;
CREATE SEQUENCE secuencia_rec_medico;
CREATE SEQUENCE secuencia_asig_vehiculos;
CREATE SEQUENCE secuencia_obras;
CREATE SEQUENCE secuencia_horarios;
CREATE SEQUENCE secuencia_asig_horarios;
CREATE SEQUENCE secuencia_itv;
CREATE SEQUENCE secuencia_rev_mensual;
CREATE SEQUENCE secuencia_gastos_comb;

CREATE TABLE trabajadores(
dni CHAR(9) PRIMARY KEY,
nombre VARCHAR(50) NOT NULL,
fechanac DATE NOT NULL,
email VARCHAR(30) DEFAULT NULL,
nss CHAR(12) NOT NULL,
pass VARCHAR(10) NOT NULL,
esAdmin CHAR(1) NOT NULL CHECK (esAdmin in ('T', 'F'))
);


CREATE TABLE nominas(
nid SMALLINT PRIMARY KEY,
dni CHAR(9) REFERENCES trabajadores on delete cascade,
salario NUMBER(6,2) NOT NULL,
fecha DATE DEFAULT sysdate NOT NULL,
horastrabajadas NUMBER(3) NOT NULL,
horasextra NUMBER(3) NOT NULL
);


CREATE TABLE rec_medico(
rid SMALLINT PRIMARY KEY,
dni CHAR(9) REFERENCES trabajadores on delete cascade,
fecha DATE  DEFAULT sysdate NOT NULL,
reconocimientom VARCHAR(10) DEFAULT 'NO PASADO' CHECK (reconocimientom IN ('PASADO', 'NO PASADO')),
proximoreconocimiento DATE NOT NULL
);

CREATE TABLE vehiculos(
matricula CHAR(7) PRIMARY KEY, 
modelo VARCHAR(50) NOT NULL,
color VARCHAR(30)
);

CREATE TABLE asignaciones_v(
avid SMALLINT PRIMARY KEY,
dni CHAR(9) REFERENCES trabajadores on delete cascade,
matricula CHAR(7) REFERENCES vehiculos on delete cascade,
fecharecogida DATE DEFAULT sysdate NOT NULL,
fechaentrega DATE NOT NULL 
);

CREATE TABLE obras(
obid SMALLINT PRIMARY KEY,
dnijefe CHAR(9) REFERENCES trabajadores NOT NULL,
dnioficial1 CHAR(9) REFERENCES trabajadores NOT NULL,
dnioficial2 CHAR(9) REFERENCES trabajadores,
direccion VARCHAR(60) NOT NULL,
presupuesto NUMBER(10,2),
proforma NUMBER(10,2),
costo NUMBER(10,2) NOT NULL,
fechainicio  DATE DEFAULT sysdate NOT NULL,
fechafin DATE NOT NULL,
CONSTRAINT fin_mayor_inicio CHECK (fechafin > fechainicio)
);

CREATE TABLE horarios(
hid SMALLINT PRIMARY KEY,
obid SMALLINT REFERENCES obras on delete cascade,
fecha DATE NOT NULL,
horaentrada TIMESTAMP DEFAULT to_timestamp('08:00:00', 'HH:MI:SS') NOT NULL,
horasalida TIMESTAMP,
CONSTRAINT salida_menor_entrada CHECK (horasalida > horaentrada),
horasextra SMALLINT DEFAULT 0,
costedesplazamiento NUMBER(6,2)
);

CREATE TABLE asignaciones_h(
ahid SMALLINT PRIMARY KEY,
dni CHAR(9) REFERENCES trabajadores NOT NULL,
hid SMALLINT REFERENCES horarios on delete cascade
);


CREATE TABLE gastos_combustibles(
gcid SMALLINT PRIMARY KEY,
matricula CHAR(7) REFERENCES vehiculos on delete cascade,
fecha DATE DEFAULT sysdate NOT NULL,
gasto NUMBER(6,2) NOT NULL
);

CREATE TABLE revisiones_itv(
itvid SMALLINT PRIMARY KEY,
matricula CHAR(7) REFERENCES vehiculos on delete cascade,
fecha DATE DEFAULT sysdate NOT NULL,
revisionitv VARCHAR(20) DEFAULT 'NO PASADA'  CHECK (revisionitv IN ('PASADA', 'NO PASADA')),
proximarevision DATE DEFAULT (sysdate +360) NOT NULL
);

CREATE TABLE revisiones_mensuales(
rmid SMALLINT PRIMARY KEY,
matricula CHAR(7) REFERENCES vehiculos on delete cascade,
fecha DATE DEFAULT sysdate NOT NULL, 
coste NUMBER(6,2),
kilometraje NUMBER(8,2),
revisionmensual VARCHAR(20) CHECK (revisionmensual IN ('PASADA', 'NO PASADA')),
proximarevision DATE DEFAULT (sysdate +30) NOT NULL

);

--TRIGGERS DE CODIGOS DE SECUENCIA

CREATE OR REPLACE TRIGGER generador_nominaid BEFORE INSERT ON nominas
FOR EACH ROW
BEGIN
SELECT secuencia_nomina.NEXTVAL INTO :NEW.nid FROM dual;
END;
/

CREATE OR REPLACE TRIGGER generador_recmedicoid BEFORE INSERT ON rec_medico
FOR EACH ROW
BEGIN
SELECT secuencia_rec_medico.NEXTVAL INTO :NEW.rid FROM dual;
END;
/

CREATE OR REPLACE TRIGGER generador_asignacionvid BEFORE INSERT ON asignaciones_v
FOR EACH ROW
BEGIN
SELECT secuencia_asig_vehiculos.NEXTVAL INTO :NEW.avid FROM dual;
END;
/

CREATE OR REPLACE TRIGGER generador_obrasid BEFORE INSERT ON obras
FOR EACH ROW
BEGIN
SELECT secuencia_obras.NEXTVAL INTO :NEW.obid FROM dual;
END;
/

CREATE OR REPLACE TRIGGER generador_horariosid BEFORE INSERT ON horarios
FOR EACH ROW
BEGIN
SELECT secuencia_horarios.NEXTVAL INTO :NEW.hid FROM dual;
END;
/

CREATE OR REPLACE TRIGGER generador_asignacionhid BEFORE INSERT ON asignaciones_h
FOR EACH ROW
BEGIN
SELECT secuencia_asig_horarios.NEXTVAL INTO :NEW.ahid FROM dual;
END;
/

CREATE OR REPLACE TRIGGER generador_itvid BEFORE INSERT ON revisiones_itv
FOR EACH ROW
BEGIN
SELECT secuencia_itv.NEXTVAL INTO :NEW.itvid FROM dual;
END;
/


CREATE OR REPLACE TRIGGER generador_rmid BEFORE INSERT ON revisiones_mensuales
FOR EACH ROW
BEGIN
SELECT secuencia_rev_mensual.NEXTVAL INTO :NEW.rmid FROM dual;
END;
/

CREATE OR REPLACE TRIGGER generador_gcid BEFORE INSERT ON gastos_combustibles
FOR EACH ROW
BEGIN
SELECT secuencia_gastos_comb.NEXTVAL INTO :NEW.gcid FROM dual;
END;
/






