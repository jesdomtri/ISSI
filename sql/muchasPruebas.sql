EXECUTE contratar_trabajador('12345678A','Paco Sanchez',TO_DATE('1986-01-01 ','YYYY-MM-DD '),'pacosan@gmail.com','012345678900','12345','F');
EXECUTE contratar_trabajador('12345678B','Angel Loaiza',TO_DATE('1997-06-03 ','YYYY-MM-DD '),'angel@gmail.com','012345678900','12345','F');
EXECUTE contratar_trabajador('12345678C','Amaro Garcia',TO_DATE('1990-01-08 ','YYYY-MM-DD '),'amaro@gmail.com','012345678900','12345','T');
EXECUTE contratar_trabajador('12345678D','Jaime Onaindia',TO_DATE('1994-12-12 ','YYYY-MM-DD '),'jaimeona@gmail.com','012345678900','12345','F');
EXECUTE contratar_trabajador('12345678E','Jesus Dominguez',TO_DATE('1997-8-1 ','YYYY-MM-DD '),'jesus@gmail.com','012345678900','12345','T');
EXECUTE contratar_trabajador('12345678F','Luis Perez',TO_DATE('1986-01-01 ','YYYY-MM-DD '),'luis@gmail.com','012345678900','12345','F');
EXECUTE contratar_trabajador('12345678G','Alfonso Rivera',TO_DATE('1997-06-03 ','YYYY-MM-DD '),'alfonso@gmail.com','012345678900','12345','F');
EXECUTE contratar_trabajador('12345678H','Antonio Dominguez',TO_DATE('1990-01-08 ','YYYY-MM-DD '),'antonio@gmail.com','012345678900','12345','T');
EXECUTE contratar_trabajador('12345678I','Francisco Batista',TO_DATE('1994-12-12 ','YYYY-MM-DD '),'francisco@gmail.com','012345678900','12345','F');
EXECUTE contratar_trabajador('12345678J','Victor Roble',TO_DATE('1997-8-1 ','YYYY-MM-DD '),'victor@gmail.com','012345678900','12345','T');

EXECUTE nueva_obra('12345678A', '12345678B', NULL, 'AVENIDA REINA MERCEDES S/N', 1000,1500, 2000, TO_DATE('2010-01-01 ','YYYY-MM-DD '), TO_DATE('2010-12-31 ','YYYY-MM-DD '));
EXECUTE nueva_obra('12345678C', '12345678D', '12345678E', 'CALLE TOMARES 14', 5000,5500, 5300, TO_DATE('2018-05-05 ','YYYY-MM-DD '), TO_DATE('2019-05-05 ','YYYY-MM-DD '));
EXECUTE nueva_obra('12345678F', '12345678G', '12345678H', 'CALLE CALAMAR 1', 1111,2222, 3333, TO_DATE('2019-05-05 ','YYYY-MM-DD '), TO_DATE('2019-10-10 ','YYYY-MM-DD '));
/*EXECUTE nueva_obra('12345678I', '12345678J', NULL, 'CALLE CARPA 4', 4352,7896, 6789, TO_DATE('2020-02-05 ','YYYY-MM-DD '), TO_DATE('2021-05-05 ','YYYY-MM-DD '));*/

EXECUTE nuevo_horario(1,TO_DATE('2010-12-01 ','YYYY-MM-DD '), to_timestamp('08:00:00', 'HH24:MI:SS'),to_timestamp('11:00:00', 'HH24:MI:SS') , 10);
EXECUTE nuevo_horario(1,TO_DATE('2010-12-01 ','YYYY-MM-DD '), to_timestamp('12:00:00', 'HH24:MI:SS'),to_timestamp('17:00:00', 'HH24:MI:SS') , 12);

EXECUTE nuevo_horario(1,TO_DATE('2010-05-01 ','YYYY-MM-DD '), to_timestamp('12:00:00', 'HH24:MI:SS'),to_timestamp('18:00:00', 'HH24:MI:SS') , 12);
EXECUTE nuevo_horario(1,TO_DATE('2010-07-01 ','YYYY-MM-DD '), to_timestamp('07:00:00', 'HH24:MI:SS'),to_timestamp('12:00:00', 'HH24:MI:SS') , 12);
EXECUTE nuevo_horario(1,TO_DATE('2010-09-01 ','YYYY-MM-DD '), to_timestamp('09:00:00', 'HH24:MI:SS'),to_timestamp('15:00:00', 'HH24:MI:SS') , 12);


EXECUTE nuevo_horario(2,TO_DATE('2018-05-05 ','YYYY-MM-DD '), to_timestamp('08:00:00', 'HH24:MI:SS'),to_timestamp('14:00:00', 'HH24:MI:SS') , 6);
EXECUTE nuevo_horario(2,TO_DATE('2018-10-10 ','YYYY-MM-DD '), to_timestamp('14:00:00', 'HH24:MI:SS'),to_timestamp('16:00:00', 'HH24:MI:SS') , 4);
EXECUTE nuevo_horario(2,TO_DATE('2018-12-12 ','YYYY-MM-DD '), to_timestamp('09:00:00', 'HH24:MI:SS'),to_timestamp('11:00:00', 'HH24:MI:SS') , 7);
EXECUTE nuevo_horario(2,TO_DATE('2018-12-13 ','YYYY-MM-DD '), to_timestamp('18:00:00', 'HH24:MI:SS'),to_timestamp('21:00:00', 'HH24:MI:SS') , 17);
EXECUTE nuevo_horario(2,TO_DATE('2018-12-14 ','YYYY-MM-DD '), to_timestamp('13:00:00', 'HH24:MI:SS'),to_timestamp('20:00:00', 'HH24:MI:SS') , 11);
EXECUTE nuevo_horario(3,TO_DATE('2019-07-14 ','YYYY-MM-DD '), to_timestamp('10:00:00', 'HH24:MI:SS'),to_timestamp('16:00:00', 'HH24:MI:SS') , 8);
EXECUTE nuevo_horario(3,TO_DATE('2019-08-08 ','YYYY-MM-DD '), to_timestamp('08:00:00', 'HH24:MI:SS'),to_timestamp('12:00:00', 'HH24:MI:SS') , 8);
EXECUTE nuevo_horario(3,TO_DATE('2019-09-09 ','YYYY-MM-DD '), to_timestamp('09:00:00', 'HH24:MI:SS'),to_timestamp('14:00:00', 'HH24:MI:SS') , 8);

EXECUTE nueva_asignacionh('12345678A', 1);
EXECUTE nueva_asignacionh('12345678A', 2);
EXECUTE nueva_asignacionh('12345678A', 3);
EXECUTE nueva_asignacionh('12345678A', 4);
EXECUTE nueva_asignacionh('12345678A', 5);
EXECUTE nueva_asignacionh('12345678A', 6);

EXECUTE nueva_asignacionh('12345678B', 1);
EXECUTE nueva_asignacionh('12345678B', 2);
EXECUTE nueva_asignacionh('12345678B', 3);
EXECUTE nueva_asignacionh('12345678B', 4);
EXECUTE nueva_asignacionh('12345678B', 5);
EXECUTE nueva_asignacionh('12345678B', 6);


EXECUTE nueva_asignacionh('12345678C', 6);
EXECUTE nueva_asignacionh('12345678D', 7);
EXECUTE nueva_asignacionh('12345678E', 8);
EXECUTE nueva_asignacionh('12345678E', 9);
EXECUTE nueva_asignacionh('12345678E', 10);
EXECUTE nueva_asignacionh('12345678F', 11);
EXECUTE nueva_asignacionh('12345678G', 12);
EXECUTE nueva_asignacionh('12345678H', 13);

EXECUTE nueva_nomina('12345678A', TO_DATE('2010-12-02 ','YYYY-MM-DD '));
EXECUTE nueva_nomina('12345678B', TO_DATE('2010-12-02 ','YYYY-MM-DD '));
EXECUTE nueva_nomina('12345678C', TO_DATE('2018-05-10 ','YYYY-MM-DD '));
EXECUTE nueva_nomina('12345678D', TO_DATE('2018-10-15 ','YYYY-MM-DD '));
EXECUTE nueva_nomina('12345678E', TO_DATE('2018-12-20 ','YYYY-MM-DD '));

EXECUTE nuevo_vehiculo('1234ABC', 'FORD FIESTA', 'NEGRO');
EXECUTE nuevo_vehiculo('5678XYZ', 'PEUGEOT BOXER', 'BLANCO');
EXECUTE nuevo_vehiculo('9876JKL', 'FORD TRANSIT', 'AZUL');
EXECUTE nuevo_vehiculo('4567GBV', 'SEAT IBIZA', 'NEGRO');
EXECUTE nuevo_vehiculo('2364HBV', 'PEUGEOT 2008', 'NEGRO');
EXECUTE nuevo_vehiculo('9612DEF', 'PEUGEOT 3008', 'BLANCO');

EXECUTE nueva_asignacionv('12345678A', '1234ABC',TO_DATE('2010-12-01 ','YYYY-MM-DD '), TO_DATE('2010-12-02 ','YYYY-MM-DD ')); 
EXECUTE nueva_asignacionv('12345678B', '5678XYZ',TO_DATE('2010-12-01 ','YYYY-MM-DD '), TO_DATE('2010-12-02 ','YYYY-MM-DD ')); 
EXECUTE nueva_asignacionv('12345678D', '9876JKL',TO_DATE('2018-10-10 ','YYYY-MM-DD '), TO_DATE('2018-10-11 ','YYYY-MM-DD ')); 
EXECUTE nueva_asignacionv('12345678E', '4567GBV',TO_DATE('2018-10-12 ','YYYY-MM-DD '), TO_DATE('2018-10-13 ','YYYY-MM-DD ')); 
EXECUTE nueva_asignacionv('12345678F', '2364HBV',TO_DATE('2019-07-14 ','YYYY-MM-DD '), TO_DATE('2019-07-17 ','YYYY-MM-DD ')); 
EXECUTE nueva_asignacionv('12345678G', '9612DEF',TO_DATE('2019-08-08 ','YYYY-MM-DD '), TO_DATE('2019-08-10 ','YYYY-MM-DD ')); 


EXECUTE nuevo_recmedico('12345678A', TO_DATE('2018-01-01 ','YYYY-MM-DD '), 'PASADO');
EXECUTE nuevo_recmedico('12345678B', TO_DATE('2018-01-01 ','YYYY-MM-DD '), 'PASADO');
EXECUTE nuevo_recmedico('12345678C', TO_DATE('2018-01-01 ','YYYY-MM-DD '), 'PASADO');
EXECUTE nuevo_recmedico('12345678D', TO_DATE('2018-01-01 ','YYYY-MM-DD '), 'PASADO');
EXECUTE nuevo_recmedico('12345678E', TO_DATE('2018-01-01 ','YYYY-MM-DD '), 'PASADO');
EXECUTE nuevo_recmedico('12345678F', TO_DATE('2018-01-01 ','YYYY-MM-DD '), 'PASADO');
EXECUTE nuevo_recmedico('12345678G', TO_DATE('2018-01-01 ','YYYY-MM-DD '), 'PASADO');
EXECUTE nuevo_recmedico('12345678H', TO_DATE('2018-01-01 ','YYYY-MM-DD '), 'PASADO');
EXECUTE nuevo_recmedico('12345678I', TO_DATE('2018-01-01 ','YYYY-MM-DD '), 'PASADO');
EXECUTE nuevo_recmedico('12345678J', TO_DATE('2018-01-01 ','YYYY-MM-DD '), 'PASADO');