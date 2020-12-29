/**
 * Componente para realizar la firma electrónica a documentos PDF
 *
 * @author  Pedro Buitrago <pbuitrago@cenditel.gob.ve | pedrobui@gmail.com>
 */
Vue.component('digitalsignature-signfile-component', () => import(
    './components/DigitalSignatureSignFileComponent.vue'
));

/**
 * Componente para realizar la verificación de la firma electrónica a documentos PDF
 *
 * @author  Pedro Buitrago <pbuitrago@cenditel.gob.ve | pedrobui@gmail.com>
 */
Vue.component('digitalsignature-verifysign-component', () => import(
    './components/DigitalSignatureVerifySignComponent.vue'
));
