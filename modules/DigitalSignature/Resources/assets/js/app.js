/**
 * Componente para realizar la firma electrónica a documentos PDF
 *
 * @author  Pedro Buitrago <pbuitrago@cenditel.gob.ve | pedrobui@gmail.com>
 */
Vue.component('digitalSignature-signFile-form', () => import(
    './components/DigitalSignatureSignFileForm.vue')
);

/**
 * Componente para realizar la verificación de la firma electrónica a documentos PDF
 *
 * @author  Pedro Buitrago <pbuitrago@cenditel.gob.ve | pedrobui@gmail.com>
 */
Vue.component('digitalSignature-verifySign-form', () => import(
    './components/DigitalSignatureVerifySignForm.vue')
);
