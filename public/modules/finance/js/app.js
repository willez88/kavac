/******/ (function(modules) { // webpackBootstrap
/******/ 	// install a JSONP callback for chunk loading
/******/ 	function webpackJsonpCallback(data) {
/******/ 		var chunkIds = data[0];
/******/ 		var moreModules = data[1];
/******/
/******/
/******/ 		// add "moreModules" to the modules object,
/******/ 		// then flag all "chunkIds" as loaded and fire callback
/******/ 		var moduleId, chunkId, i = 0, resolves = [];
/******/ 		for(;i < chunkIds.length; i++) {
/******/ 			chunkId = chunkIds[i];
/******/ 			if(Object.prototype.hasOwnProperty.call(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 				resolves.push(installedChunks[chunkId][0]);
/******/ 			}
/******/ 			installedChunks[chunkId] = 0;
/******/ 		}
/******/ 		for(moduleId in moreModules) {
/******/ 			if(Object.prototype.hasOwnProperty.call(moreModules, moduleId)) {
/******/ 				modules[moduleId] = moreModules[moduleId];
/******/ 			}
/******/ 		}
/******/ 		if(parentJsonpFunction) parentJsonpFunction(data);
/******/
/******/ 		while(resolves.length) {
/******/ 			resolves.shift()();
/******/ 		}
/******/
/******/ 	};
/******/
/******/
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// object to store loaded and loading chunks
/******/ 	// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 	// Promise = chunk loading, 0 = chunk loaded
/******/ 	var installedChunks = {
/******/ 		"/modules/finance/js/app": 0
/******/ 	};
/******/
/******/
/******/
/******/ 	// script path function
/******/ 	function jsonpScriptSrc(chunkId) {
/******/ 		return __webpack_require__.p + "modules/finance/components/" + ({"finance-account-types":"finance-account-types","finance-bank-accounts":"finance-bank-accounts","finance-banking-agencies":"finance-banking-agencies","finance-banks":"finance-banks","finance-checkbooks":"finance-checkbooks","finance-voucher-design":"finance-voucher-design"}[chunkId]||chunkId) + ".js"
/******/ 	}
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/ 	// This file contains only the entry chunk.
/******/ 	// The chunk loading function for additional chunks
/******/ 	__webpack_require__.e = function requireEnsure(chunkId) {
/******/ 		var promises = [];
/******/
/******/
/******/ 		// JSONP chunk loading for javascript
/******/
/******/ 		var installedChunkData = installedChunks[chunkId];
/******/ 		if(installedChunkData !== 0) { // 0 means "already installed".
/******/
/******/ 			// a Promise means "currently loading".
/******/ 			if(installedChunkData) {
/******/ 				promises.push(installedChunkData[2]);
/******/ 			} else {
/******/ 				// setup Promise in chunk cache
/******/ 				var promise = new Promise(function(resolve, reject) {
/******/ 					installedChunkData = installedChunks[chunkId] = [resolve, reject];
/******/ 				});
/******/ 				promises.push(installedChunkData[2] = promise);
/******/
/******/ 				// start chunk loading
/******/ 				var script = document.createElement('script');
/******/ 				var onScriptComplete;
/******/
/******/ 				script.charset = 'utf-8';
/******/ 				script.timeout = 120;
/******/ 				if (__webpack_require__.nc) {
/******/ 					script.setAttribute("nonce", __webpack_require__.nc);
/******/ 				}
/******/ 				script.src = jsonpScriptSrc(chunkId);
/******/
/******/ 				// create error before stack unwound to get useful stacktrace later
/******/ 				var error = new Error();
/******/ 				onScriptComplete = function (event) {
/******/ 					// avoid mem leaks in IE.
/******/ 					script.onerror = script.onload = null;
/******/ 					clearTimeout(timeout);
/******/ 					var chunk = installedChunks[chunkId];
/******/ 					if(chunk !== 0) {
/******/ 						if(chunk) {
/******/ 							var errorType = event && (event.type === 'load' ? 'missing' : event.type);
/******/ 							var realSrc = event && event.target && event.target.src;
/******/ 							error.message = 'Loading chunk ' + chunkId + ' failed.\n(' + errorType + ': ' + realSrc + ')';
/******/ 							error.name = 'ChunkLoadError';
/******/ 							error.type = errorType;
/******/ 							error.request = realSrc;
/******/ 							chunk[1](error);
/******/ 						}
/******/ 						installedChunks[chunkId] = undefined;
/******/ 					}
/******/ 				};
/******/ 				var timeout = setTimeout(function(){
/******/ 					onScriptComplete({ type: 'timeout', target: script });
/******/ 				}, 120000);
/******/ 				script.onerror = script.onload = onScriptComplete;
/******/ 				document.head.appendChild(script);
/******/ 			}
/******/ 		}
/******/ 		return Promise.all(promises);
/******/ 	};
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// on error function for async loading
/******/ 	__webpack_require__.oe = function(err) { console.error(err); throw err; };
/******/
/******/ 	var jsonpArray = window["webpackJsonp"] = window["webpackJsonp"] || [];
/******/ 	var oldJsonpFunction = jsonpArray.push.bind(jsonpArray);
/******/ 	jsonpArray.push = webpackJsonpCallback;
/******/ 	jsonpArray = jsonpArray.slice();
/******/ 	for(var i = 0; i < jsonpArray.length; i++) webpackJsonpCallback(jsonpArray[i]);
/******/ 	var parentJsonpFunction = oldJsonpFunction;
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Resources/assets/js/app.js":
/*!************************************!*\
  !*** ./Resources/assets/js/app.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("/**\n * Componente para la gestión de bancos\n *\n * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>\n */\nVue.component('finance-banks', function () {\n  return __webpack_require__.e(/*! import() | finance-banks */ \"finance-banks\").then(__webpack_require__.bind(null, /*! ./components/FinanceBankComponent.vue */ \"./Resources/assets/js/components/FinanceBankComponent.vue\"));\n});\n/**\n * Componente para la gestión de agencias bancarias\n *\n * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>\n */\n\nVue.component('finance-banking-agencies', function () {\n  return __webpack_require__.e(/*! import() | finance-banking-agencies */ \"finance-banking-agencies\").then(__webpack_require__.bind(null, /*! ./components/FinanceBankingAgencyComponent.vue */ \"./Resources/assets/js/components/FinanceBankingAgencyComponent.vue\"));\n});\n/**\n * Componente para la gestión de tipos de cuenta bancaria\n *\n * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>\n */\n\nVue.component('finance-account-types', function () {\n  return __webpack_require__.e(/*! import() | finance-account-types */ \"finance-account-types\").then(__webpack_require__.bind(null, /*! ./components/FinanceAccountTypeComponent.vue */ \"./Resources/assets/js/components/FinanceAccountTypeComponent.vue\"));\n});\n/**\n * Componente para la gestión de cuentas bancarias\n *\n * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>\n */\n\nVue.component('finance-bank-accounts', function () {\n  return __webpack_require__.e(/*! import() | finance-bank-accounts */ \"finance-bank-accounts\").then(__webpack_require__.bind(null, /*! ./components/FinanceBankAccountComponent.vue */ \"./Resources/assets/js/components/FinanceBankAccountComponent.vue\"));\n});\n/**\n * Componente para la gestión de chequeras\n *\n * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>\n */\n\nVue.component('finance-checkbooks', function () {\n  return __webpack_require__.e(/*! import() | finance-checkbooks */ \"finance-checkbooks\").then(__webpack_require__.bind(null, /*! ./components/FinanceCheckBookComponent.vue */ \"./Resources/assets/js/components/FinanceCheckBookComponent.vue\"));\n});\n/**\n * Componente para gestionar y configurar el diseño del voucher para la impresión de cheques\n *\n * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>\n */\n\nVue.component('finance-voucher-design', function () {\n  return __webpack_require__.e(/*! import() | finance-voucher-design */ \"finance-voucher-design\").then(__webpack_require__.bind(null, /*! ./components/FinanceVoucherDesignComponent.vue */ \"./Resources/assets/js/components/FinanceVoucherDesignComponent.vue\"));\n});\n/**\n * Opciones de configuración global del módulo de finanzas\n *\n * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>\n */\n\nVue.mixin({\n  methods: {\n    /**\n     * Permite formatear la cadena de la cuenta bancaria\n     *\n     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>\n     * @param  {string}  account  Número de cuenta bancaria\n     * @param  {boolean} formated Indica si se desa obtener o no el número de cuenta bancaria formateada\n     * @return {string}           Número de cuenta formateado\n     */\n    format_bank_account: function format_bank_account(account, formated) {\n      var formated = typeof formated !== \"undefined\" ? formated : true;\n      var account_formated = '';\n\n      for (var i = 0; i < account.length; i++) {\n        if (formated && [4, 8, 10].includes(i) && account.charAt(i) !== \"-\") {\n          account_formated += '-';\n        }\n\n        account_formated += account.charAt(i);\n      }\n\n      return account_formated;\n    },\n\n    /**\n     * Obtiene los datos de las entidades bancarias registradas\n     *\n     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>\n     */\n    getBanks: function getBanks() {\n      var _this = this;\n\n      axios.get('/finance/get-banks').then(function (response) {\n        _this.banks = response.data;\n      });\n    },\n\n    /**\n     * Obtiene los datos de las cuentas bancarias\n     *\n     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>\n     */\n    getAgencies: function getAgencies() {\n      var vm = this;\n      bank_id = this.record.finance_bank_id;\n\n      if (bank_id) {\n        axios.get('/finance/get-agencies/' + bank_id).then(function (response) {\n          vm.agencies = response.data;\n        })[\"catch\"](function (error) {\n          vm.logs('Budget/Resources/assets/js/_all.js', 90, error, 'getAgencies');\n        });\n\n        if ($(\"#bank_code\").length) {\n          axios.get('/finance/get-bank-info/' + bank_id).then(function (response) {\n            if (response.data.result) {\n              vm.record.bank_code = response.data.bank.code;\n            }\n          })[\"catch\"](function (error) {\n            vm.logs('Budget/Resources/assets/js/_all.js', 97, error, 'getAgencies');\n          });\n        }\n      }\n    },\n\n    /**\n     * Obtiene los datos de los tipos de cuenta bancaria\n     *\n     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>\n     */\n    getAccountTypes: function getAccountTypes() {\n      var _this2 = this;\n\n      axios.get('/finance/get-account-types').then(function (response) {\n        _this2.account_types = response.data;\n      })[\"catch\"](function (error) {\n        console.log(error);\n      });\n    },\n\n    /**\n     * Obtiene los datos de las cuentas asociadas a una entidad bancaria\n     *\n     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>\n     */\n    getBankAccounts: function getBankAccounts() {\n      var vm = this;\n      bank_id = this.record.finance_bank_id;\n\n      if (bank_id) {\n        axios.get('/finance/get-accounts/' + bank_id).then(function (response) {\n          if (response.data.result) {\n            vm.accounts = response.data.accounts;\n          }\n        })[\"catch\"](function (error) {\n          vm.logs('Budget/Resources/assets/js/_all.js', 127, error, 'getBankAccounts');\n        });\n      }\n    }\n  },\n  mounted: function mounted() {// Agregar instrucciones para determinar el año de ejecución\n  }\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9SZXNvdXJjZXMvYXNzZXRzL2pzL2FwcC5qcz82ZmY1Il0sIm5hbWVzIjpbIlZ1ZSIsImNvbXBvbmVudCIsIm1peGluIiwibWV0aG9kcyIsImZvcm1hdF9iYW5rX2FjY291bnQiLCJhY2NvdW50IiwiZm9ybWF0ZWQiLCJhY2NvdW50X2Zvcm1hdGVkIiwiaSIsImxlbmd0aCIsImluY2x1ZGVzIiwiY2hhckF0IiwiZ2V0QmFua3MiLCJheGlvcyIsImdldCIsInRoZW4iLCJyZXNwb25zZSIsImJhbmtzIiwiZGF0YSIsImdldEFnZW5jaWVzIiwidm0iLCJiYW5rX2lkIiwicmVjb3JkIiwiZmluYW5jZV9iYW5rX2lkIiwiYWdlbmNpZXMiLCJlcnJvciIsImxvZ3MiLCIkIiwicmVzdWx0IiwiYmFua19jb2RlIiwiYmFuayIsImNvZGUiLCJnZXRBY2NvdW50VHlwZXMiLCJhY2NvdW50X3R5cGVzIiwiY29uc29sZSIsImxvZyIsImdldEJhbmtBY2NvdW50cyIsImFjY291bnRzIiwibW91bnRlZCJdLCJtYXBwaW5ncyI6IkFBQUE7Ozs7O0FBS0FBLEdBQUcsQ0FBQ0MsU0FBSixDQUFjLGVBQWQsRUFBK0I7QUFBQSxTQUFNLHFOQUFOO0FBQUEsQ0FBL0I7QUFLQTs7Ozs7O0FBS0FELEdBQUcsQ0FBQ0MsU0FBSixDQUFjLDBCQUFkLEVBQTBDO0FBQUEsU0FBTSw2UEFBTjtBQUFBLENBQTFDO0FBS0E7Ozs7OztBQUtBRCxHQUFHLENBQUNDLFNBQUosQ0FBYyx1QkFBZCxFQUF1QztBQUFBLFNBQU0sbVBBQU47QUFBQSxDQUF2QztBQUtBOzs7Ozs7QUFLQUQsR0FBRyxDQUFDQyxTQUFKLENBQWMsdUJBQWQsRUFBdUM7QUFBQSxTQUFNLG1QQUFOO0FBQUEsQ0FBdkM7QUFLQTs7Ozs7O0FBS0FELEdBQUcsQ0FBQ0MsU0FBSixDQUFjLG9CQUFkLEVBQW9DO0FBQUEsU0FBTSx5T0FBTjtBQUFBLENBQXBDO0FBS0E7Ozs7OztBQUtBRCxHQUFHLENBQUNDLFNB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TWhCLEVBQUUsR0FBRyxJQUFYO0FBQ0FDLGFBQU8sR0FBRyxLQUFLQyxNQUFMLENBQVlDLGVBQXRCOztBQUVBLFVBQUlGLE9BQUosRUFBYTtBQUNaUixhQUFLLENBQUNDLEdBQU4sQ0FBVSwyQkFBMkJPLE9BQXJDLEVBQThDTixJQUE5QyxDQUFtRCxVQUFBQyxRQUFRLEVBQUk7QUFDOUQsY0FBSUEsUUFBUSxDQUFDRSxJQUFULENBQWNVLE1BQWxCLEVBQTBCO0FBQ3pCUixjQUFFLENBQUNpQixRQUFILEdBQWNyQixRQUFRLENBQUNFLElBQVQsQ0FBY21CLFFBQTVCO0FBQ0E7QUFDRCxTQUpELFdBSVMsVUFBQVosS0FBSyxFQUFJO0FBQ2pCTCxZQUFFLENBQUNNLElBQUgsQ0FBUSxvQ0FBUixFQUE4QyxHQUE5QyxFQUFtREQsS0FBbkQsRUFBMEQsaUJBQTFEO0FBQ0EsU0FORDtBQU9BO0FBQ0Q7QUF4Rk8sR0FEQTtBQTJGVGEsU0EzRlMscUJBMkZDLENBQ1Q7QUFDQTtBQTdGUSxDQUFWIiwiZmlsZSI6Ii4vUmVzb3VyY2VzL2Fzc2V0cy9qcy9hcHAuanMuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvKipcbiAqIENvbXBvbmVudGUgcGFyYSBsYSBnZXN0acOzbiBkZSBiYW5jb3NcbiAqXG4gKiBAYXV0aG9yICBJbmcuIFJvbGRhbiBWYXJnYXMgPHJ2YXJnYXNAY2VuZGl0ZWwuZ29iLnZlPiB8IDxyb2xkYW5kdmdAZ21haWwuY29tPlxuICovXG5WdWUuY29tcG9uZW50KCdmaW5hbmNlLWJhbmtzJywgKCkgPT4gaW1wb3J0KFxuICAgIC8qIHdlYnBhY2tDaHVua05hbWU6IFwiZmluYW5jZS1iYW5rc1wiICovXG4gICAgJy4vY29tcG9uZW50cy9GaW5hbmNlQmFua0NvbXBvbmVudC52dWUnKVxuKTtcblxuLyoqXG4gKiBDb21wb25lbnRlIHBhcmEgbGEgZ2VzdGnDs24gZGUgYWdlbmNpYXMgYmFuY2FyaWFzXG4gKlxuICogQGF1dGhvciAgSW5nLiBSb2xkYW4gVmFyZ2FzIDxydmFyZ2FzQGNlbmRpdGVsLmdvYi52ZT4gfCA8cm9sZGFuZHZnQGdtYWlsLmNvbT5cbiAqL1xuVnVlLmNvbXBvbmVudCgnZmluYW5jZS1iYW5raW5nLWFnZW5jaWVzJywgKCkgPT4gaW1wb3J0KFxuICAgIC8qIHdlYnBhY2tDaHVua05hbWU6IFwiZmluYW5jZS1iYW5raW5nLWFnZW5jaWVzXCIgKi9cbiAgICAnLi9jb21wb25lbnRzL0ZpbmFuY2VCYW5raW5nQWdlbmN5Q29tcG9uZW50LnZ1ZScpXG4pO1xuXG4vKipcbiAqIENvbXBvbmVudGUgcGFyYSBsYSBnZXN0acOzbiBkZSB0aXBvcyBkZSBjdWVudGEgYmFuY2FyaWFcbiAqXG4gKiBAYXV0aG9yICBJbmcuIFJvbGRhbiBWYXJnYXMgPHJ2YXJnYXNAY2VuZGl0ZWwuZ29iLnZlPiB8IDxyb2xkYW5kdmdAZ21haWwuY29tPlxuICovXG5WdWUuY29tcG9uZW50KCdmaW5hbmNlLWFjY291bnQtdHlwZXMnLCAoKSA9PiBpbXBvcnQoXG4gICAgLyogd2VicGFja0NodW5rTmFtZTogXCJmaW5hbmNlLWFjY291bnQtdHlwZXNcIiAqL1xuICAgICcuL2NvbXBvbmVudHMvRmluYW5jZUFjY291bnRUeXBlQ29tcG9uZW50LnZ1ZScpXG4pO1xuXG4vKipcbiAqIENvbXBvbmVudGUgcGFyYSBsYSBnZXN0acOzbiBkZSBjdWVudGFzIGJhbmNhcmlhc1xuICpcbiAqIEBhdXRob3IgIEluZy4gUm9sZGFuIFZhcmdhcyA8cnZhcmdhc0BjZW5kaXRlbC5nb2IudmU+IHwgPHJvbGRhbmR2Z0BnbWFpbC5jb20+XG4gKi9cblZ1ZS5jb21wb25lbnQoJ2ZpbmFuY2UtYmFuay1hY2NvdW50cycsICgpID0+IGltcG9ydChcbiAgICAvKiB3ZWJwYWNrQ2h1bmtOYW1lOiBcImZpbmFuY2UtYmFuay1hY2NvdW50c1wiICovXG4gICAgJy4vY29tcG9uZW50cy9GaW5hbmNlQmFua0FjY291bnRDb21wb25lbnQudnVlJylcbik7XG5cbi8qKlxuICogQ29tcG9uZW50ZSBwYXJhIGxhIGdlc3Rpw7NuIGRlIGNoZXF1ZXJhc1xuICpcbiAqIEBhdXRob3IgIEluZy4gUm9sZGFuIFZhcmdhcyA8cnZhcmdhc0BjZW5kaXRlbC5nb2IudmU+IHwgPHJvbGRhbmR2Z0BnbWFpbC5jb20+XG4gKi9cblZ1ZS5jb21wb25lbnQoJ2ZpbmFuY2UtY2hlY2tib29rcycsICgpID0+IGltcG9ydChcbiAgICAvKiB3ZWJwYWNrQ2h1bmtOYW1lOiBcImZpbmFuY2UtY2hlY2tib29rc1wiICovXG4gICAgJy4vY29tcG9uZW50cy9GaW5hbmNlQ2hlY2tCb29rQ29tcG9uZW50LnZ1ZScpXG4pO1xuXG4vKipcbiAqIENvbXBvbmVudGUgcGFyYSBnZXN0aW9uYXIgeSBjb25maWd1cmFyIGVsIGRpc2XDsW8gZGVsIHZvdWNoZXIgcGFyYSBsYSBpbXByZXNpw7NuIGRlIGNoZXF1ZXNcbiAqXG4gKiBAYXV0aG9yICBJbmcuIFJvbGRhbiBWYXJnYXMgPHJ2YXJnYXNAY2VuZGl0ZWwuZ29iLnZlPiB8IDxyb2xkYW5kdmdAZ21haWwuY29tPlxuICovXG5WdWUuY29tcG9uZW50KCdmaW5hbmNlLXZvdWNoZXItZGVzaWduJywgKCkgPT4gaW1wb3J0KFxuICAgIC8qIHdlYnBhY2tDaHVua05hbWU6IFwiZmluYW5jZS12b3VjaGVyLWRlc2lnblwiICovXG4gICAgJy4vY29tcG9uZW50cy9GaW5hbmNlVm91Y2hlckRlc2lnbkNvbXBvbmVudC52dWUnKVxuKTtcblxuLyoqXG4gKiBPcGNpb25lcyBkZSBjb25maWd1cmFjacOzbiBnbG9iYWwgZGVsIG3Ds2R1bG8gZGUgZmluYW56YXNcbiAqXG4gKiBAYXV0aG9yICBJbmcuIFJvbGRhbiBWYXJnYXMgPHJ2YXJnYXNAY2VuZGl0ZWwuZ29iLnZlPiB8IDxyb2xkYW5kdmdAZ21haWwuY29tPlxuICovXG5WdWUubWl4aW4oe1xuXHRtZXRob2RzOiB7XG5cdFx0LyoqXG5cdFx0ICogUGVybWl0ZSBmb3JtYXRlYXIgbGEgY2FkZW5hIGRlIGxhIGN1ZW50YSBiYW5jYXJpYVxuXHRcdCAqXG5cdFx0ICogQGF1dGhvciAgSW5nLiBSb2xkYW4gVmFyZ2FzIDxydmFyZ2FzQGNlbmRpdGVsLmdvYi52ZT4gfCA8cm9sZGFuZHZnQGdtYWlsLmNvbT5cblx0XHQgKiBAcGFyYW0gIHtzdHJpbmd9ICBhY2NvdW50ICBOw7ptZXJvIGRlIGN1ZW50YSBiYW5jYXJpYVxuXHRcdCAqIEBwYXJhbSAge2Jvb2xlYW59IGZvcm1hdGVkIEluZGljYSBzaSBzZSBkZXNhIG9idGVuZXIgbyBubyBlbCBuw7ptZXJvIGRlIGN1ZW50YSBiYW5jYXJpYSBmb3JtYXRlYWRhXG5cdFx0ICogQHJldHVybiB7c3RyaW5nfSAgICAgICAgICAgTsO6bWVybyBkZSBjdWVudGEgZm9ybWF0ZWFkb1xuXHRcdCAqL1xuXHRcdGZvcm1hdF9iYW5rX2FjY291bnQoYWNjb3VudCwgZm9ybWF0ZWQpIHtcblx0XHRcdHZhciBmb3JtYXRlZCA9ICh0eXBlb2YoZm9ybWF0ZWQpICE9PSBcInVuZGVmaW5lZFwiKSA/IGZvcm1hdGVkIDogdHJ1ZTtcblxuXHRcdFx0dmFyIGFjY291bnRfZm9ybWF0ZWQgPSAnJztcbiAgICAgICAgICAgIGZvciAodmFyIGkgPSAwOyBpIDwgYWNjb3VudC5sZW5ndGg7IGkrKykge1xuICAgICAgICAgICAgICAgIGlmIChmb3JtYXRlZCAmJiBbNCwgOCwgMTBdLmluY2x1ZGVzKGkpICYmIGFjY291bnQuY2hhckF0KGkpICE9PSBcIi1cIikge1xuICAgICAgICAgICAgICAgIFx0YWNjb3VudF9mb3JtYXRlZCArPSAnLSc7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgXHRhY2NvdW50X2Zvcm1hdGVkICs9IGFjY291bnQuY2hhckF0KGkpO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICByZXR1cm4gYWNjb3VudF9mb3JtYXRlZDtcblx0XHR9LFxuXHRcdC8qKlxuXHRcdCAqIE9idGllbmUgbG9zIGRhdG9zIGRlIGxhcyBlbnRpZGFkZXMgYmFuY2FyaWFzIHJlZ2lzdHJhZGFzXG5cdFx0ICpcblx0XHQgKiBAYXV0aG9yIEluZy4gUm9sZGFuIFZhcmdhcyA8cnZhcmdhc0BjZW5kaXRlbC5nb2IudmU+IHwgPHJvbGRhbmR2Z0BnbWFpbC5jb20+XG5cdFx0ICovXG5cdFx0Z2V0QmFua3M6IGZ1bmN0aW9uKCkge1xuXHRcdFx0YXhpb3MuZ2V0KCcvZmluYW5jZS9nZXQtYmFua3MnKS50aGVuKHJlc3BvbnNlID0+IHtcblx0XHRcdFx0dGhpcy5iYW5rcyA9IHJlc3BvbnNlLmRhdGE7XG5cdFx0XHR9KTtcblx0XHR9LFxuXHRcdC8qKlxuXHRcdCAqIE9idGllbmUgbG9zIGRhdG9zIGRlIGxhcyBjdWVudGFzIGJhbmNhcmlhc1xuXHRcdCAqXG5cdFx0ICogQGF1dGhvciBJbmcuIFJvbGRhbiBWYXJnYXMgPHJ2YXJnYXNAY2VuZGl0ZWwuZ29iLnZlPiB8IDxyb2xkYW5kdmdAZ21haWwuY29tPlxuXHRcdCAqL1xuXHRcdGdldEFnZW5jaWVzKCkge1xuXHRcdFx0Y29uc3Qgdm0gPSB0aGlzO1xuXHRcdFx0YmFua19pZCA9IHRoaXMucmVjb3JkLmZpbmFuY2VfYmFua19pZDtcblx0XHRcdGlmIChiYW5rX2lkKSB7XG5cdFx0XHRcdGF4aW9zLmdldCgnL2ZpbmFuY2UvZ2V0LWFnZW5jaWVzLycgKyBiYW5rX2lkKS50aGVuKHJlc3BvbnNlID0+IHtcblx0XHRcdFx0XHR2bS5hZ2VuY2llcyA9IHJlc3BvbnNlLmRhdGE7XG5cdFx0XHRcdH0pLmNhdGNoKGVycm9yID0+IHtcblx0XHRcdFx0XHR2bS5sb2dzKCdCdWRnZXQvUmVzb3VyY2VzL2Fzc2V0cy9qcy9fYWxsLmpzJywgOTAsIGVycm9yLCAnZ2V0QWdlbmNpZXMnKTtcblx0XHRcdFx0fSk7XG5cblx0XHRcdFx0aWYgKCQoXCIjYmFua19jb2RlXCIpLmxlbmd0aCkge1xuXHRcdFx0XHRcdGF4aW9zLmdldCgnL2ZpbmFuY2UvZ2V0LWJhbmstaW5mby8nICsgYmFua19pZCkudGhlbihyZXNwb25zZSA9PiB7XG5cdFx0XHRcdFx0XHRpZiAocmVzcG9uc2UuZGF0YS5yZXN1bHQpIHtcblx0XHRcdFx0XHRcdFx0dm0ucmVjb3JkLmJhbmtfY29kZSA9IHJlc3BvbnNlLmRhdGEuYmFuay5jb2RlO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH0pLmNhdGNoKGVycm9yID0+IHtcblx0XHRcdFx0XHRcdHZtLmxvZ3MoJ0J1ZGdldC9SZXNvdXJjZXMvYXNzZXRzL2pzL19hbGwuanMnLCA5NywgZXJyb3IsICdnZXRBZ2VuY2llcycpO1xuXHRcdFx0XHRcdH0pO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fSxcblx0XHQvKipcblx0XHQgKiBPYnRpZW5lIGxvcyBkYXRvcyBkZSBsb3MgdGlwb3MgZGUgY3VlbnRhIGJhbmNhcmlhXG5cdFx0ICpcblx0XHQgKiBAYXV0aG9yIEluZy4gUm9sZGFuIFZhcmdhcyA8cnZhcmdhc0BjZW5kaXRlbC5nb2IudmU+IHwgPHJvbGRhbmR2Z0BnbWFpbC5jb20+XG5cdFx0ICovXG5cdFx0Z2V0QWNjb3VudFR5cGVzOiBmdW5jdGlvbigpIHtcblx0XHRcdGF4aW9zLmdldCgnL2ZpbmFuY2UvZ2V0LWFjY291bnQtdHlwZXMnKS50aGVuKHJlc3BvbnNlID0+IHtcblx0XHRcdFx0dGhpcy5hY2NvdW50X3R5cGVzID0gcmVzcG9uc2UuZGF0YTtcblx0XHRcdH0pLmNhdGNoKGVycm9yID0+IHtcblx0XHRcdFx0Y29uc29sZS5sb2coZXJyb3IpO1xuXHRcdFx0fSk7XG5cdFx0fSxcblx0XHQvKipcblx0XHQgKiBPYnRpZW5lIGxvcyBkYXRvcyBkZSBsYXMgY3VlbnRhcyBhc29jaWFkYXMgYSB1bmEgZW50aWRhZCBiYW5jYXJpYVxuXHRcdCAqXG5cdFx0ICogQGF1dGhvciBJbmcuIFJvbGRhbiBWYXJnYXMgPHJ2YXJnYXNAY2VuZGl0ZWwuZ29iLnZlPiB8IDxyb2xkYW5kdmdAZ21haWwuY29tPlxuXHRcdCAqL1xuXHRcdGdldEJhbmtBY2NvdW50cygpIHtcblx0XHRcdGNvbnN0IHZtID0gdGhpcztcblx0XHRcdGJhbmtfaWQgPSB0aGlzLnJlY29yZC5maW5hbmNlX2JhbmtfaWQ7XG5cblx0XHRcdGlmIChiYW5rX2lkKSB7XG5cdFx0XHRcdGF4aW9zLmdldCgnL2ZpbmFuY2UvZ2V0LWFjY291bnRzLycgKyBiYW5rX2lkKS50aGVuKHJlc3BvbnNlID0+IHtcblx0XHRcdFx0XHRpZiAocmVzcG9uc2UuZGF0YS5yZXN1bHQpIHtcblx0XHRcdFx0XHRcdHZtLmFjY291bnRzID0gcmVzcG9uc2UuZGF0YS5hY2NvdW50cztcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH0pLmNhdGNoKGVycm9yID0+IHtcblx0XHRcdFx0XHR2bS5sb2dzKCdCdWRnZXQvUmVzb3VyY2VzL2Fzc2V0cy9qcy9fYWxsLmpzJywgMTI3LCBlcnJvciwgJ2dldEJhbmtBY2NvdW50cycpO1xuXHRcdFx0XHR9KTtcblx0XHRcdH1cblx0XHR9XG5cdH0sXG5cdG1vdW50ZWQoKSB7XG5cdFx0Ly8gQWdyZWdhciBpbnN0cnVjY2lvbmVzIHBhcmEgZGV0ZXJtaW5hciBlbCBhw7FvIGRlIGVqZWN1Y2nDs25cblx0fVxufSk7XG4iXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./Resources/assets/js/app.js\n");

/***/ }),

/***/ "./Resources/assets/sass/app.scss":
/*!****************************************!*\
  !*** ./Resources/assets/sass/app.scss ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("// removed by extract-text-webpack-plugin//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9SZXNvdXJjZXMvYXNzZXRzL3Nhc3MvYXBwLnNjc3M/OGE5OCJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQSIsImZpbGUiOiIuL1Jlc291cmNlcy9hc3NldHMvc2Fzcy9hcHAuc2Nzcy5qcyIsInNvdXJjZXNDb250ZW50IjpbIi8vIHJlbW92ZWQgYnkgZXh0cmFjdC10ZXh0LXdlYnBhY2stcGx1Z2luIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./Resources/assets/sass/app.scss\n");

/***/ }),

/***/ 0:
/*!***************************************************************************!*\
  !*** multi ./Resources/assets/js/app.js ./Resources/assets/sass/app.scss ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/pbuitrago/Cenditel/Proyecto_kavac/kavac_cenditel/modules/Finance/Resources/assets/js/app.js */"./Resources/assets/js/app.js");
module.exports = __webpack_require__(/*! /home/pbuitrago/Cenditel/Proyecto_kavac/kavac_cenditel/modules/Finance/Resources/assets/sass/app.scss */"./Resources/assets/sass/app.scss");


/***/ })

/******/ });