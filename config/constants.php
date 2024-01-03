<?php

if (!defined("TIPOS_INGRESO")) {
    define('TIPOS_INGRESO', [
        'NI' => 'NUEVO INGRESO',
        'PI' => 'PRIMER INGRESO',
        'RO' => 'REPETIDOR',
        'RI' => 'REINSCRIPCIÓN',
        'RE' => 'REINGRESO',
        'EQ' => 'REVALIDACIÓN',
        'OY' => 'OYENTE',
        'XX' => 'OTRO',
    ]);
}

if (!defined("PLANES_PAGO")) {
    define('PLANES_PAGO', [
        'N' => 'NORMAL - 10 MESES',
        'A' => 'ANTICIPO CRÉDITO',
        'O' => '11 MESES',
        'D' => '12 MESES',
    ]);
}

if (!defined("ESTADO_CURSO")) {
    define('ESTADO_CURSO', [
        'P' => 'PREINSCRITO',
        'R' => 'REGULAR',
        'C' => 'CONDICIONADO',
        'A' => 'CONDICIONADO 2',
        'B' => 'BAJA',
    ]);
}

if (!defined("TIPOS_BECA")) {
    define('TIPOS_BECA', [
        'S' => 'SEP',
        'C' => 'CONSEJO',
        'H' => 'HERMANOS',
        'E' => 'EMPLEADO',
        'F' => 'FERNANDO PONCE',
        'R' => 'RECOMENDACIÓN',
        'L' => 'LIGA A.S.',
        'X' => 'EXCELENCIA',
        'T' => 'LEALTAD',
    ]);
}

if (!defined("SI_NO")) {
    define('SI_NO', [
        'S' => 'SI',
        'N' => 'NO',
    ]);
}

if (!defined("ESTADO_SOLICITUD")) {
    define('ESTADO_SOLICITUD', [
        'P' => 'PAGADO',
        'N' => 'PENDIENTE PAGO',
        'C' => 'CANCELADO',
    ]);
}

if (!defined("ESTADO_ACUERDO_PLAN")) {
    define("ESTADO_ACUERDO_PLAN", [
        'N' => 'NUEVO O ACTUAL',
        'L' => 'LIQUIDACIÓN',
        'C' => 'CERRADO',
        'X' => 'EXTRAOFICIAL'
    ]);
}
if (!defined("FORMULARIOS_ALUMNOS")) {
    define("FORMULARIOS_ALUMNOS", true);
}

// if (!defined("EVALUACION_DOCENTE")) {
//     define("EVALUACION_DOCENTE", false);
// }

// if (!defined("FORMULARIO_COVID")) {
//     define("FORMULARIO_COVID", true);
// }

// if(!defined("EXTRAORDINARIOS_ACTIVOS")) {
//     define("EXTRAORDINARIOS_ACTIVOS", false);
// }

// if(!defined("MODULO_HORARIOS_ACTIVO")) {
//     define("MODULO_HORARIOS_ACTIVO", true);
// }


if(!defined("MODULO_PAGOS_ACTIVO")) {
    define("MODULO_PAGOS_ACTIVO", true);
}

if(!defined("EN_MANTENIMIENTO")) {
    define("EN_MANTENIMIENTO", false);
}

if(!defined("MODULO_PAGOS_MAT_BAC_ACTIVO")) {
    define("MODULO_PAGOS_MAT_BAC_ACTIVO", true);
}


if(!defined("OPCIONES_ACADEMICAS_MAT")) {
    define("OPCIONES_ACADEMICAS_MAT", true);
}

if(!defined("OPCIONES_ACADEMICAS_PRE")) {
    define("OPCIONES_ACADEMICAS_PRE", true);
}

if(!defined("OPCIONES_ACADEMICAS_PRI")) {
    define("OPCIONES_ACADEMICAS_PRI", true);
}

if(!defined("OPCIONES_ACADEMICAS_SEC")) {
    define("OPCIONES_ACADEMICAS_SEC", true);
}

if(!defined("OPCIONES_ACADEMICAS_BAC")) {
    define("OPCIONES_ACADEMICAS_BAC", true);
}

// if(!defined("PERIODO_ESCOLAR_ACTIVO")) {
//     define("PERIODO_ESCOLAR_ACTIVO", false);
// }

// if(!defined("DEFINE_PRORRATEO_LIBRETA_PAGO")) {
//         define("DEFINE_PRORRATEO_LIBRETA_PAGO", false);
// }
