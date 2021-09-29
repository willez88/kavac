/**
 * Componente para realizar la verificación de la firma electrónica a documentos PDF
 *
 * @author  Pedro Buitrago <pbuitrago@cenditel.gob.ve | pedrobui@gmail.com>
 */
Vue.component('testing-component', () => import(
    '../../modules/DigitalSignature/Resources/assets/js/components/DigitalSignatureVerifySignComponent.vue'
));


/**
 * Componente para realizar la firma electrónica a documentos PDF
 *
 * @author  Pedro Buitrago <pbuitrago@cenditel.gob.ve | pedrobui@gmail.com>
 */
Vue.component('signing-component', () => import(
    '../../modules/DigitalSignature/Resources/assets/js/components/DigitalSignatureSignFileComponent.vue'
));