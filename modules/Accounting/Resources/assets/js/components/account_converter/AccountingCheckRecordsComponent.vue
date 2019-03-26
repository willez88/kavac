<template>
<!-- 	<div id="appContent">
		<form>
			<div class="row">
				<div class="col-3">
					<div class="form-group" >
						<label for="" class="control-label">Por Presupuestos</label>
						<div class="col-12">
							<input type="radio" 
									name="account_type"
									id="radio1"
									class="form-control bootstrap-switch"
									value="budget" checked>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="" class="control-label">Por Patrimonial</label>
						<div class="col-12">
							<input type="radio" 
									name="account_type"
									id="radio2"
									class="form-control bootstrap-switch"
									value="accounting">
						</div>
					</div>
				</div>	

				<div class="col-12">
					<div class="form-group row">
						<div class="col-6">
							<select>
								
							</select>
							<input type="date" class="form-control input-sm" 
									data-toggle="tooltip" 
									title="Indique la fecha rango de inicio"
									required>
						</div>
						<div class="col-6">
							<input type="date" class="form-control input-sm" 
									data-toggle="tooltip" 
									title="Indique la fecha rango de final"
									required>
						</div>
					</div>
				</div>
			</div>
			
		</form>
	</div> -->
</template>
<script>
// const app2 = new Vue({
//       el: '#appContent',
//       data: {
//       },
//       methods:{
//             tuFuncion:function(){
//               alert('metodo en vue');
               
//             }
//       }
//     });
// $(document).ready(function(){
// 	  // $('#radio2').value == 
// 	   app2.tuFuncion();
	 
// 	});
export default{
		data(){
			return{
				radio_btn:'',
			}
		},
		mounted(){

		},
		methods:{
			llamar:function(){
				alert("change");
			}
		},
		watch:{
			radio_btn:function(res) {
				console.log(res)
			}
		}
	}

</script>