/**
 * Registro de ubicación de los módulos del sistema para requerir componentes Vue y/o compilaciones CSS y JS
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */

/** Compilación de componentes y configuración vuejs para el módulo de presupuesto */
require('../../modules/Budget/Resources/assets/js/_all.js');

/** Compilación de componentes y configuración vuejs para el módulo de bienes */
require('../../modules/Asset/Resources/assets/js/_all.js');

/** Compilación de componentes y configuración vuejs para el módulo de nómina */
require('../../modules/Payroll/Resources/assets/js/_all.js');

/** Compilación de componentes y configuración vuejs para el módulo de contabilidad */
require('../../modules/Accounting/Resources/assets/js/_all.js');

// * Compilación de componentes y configuración vuejs para el módulo de firma electrónica 
require('../../modules/DigitalSignature/Resources/assets/js/_all.js');

/** Compilación de componentes y configuración vuejs para el módulo de compras */
require('../../modules/Purchase/Resources/assets/js/_all.js');

/** Compilación de componentes y configuración vuejs para el módulo de almacén */
require('../../modules/Warehouse/Resources/assets/js/_all.js');

/** Compilación de componentes y configuración vuejs para el módulo de finanza */
require('../../modules/Finance/Resources/assets/js/_all.js');