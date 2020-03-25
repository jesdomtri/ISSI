--PROCEDICIMIENTOS DE INSERCION
CREATE OR REPLACE PROCEDURE contratar_trabajador (
    w_dni        IN trabajadores.dni%TYPE,
    w_nombre     IN trabajadores.nombre%TYPE,
    w_fechanac   IN trabajadores.fechanac%TYPE,
    w_email      IN trabajadores.email%TYPE,
    w_nss        IN trabajadores.nss%TYPE,
    w_pass      IN trabajadores.pass%TYPE,
    w_esAdmin IN trabajadores.esAdmin%TYPE
)
    IS
BEGIN
    INSERT INTO trabajadores VALUES (
        w_dni,
        w_nombre,
        w_fechanac,
        w_email,
        w_nss,
        w_pass,
        w_esAdmin
    );

    COMMIT WORK;
END;
/

CREATE OR REPLACE PROCEDURE nuevo_recmedico (
    w_dni               IN rec_medico.dni%TYPE,
    w_fecha             IN rec_medico.fecha%TYPE,
    w_reconocimientom   IN rec_medico.reconocimientom%TYPE
)
    IS
BEGIN
    INSERT INTO rec_medico (
        dni,
        fecha,
        reconocimientom,
        proximoreconocimiento
    ) VALUES (
        w_dni,
        w_fecha,
        w_reconocimientom,
        add_months(w_fecha,12)
    );

    COMMIT WORK;
END;
/


CREATE OR REPLACE FUNCTION horas_totales (
    w_dni     IN nominas.dni%TYPE,
    w_fecha   IN nominas.fecha%TYPE
) RETURN SMALLINT IS

    w_horastotales   SMALLINT;
    CURSOR c1 IS SELECT
        fecha,
        horaentrada,
        horasalida
                 FROM
        horarios h,
        asignaciones_h ah
                 WHERE
        h.hid = ah.hid
        AND   ah.dni = w_dni;

    w_horasdiarias   SMALLINT;
BEGIN
    w_horastotales := 0;
    w_horasdiarias := 0;
    FOR fila IN c1 LOOP
        IF
            extract ( MONTH FROM fila.fecha ) = extract ( MONTH FROM w_fecha ) AND extract ( YEAR FROM fila.fecha ) = extract ( YEAR FROM w_fecha )
        THEN
            w_horasdiarias := extract ( HOUR FROM fila.horasalida ) - extract ( HOUR FROM fila.horaentrada );

            w_horastotales := w_horastotales + w_horasdiarias;
        END IF;
    END LOOP;

    return(w_horastotales);
END;
/

CREATE OR REPLACE FUNCTION horas_extra_totales (
    w_dni     IN nominas.dni%TYPE,
    w_fecha   IN nominas.fecha%TYPE
) RETURN SMALLINT IS

    w_horas_extra_totales   SMALLINT;
    CURSOR c1 IS SELECT
        fecha,
        horasextra
                 FROM
        horarios h,
        asignaciones_h ah
                 WHERE
        h.hid = ah.hid
        AND   ah.dni = w_dni;

BEGIN
    w_horas_extra_totales := 0;
    FOR fila IN c1 LOOP
        IF
            extract ( MONTH FROM fila.fecha ) = extract ( MONTH FROM w_fecha ) AND extract ( YEAR FROM fila.fecha ) = extract ( YEAR FROM w_fecha )
        THEN
            w_horas_extra_totales := fila.horasextra + w_horas_extra_totales;
        END IF;
    END LOOP;

    RETURN w_horas_extra_totales;
END;
/

CREATE OR REPLACE FUNCTION calcular_salario(
    horas_totales SMALLINT, 
    horas_extras_totales SMALLINT)
    RETURN  NUMBER IS
    
    w_salario  NUMBER;
    
    BEGIN
    
        w_salario := (horas_totales - horas_extras_totales)*8 + horas_extras_totales*10;
    
return w_salario;



END;
/

CREATE OR REPLACE PROCEDURE nueva_nomina (
    w_dni       IN nominas.dni%TYPE,
    w_fecha     IN nominas.fecha%TYPE
)
    IS
BEGIN
    INSERT INTO nominas (
        dni,
        salario,
        fecha,
        horastrabajadas,
        horasextra
    ) VALUES (
        w_dni,
        calcular_salario(horas_totales(w_dni,w_fecha),
        horas_extra_totales(w_dni,w_fecha)),
        w_fecha,
        horas_totales(w_dni,w_fecha),
        horas_extra_totales(w_dni,w_fecha)
    );

    COMMIT WORK;
END;
/

CREATE OR REPLACE PROCEDURE nueva_obra (
    w_dnijefe       IN obras.dnijefe%TYPE,
    w_dnioficial1   IN obras.dnioficial1%TYPE,
    w_dnioficial2   IN obras.dnioficial2%TYPE,
    w_direccion     IN obras.direccion%TYPE,
    w_presupuesto   IN obras.presupuesto%TYPE,
    w_proforma      IN obras.proforma%TYPE,
    w_costo         IN obras.costo%TYPE,
    w_fechainicio   IN obras.fechainicio%TYPE,
    w_fechafin      IN obras.fechafin%TYPE
)
    IS
BEGIN
    INSERT INTO obras (
        dnijefe,
        dnioficial1,
        dnioficial2,
        direccion,
        presupuesto,
        proforma,
        costo,
        fechainicio,
        fechafin
    ) VALUES (
        w_dnijefe,
        w_dnioficial1,
        w_dnioficial2,
        w_direccion,
        w_presupuesto,
        w_proforma,
        w_costo,
        w_fechainicio,
        w_fechafin
    );

    COMMIT WORK;
END;
/

CREATE OR REPLACE PROCEDURE nueva_asignacionh (
    w_dni   IN asignaciones_h.dni%TYPE,
    w_hid   IN asignaciones_h.hid%TYPE
)
    IS
BEGIN
    INSERT INTO asignaciones_h (
        dni,
        hid
    ) VALUES (
        w_dni,
        w_hid
    );

    COMMIT WORK;
END;
/

CREATE OR REPLACE FUNCTION horas_extras_diarias (
    w_horaentrada   IN horarios.horaentrada%TYPE,
    w_horasalida    IN horarios.horasalida%TYPE
) RETURN SMALLINT IS
    w_horas_extras   SMALLINT;
BEGIN
    w_horas_extras := ( extract ( HOUR FROM w_horasalida ) - extract ( HOUR FROM w_horaentrada ) ) - 8;

    IF
        w_horas_extras < 0
    THEN
        w_horas_extras := 0;
    END IF;
    RETURN w_horas_extras;
END;
/

CREATE OR REPLACE PROCEDURE nuevo_horario (
    w_obid                  IN horarios.obid%TYPE,
    w_fecha                 IN horarios.fecha%TYPE,
    w_horaentrada           IN horarios.horaentrada%TYPE,
    w_horasalida            IN horarios.horasalida%TYPE,
    w_costedesplazamiento   IN horarios.costedesplazamiento%TYPE
)
    IS
BEGIN
    INSERT INTO horarios (
        obid,
        fecha,
        horaentrada,
        horasalida,
        horasextra,
        costedesplazamiento
    ) VALUES (
        w_obid,
        w_fecha,
        w_horaentrada,
        w_horasalida,
        horas_extras_diarias(w_horaentrada,w_horasalida),
        w_costedesplazamiento
    );

    COMMIT WORK;
END;
/

CREATE OR REPLACE PROCEDURE nuevo_vehiculo (
    w_matricula   IN vehiculos.matricula%TYPE,
    w_modelo      IN vehiculos.modelo%TYPE,
    w_color       IN vehiculos.color%TYPE
)
    IS
BEGIN
    INSERT INTO vehiculos VALUES (
        w_matricula,
        w_modelo,
        w_color
    );
    COMMIT WORK;
    proxRevision(w_matricula);
END;
/

CREATE OR REPLACE PROCEDURE nueva_revisionitv (
    w_matricula     IN revisiones_itv.matricula%TYPE,
    w_fecha         IN revisiones_itv.fecha%TYPE,
    w_revisionitv   IN revisiones_itv.revisionitv%TYPE
)
    IS
BEGIN
    INSERT INTO revisiones_itv (
        matricula,
        fecha,
        revisionitv,
        proximarevision
    ) VALUES (
        w_matricula,
        w_fecha,
        w_revisionitv,
        add_months(w_fecha,24)
    );

    COMMIT WORK;
END;
/

CREATE OR REPLACE PROCEDURE nueva_revisionmensual (
    w_matricula     IN revisiones_mensuales.matricula%TYPE,
    w_fecha         IN revisiones_mensuales.fecha%TYPE,
    w_coste         IN revisiones_mensuales.coste%TYPE,
    w_kilometraje   IN revisiones_mensuales.kilometraje%TYPE
)
    IS
BEGIN
    IF
        ( add_months(w_fecha,1) - SYSDATE ) > 0
    THEN
        INSERT INTO revisiones_mensuales (
            matricula,
            fecha,
            coste,
            kilometraje,
            revisionmensual,
            proximarevision
        ) VALUES (
            w_matricula,
            w_fecha,
            w_coste,
            w_kilometraje,
            'PASADA',
            add_months(w_fecha,1)
        );

    ELSE
        INSERT INTO revisiones_mensuales (
            matricula,
            fecha,
            coste,
            kilometraje,
            revisionmensual,
            proximarevision
        ) VALUES (
            w_matricula,
            w_fecha,
            w_coste,
            w_kilometraje,
            'NO PASADA',
            add_months(w_fecha,1)
        );

    END IF;

    COMMIT WORK;
END;
/

CREATE OR REPLACE FUNCTION CALCULA_GASTOS_COMB(W_MATRICULA IN GASTOS_COMBUSTIBLES.MATRICULA%TYPE,W_FECHA IN GASTOS_COMBUSTIBLES.FECHA%TYPE ) RETURN NUMBER IS
W_GASTOSTOTAL NUMBER(6,2);
W_GASTOS NUMBER(6,2);

CURSOR CUR IS SELECT DNI FROM ASIGNACIONES_V AV WHERE AV.MATRICULA = W_MATRICULA AND 
( EXTRACT(MONTH FROM AV.FECHARECOGIDA) = EXTRACT (MONTH FROM W_FECHA) OR EXTRACT(MONTH FROM AV.FECHAENTREGA) = EXTRACT (MONTH FROM W_FECHA))  ;
BEGIN
    W_GASTOS :=0;
    W_GASTOSTOTAL :=0;
    FOR FILA IN CUR LOOP
        SELECT SUM(COSTEDESPLAZAMIENTO) INTO W_GASTOS FROM ASIGNACIONES_H AH NATURAL JOIN HORARIOS H WHERE AH.DNI=FILA.DNI AND 
            EXTRACT(MONTH FROM H.FECHA) = EXTRACT (MONTH FROM W_FECHA);
        W_GASTOSTOTAL := W_GASTOSTOTAL + W_GASTOS;
    END LOOP;
    RETURN W_GASTOSTOTAL;
END;
/

CREATE OR REPLACE PROCEDURE nuevo_gastoscombustibles (
    w_matricula   IN gastos_combustibles.matricula%TYPE,
    w_fecha       IN gastos_combustibles.fecha%TYPE
)
    IS
BEGIN
    INSERT INTO gastos_combustibles (
        matricula,
        fecha,
        gasto
    ) VALUES (
        w_matricula,
        w_fecha,
        CALCULA_GASTOS_COMB(W_MATRICULA, W_FECHA)
    );

    COMMIT WORK;
END;
/

CREATE OR REPLACE PROCEDURE nueva_asignacionv (
    w_dni             IN asignaciones_v.dni%TYPE,
    w_matricula       IN asignaciones_v.matricula%TYPE,
    w_fecharecogida   IN asignaciones_v.fecharecogida%TYPE,
    w_fechaentrega    IN asignaciones_v.fechaentrega%TYPE
)
    IS
BEGIN
    INSERT INTO asignaciones_v (
        dni,
        matricula,
        fecharecogida,
        fechaentrega
    ) VALUES (
        w_dni,
        w_matricula,
        w_fecharecogida,
        w_fechaentrega
    );

    COMMIT WORK;
END;
/

--TRIGGERS REGLAS DE NEGOCIO

--RN 1.0
CREATE OR REPLACE TRIGGER PEON_ANTES_OFICIAL1 BEFORE INSERT ON OBRAS
FOR EACH ROW
DECLARE 
NUM_OBRAS SMALLINT;
TOTAL_OBRAS SMALLINT;
BEGIN
SELECT COUNT (DISTINCT H.OBID) INTO NUM_OBRAS FROM ASIGNACIONES_H AH NATURAL JOIN HORARIOS H WHERE AH.DNI = :NEW.DNIOFICIAL1 ; 
SELECT COUNT(*) INTO TOTAL_OBRAS FROM OBRAS;
    IF (NUM_OBRAS < 2 AND TOTAL_OBRAS > 2) THEN
        RAISE_APPLICATION_ERROR(-20100, 'El trabajador ' || :NEW.DNIOFICIAL1 || ' no puede ser Oficial1, no ha sido peon 2 veces' );
   
    END IF;

END;
/


--RN 1.1
CREATE OR REPLACE TRIGGER PEON_ANTES_OFICIAL2 BEFORE INSERT ON OBRAS
FOR EACH ROW
DECLARE 
NUM_OBRAS SMALLINT;
TOTAL_OBRAS SMALLINT;
BEGIN
    IF (:NEW.DNIOFICIAL2 IS NOT NULL) THEN
       SELECT COUNT (DISTINCT H.OBID) INTO NUM_OBRAS FROM ASIGNACIONES_H AH NATURAL JOIN HORARIOS H WHERE AH.DNI = :NEW.DNIOFICIAL2;
        SELECT COUNT(*) INTO TOTAL_OBRAS FROM OBRAS;
        
            IF(NUM_OBRAS < 2 AND TOTAL_OBRAS > 2) THEN
            RAISE_APPLICATION_ERROR(-20101, 'El trabajador ' || :NEW.DNIOFICIAL2 || ' no puede ser Oficial2, no ha sido peon 2 veces');
            END IF;
    END IF;
    
END;
/


CREATE OR REPLACE TRIGGER VEHICULO_EMPLEADO BEFORE INSERT ON ASIGNACIONES_V
FOR EACH ROW
DECLARE

CURSOR CUR IS SELECT DNI, FECHAENTREGA FROM ASIGNACIONES_V;

BEGIN 
    FOR FILA IN CUR LOOP
        IF (:NEW.DNI = FILA.DNI) AND ((FILA.FECHAENTREGA - :NEW.FECHARECOGIDA)>0) THEN
        RAISE_APPLICATION_ERROR(-20102, 'El empleado ' ||:NEW.DNI ||' no puede tener más de un vehículo asginado');
        END IF;
    END LOOP;

END;
/



CREATE OR REPLACE TRIGGER HORARIO_EXCEDIDO_OBRA BEFORE INSERT ON HORARIOS
FOR EACH ROW
DECLARE
W_FECHAFINOBRA DATE;
BEGIN
    SELECT FECHAFIN INTO W_FECHAFINOBRA FROM OBRAS O WHERE :NEW.OBID = O.OBID;
        IF (:NEW.FECHA - W_FECHAFINOBRA) > 0  THEN
            RAISE_APPLICATION_ERROR(-20103, 'El horario asignado a la obra ' 
            ||:NEW.OBID ||' no puede tener una fecha mayor a la fecha fin de la obra');
        END IF;
END;
/



CREATE OR REPLACE FUNCTION DIAS_PROXIMORECONOCIMIENTO(W_DNI IN TRABAJADORES.DNI%TYPE) RETURN SMALLINT IS 
W_DIAS SMALLINT;
CURSOR C1 IS SELECT FECHA, PROXIMORECONOCIMIENTO FROM REC_MEDICO WHERE  REC_MEDICO.DNI = W_DNI ORDER BY (PROXIMORECONOCIMIENTO) DESC;

BEGIN
    FOR FILA IN C1 LOOP

        IF(C1%ROWCOUNT = 1) THEN 
         W_DIAS := (FILA.PROXIMORECONOCIMIENTO - SYSDATE);
        END IF;
         
    END LOOP;
    
RETURN (W_DIAS);    
END;
/

CREATE OR REPLACE FUNCTION DIAS_PROXIMAREVISION(W_MATRICULA IN VEHICULOS.MATRICULA%TYPE) RETURN SMALLINT IS 
W_DIAS SMALLINT;
CURSOR C1 IS SELECT FECHA, PROXIMAREVISION FROM REVISIONES_MENSUALES R WHERE  R.MATRICULA = W_MATRICULA ORDER BY (PROXIMAREVISION) DESC;

BEGIN
    FOR FILA IN C1 LOOP

        IF(C1%ROWCOUNT = 1) THEN 
         W_DIAS := (FILA.PROXIMAREVISION - SYSDATE);
        END IF;
         
    END LOOP;
    
RETURN (W_DIAS);    
END;
/

CREATE OR REPLACE TRIGGER VEHICULO_ASIGNADO_MENOREDAD BEFORE INSERT ON ASIGNACIONES_V
FOR EACH ROW
DECLARE
W_FECHANAC DATE;
BEGIN
    SELECT FECHANAC INTO W_FECHANAC FROM TRABAJADORES T WHERE :NEW.DNI = T.DNI;
        IF (ADD_MONTHS(W_FECHANAC, 216) - SYSDATE) > 0 THEN
            RAISE_APPLICATION_ERROR(-20104,' Un menor de edad no puede utilizar un vehiculo' );
        END IF;
END;
/


CREATE OR REPLACE TRIGGER TRABAJADOR_MAYOR_DE16 BEFORE INSERT ON TRABAJADORES
FOR EACH ROW
BEGIN
    IF (ADD_MONTHS(:NEW.FECHANAC, 192) - SYSDATE) > 0 THEN
            RAISE_APPLICATION_ERROR(-20104,'Un trabajador debe tener al menos 16 años' );
        END IF;
END;
/


CREATE OR REPLACE TRIGGER diez_horas_maximas BEFORE
    INSERT ON asignaciones_h
    FOR EACH ROW
DECLARE
    w_res           SMALLINT;
    w_dia           DATE;
    w_horaentrada   SMALLINT;
    w_horasalida    SMALLINT;
    CURSOR cur IS SELECT
        ho.horaentrada,
        ho.horasalida,
        ho.fecha
                  FROM
        asignaciones_h ah
        NATURAL JOIN horarios ho
                  WHERE
        ah.dni =:new.dni;

BEGIN
    SELECT
        fecha
    INTO
        w_dia
    FROM
        horarios
    WHERE
        hid =:new.hid;

    SELECT
        EXTRACT(HOUR FROM horaentrada)
    INTO
        w_horaentrada
    FROM
        horarios
    WHERE
        hid =:new.hid;

    SELECT
        EXTRACT(HOUR FROM horasalida)
    INTO
        w_horasalida
    FROM
        horarios
    WHERE
        hid =:new.hid;

    w_res := w_horasalida - w_horaentrada;
    FOR fila IN cur LOOP
        IF
            ( fila.fecha = w_dia )
        THEN
            w_res := w_res + extract ( HOUR FROM fila.horasalida ) - extract ( HOUR FROM fila.horaentrada );

            IF
                ( w_res ) > 10
            THEN
                raise_application_error(-20105,'Un trabajador no puede tener mas de 10 horas asignadas');
            END IF;
        END IF;
    END LOOP;

END;
/

CREATE OR REPLACE TRIGGER NOMASUNAREVISION BEFORE INSERT ON REVISIONES_ITV
FOR EACH ROW
DECLARE
CURSOR cur IS SELECT R.matricula, R.revisionitv FROM revisiones_itv R WHERE R.matricula = :new.matricula;
BEGIN
    FOR fila IN cur LOOP
        IF(fila.revisionitv = 'NO PASADA') THEN
            raise_application_error(-20187,'Un vehiculo no puede tener mas de una revision en no pasada');
        END IF;
    END LOOP;
END;
/

CREATE OR REPLACE PROCEDURE proxRevision (
    w_matricula     IN revisiones_itv.matricula%TYPE
)
    IS
BEGIN
    INSERT INTO revisiones_itv (
        matricula,
        fecha,
        revisionitv,
        proximarevision
    ) VALUES (
        w_matricula,
        SYSDATE,
        'NO PASADA',
        add_months(SYSDATE,24)
    );

    COMMIT WORK;
END;
/


