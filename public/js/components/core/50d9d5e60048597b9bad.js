(window.webpackJsonp=window.webpackJsonp||[]).push([[15],{"KHd+":function(e,t,i){"use strict";function a(e,t,i,a,n,o,r,s){var c,l="function"==typeof e?e.options:e;if(t&&(l.render=t,l.staticRenderFns=i,l._compiled=!0),a&&(l.functional=!0),o&&(l._scopeId="data-v-"+o),r?(c=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),n&&n.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(r)},l._ssrRegister=c):n&&(c=s?function(){n.call(this,this.$root.$options.shadowRoot)}:n),c)if(l.functional){l._injectStyles=c;var d=l.render;l.render=function(e,t){return c.call(t),d(e,t)}}else{var u=l.beforeCreate;l.beforeCreate=u?[].concat(u,c):[c]}return{exports:e,options:l}}i.d(t,"a",(function(){return a}))},"fY/u":function(e,t,i){"use strict";i.r(t);function a(e){return(a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}var n={data:function(){return{id:"",url:""}},props:{imgWidth:{type:String,required:!1,default:"64px"},imgHeight:{type:String,required:!1,default:"64px"},imgDefault:{type:String,required:!1,default:"/images/no-image2.png"},imgId:{type:Number,required:!1,default:""}},watch:{imgDefault:function(e,t){this.url=this.imgDefault,this.id=this.imgId}},methods:{selectImage:function(e){$("#".concat(e)).click()},uploadImage:function(e,t){var i=this,a=(t=void 0!==t?t:"",new FormData),n=document.querySelector("#".concat(e));a.append("image",n.files[0]),t?axios.put("".concat(window.app_url,"/upload-image/").concat(t)).then((function(e){})).catch((function(e){i.logs("ImageManagementComponent",127,e,"uploadImage")})):axios.post("".concat(window.app_url,"/upload-image"),a,{headers:{"Content-Type":"multipart/form-data"}}).then((function(e){if(!e.data.result)return i.showMessage("custom","Error","growl-danger","screen-error","La imagen no se pudo cargar, verifique e intente de nuevo.\n                            Si el problema persiste contacte al administrador del sistema."),!1;i.id=e.data.image_id,i.url="".concat(window.app_url,"/").concat(e.data.image_url),i.$emit("changeImage",i.id),$("#imgDelete").tooltip({delay:{hide:100}})})).catch((function(e){i.logs("ImageManagementComponent",120,e,"uploadImage")}))},deleteImage:function(e){var t=this;e=void 0!==a(e)&&e?{force_delete:e}:{};t.id&&bootbox.confirm("Esta seguro de querer eliminar la imagen?",(function(i){i&&axios.delete("".concat(window.app_url,"/upload-image/").concat(t.id),e).then((function(e){e.data.result?(t.id="",t.url="".concat(window.app_url,"/images/no-image2.png")):$.gritter.add({title:"Error!",text:e.data.message,class_name:"growl-danger",image:"/images/screen-error.png",sticky:!1,time:2500})})).catch((function(e){t.logs("ImageManagementComponent",165,e,"deleteImage")}))}))}},mounted:function(){this.url=this.imgDefault?this.imgDefault:"".concat(window.app_url,"/images/no-image2.png")}},o=i("KHd+"),r=Object(o.a)(n,(function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("div",{staticClass:"text-center"},[i("img",{staticClass:"img-fluid default-image-style",style:{width:e.imgWidth,height:e.imgHeight},attrs:{src:e.url,alt:"Imagen",id:"showImage",title:"Click para cargar o modificar la imagen","data-toggle":"tooltip"},on:{click:function(t){return e.selectImage("image")}}}),e._v(" "),i("input",{staticClass:"hide-image-file",attrs:{type:"file",id:"image",name:"image",accept:"image/*"},on:{change:function(t){return e.uploadImage("image")}}}),e._v(" "),""!==e.id?i("div",{staticClass:"row",class:{"row-delete-img":!e.id}},[i("div",{staticClass:"col-12"},[i("div",{staticClass:"text-center"},[i("a",{staticClass:"btn btn-primary btn-simple btn-img-action",attrs:{id:"imgDelete",href:"javascript:void(0)",title:"Eliminar imagen","data-toggle":"tooltip"},on:{click:function(t){return t.preventDefault(),e.deleteImage(!0)}}},[i("i",{staticClass:"fa fa-times"})])])])]):e._e()])}),[],!1,null,null,null);t.default=r.exports}}]);