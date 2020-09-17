
function reloadgvthamgiagiangday1() {
	chongvthamgiagiangday1();
	loaddatadanhsachgvthamgiagiangday1();
	var dataGrid = $("#girddangkybuoitietnghicuagv").dxDataGrid("instance");
	dataGrid.clearSelection();
	dataGrid.refresh();
}


function loaddatadanhsachgvthamgiagiangday1() {
	var data = axios.get('getdangkybuoitietnghicuagv').then(function (response) {
		var data1 = response.data;
		// console.log(data1);			
		var data2 = [];
		var lucky1 = data1.filter(function(items){
			if(items.monhoc != ''){
				data2.push({ id:items.id,ten:items.ten,bidanh:items.bidanh,thutuhienthi:items.thutuhienthi,monhoc:items.monhoc,rangbuocdangkybuoitietnghigv:items.rangbuocdangkybuoitietnghigv});	
			}
		});
		var data3 = [];
		var lucky2 = data2.filter(function(items1){
			var magiaovien = items1.id;
			var data4 = [];
			data3.push({ id:items1.id,ten:items1.ten,bidanh:items1.bidanh,thutuhienthi:items1.thutuhienthi,monhoc:data4,rangbuocdangkybuoitietnghigv:items1.rangbuocdangkybuoitietnghigv});
			var datamh = items1.monhoc;
			var lucky3 = datamh.filter(function(items2){
				if(magiaovien == items2.magiaovien){
					var malop = items2.malop;
					var sotiet = items2.sotiet;
					var mamonhoc = items2.mamonhoc;
					var datalop = items2.danhsachlophoc;
					var data5 = [];
					data4.push({id:items2.id,malop:items2.malop,magiaovien:items2.magiaovien,tenmonhoc:items2.tenmonhoc,lop:data5});
					if(malop == datalop.id){
						data5.push({id:datalop.id,mamonhoc:mamonhoc,tenlop:datalop.tenlop,sotiet:sotiet});
					}
				}
			});
		});
		// console.log(data3);
		var datas = data3.map(function (value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {stt: stt.toString()});
			return datas;
		});
		chongvthamgiagiangday1(datas);
	});
}

function chongvthamgiagiangday1(datas){
	// console.log(datas);

	$("#girddangkybuoitietnghicuagv").dxDataGrid({
		dataSource: datas,
		showBorders: true,
		paging: {
			pageSize: 10
		},
		/* xap xep */
		sorting: {
			mode: "multiple"
		},
		/* loc du lieu */
		// filterRow: {
		// 	visible: true,
		// 	applyFilter: "auto"
		// },
		searchPanel: {
			visible: true,
			width: 240,
			placeholder: "Tìm kiếm...",
		},
		pager: {
			showPageSizeSelector: true,
			allowedPageSizes: [5, 10, 20],
			showInfo: true
		},
		// editing: {
		// 	mode: "cell",
		// 	allowUpdating: true
		// },

		/*chon row*/
		// selection: {
		// 	mode: "single"
		// },
		/* co dan cot */
		allowColumnResizing: true,
		columnResizingMode: "widget",
		onEditorPreparing: function(e) {  
			if (e.dataField == "stt" && e.parentType == "dataRow") {  
				e.editorOptions.readOnly = true;  
			}
			if (e.dataField == "ten" && e.parentType == "dataRow") {  
				e.editorOptions.readOnly = true;  
			} 
			if (e.dataField == "bidanh" && e.parentType == "dataRow") {  
				e.editorOptions.readOnly = true;  
			}
			if (e.dataField == "monhoc" && e.parentType == "dataRow") {  
				e.editorOptions.readOnly = true;  
			}    
		},
		columns: [
		{
			caption: "STT",
			dataField: "stt",
			width: 50
		},
		{
			caption: "Tên",
			dataField: "ten",
		},
		{
			caption: "Bí danh(Tên hiển thị trên TKB)",
			dataField: "bidanh",
		},
		{
			caption: "Đăng ký buổi nghỉ",
			// dataField: "bidanh",
			cellTemplate: function (container, options) {
				var datarbdkbngv = options.data.rangbuocdangkybuoitietnghigv;
				var datarbdkbngvnew = [];
				datarbdkbngv.map(function(items){
					if(items.tiet == null){
						datarbdkbngvnew.push(items);
					}
				});
				var temp = datarbdkbngvnew.map(function(value) {
					var buoi;
					if(value.buoi == 0){
						buoi = "Sáng";
					}else{
						buoi = "Chiều";
					}
					datarbdkbngvnew.push(value);
					return "Thứ "+value.thu+" - "+buoi+"( Mức: "+value.mamucrangbuoc+")";					
				}).join(", ");
				// console.log(temp);
				$("<div>")
				.attr("id","id")
				// .attr("hidden","hidden")
				.appendTo(container)
				.text(temp)
				.css("white-space", "normal")
				.css("overflow-wrap", 'break-word');

				container.addClass("right");
	                $("<div>")
	                    .dxButton({
	                        stylingMode: "outlined",
					        text: "Chọn buổi nghỉ",
					        type: "danger",
					        width: 120,
	                        onClick: function(e) {
	                        	$("#iddatarbdkbngv").val(JSON.stringify(datarbdkbngvnew));
	                        	dangkybuoinghi(); 
	                            $('#modaldangkybuoinghicuagv').modal('show');

	                            
	                        },
	                    })
	                    .appendTo(container);
			}
		},
		{
			caption: "Đăng ký tiết nghỉ",
			// dataField: "bidanh",
			cellTemplate: function (container, options) {
				var datarbdktngv = options.data.rangbuocdangkybuoitietnghigv;
				var datarbdktngvnew = [];
				datarbdktngv.map(function(items){
					if(items.tiet !=null){
						datarbdktngvnew.push(items);
					}
				})
				var temp = datarbdktngvnew.map(function(value) {
					var buoi;
					if(value.buoi == 0){
						buoi = "Sáng";
					}else{
						buoi = "Chiều";
					}
					datarbdktngvnew.push(value);
					return "Tiết "+value.tiet+" (Thứ "+value.thu+" - "+buoi+"; Mức: "+value.mamucrangbuoc+")";					
				}).join(", ");
				// console.log(temp);
				$("<div>")
				.attr("id","id")
				// .attr("hidden","hidden")
				.appendTo(container)
				.text(temp)
				.css("white-space", "normal")
				.css("overflow-wrap", 'break-word');

				container.addClass("right");
	                $("<div>")
	                    .dxButton({
	                        stylingMode: "outlined",
					        text: "Chọn tiết",
					        type: "default",
					        width: 120,
	                        onClick: function(e) {
	                        	$("#iddatarbdktngv").val(JSON.stringify(datarbdktngvnew)); 
	                			dangkytietnghi();
	                        	$('#modaldangkytietnghicuagv').modal('show');
	                        	                       	       
	                        },
	                    })
	                    .appendTo(container);
			}
		},
		{
			caption: "Hiển thị phân công CM",
			dataField: 'monhoc',
			cellTemplate: function(element, info) {
				var item = info.value;
				var groups = {};
				for (var i = 0; i < item.length; i++) {
					// console.log(tenmonhoc);
					var tenmonhoc = item[i].tenmonhoc;
					if (!groups[tenmonhoc]) {
					    groups[tenmonhoc] = [];
					}
					groups[tenmonhoc].push(item[i].lop);
				}
				var data_new = [];
				for (var tenmonhoc in groups ) {
					// console.log(idmonhoc);
					data_new.push({tenmonhoc: tenmonhoc ,lop: groups[tenmonhoc]});
			  		
				};
				// console.log(data_new);
				var temp = data_new.map(function(value) {
					var item1 = value.lop;
					// console.log(item1);
					var temp1 = item1.map(function(value1){
						// console.log(value1[0].sotiet);
						return value1[0].tenlop+": "+value1[0].sotiet;
					}).join(", ");
					// console.log(temp1);
					return value.tenmonhoc+" ("+temp1+")";					
				}).join(", ");
				// console.log(temp);
				$("<div>")
				.attr("id","noidungpccmid")
				// .attr("hidden","hidden")
				.appendTo(element)
				.text(temp)
				.css("white-space", "normal")
				.css("overflow-wrap", 'break-word');
				// return temp;
			}
		}
		],
			onCellClick: function (e) {
		        var data = e.data;
		        $('#idgv1').val(data.id);
		        $("#idbidanhgv1").text(data.bidanh);
		        $('#idgv2').val(data.id);
		        $("#idbidanhgv2").text(data.bidanh);
		       
		    },
		});

}


function dangkytietnghi(){
		var iddatarbdktngv = $('#iddatarbdktngv').val();
		var datarbdktngv = JSON.parse(iddatarbdktngv);
		var chontietnghi;
		if(datarbdktngv != ''){
			chontietnghi = datarbdktngv;
		}else{
			chontietnghi = [];
		}
		var data1 = [{
		    "idtiet": 1,
		    "tentiet": "Tiết 1",
		    "idbuoi": 0,
		    "tenbuoi": "Sáng"
		},{
		    "idtiet": 1,
		    "tentiet": "Tiết 1",
		    "idbuoi": 1,
		    "tenbuoi": "Chiều"
		},{
		    "idtiet": 2,
		    "tentiet": "Tiết 2",
		    "idbuoi": 0,
		    "tenbuoi": "Sáng"
		},{
		    "idtiet": 2,
		    "tentiet": "Tiết 2",
		    "idbuoi": 1,
		    "tenbuoi": "Chiều"
		},{
		    "idtiet": 3,
		    "tentiet": "Tiết 3",
		    "idbuoi": 0,
		    "tenbuoi": "Sáng"
		},{
		    "idtiet": 3,
		    "tentiet": "Tiết 3",
		    "idbuoi": 1,
		    "tenbuoi": "Chiều"
		},{
		    "idtiet": 4,
		    "tentiet": "Tiết 4",
		    "idbuoi": 0,
		    "tenbuoi": "Sáng"
		},{
		    "idtiet": 4,
		    "tentiet": "Tiết 4",
		    "idbuoi": 1,
		    "tenbuoi": "Chiều"
		},{
		    "idtiet": 5,
		    "tentiet": "Tiết 5",
		    "idbuoi": 0,
		    "tenbuoi": "Sáng"
		},{
		    "idtiet": 5,
		    "tentiet": "Tiết 5",
		    "idbuoi": 1,
		    "tenbuoi": "Chiều"
		}]
		var datamrb = [
		{
		    "idmrb": 0,
		    "tenmuc": "Mức 0"
		},{
		    "idmrb": 1,
		    "tenmuc": "Mức 1"
		},{
		    "idmrb": 2,
		    "tenmuc": "Mức 2"
		},{
		    "idmrb": 3,
		    "tenmuc": "Mức 3"
		},
		];
		var databh = [{
		    "idthu": 2,
		    "tenthu": "Thứ 2"
		},{
		    "idthu": 3,
		    "tenthu": "Thứ 3"
		},{
		    "idthu": 4,
		    "tenthu": "Thứ 4"
		},{
		    "idthu": 5,
		    "tenthu": "Thứ 5"
		},{
		    "idthu": 6,
		    "tenthu": "Thứ 6"
		},{
		    "idthu": 7,
		    "tenthu": "Thứ 7"
		}]
		let bodyTable1 = document.getElementById("tietdangkynghi");
		let countdata1 = data1.length;
		// Render phan than(tbody)
        // Lap theo so lop hoc lon nhat
        for (let i = 0; i < countdata1; i++) {
            tr = document.createElement("tr");
            tr.appendChild(document.createElement('td'));
	        tr.appendChild(document.createElement('td'));
	        tr.appendChild(document.createElement('td'));
	        // trdsbh.setAttribute("class","classdsbh"+i+"");
	        tr.appendChild(document.createElement('td'));//Added for checkbox

	        var checkbox = document.createElement("INPUT"); //Added for checkbox
        	checkbox.type = "checkbox";
        	checkbox.setAttribute("class", "chkbxctid");
        	checkbox.setAttribute("id",i+1);

        	var selectList = document.createElement("select");
        	selectList.setAttribute("class", "form-control input-xs");
        	selectList.setAttribute("id",'idmrb'+(i+1)+'');

			//Create and append the options
			for (var j = 0; j < datamrb.length; j++) {
			    var option = document.createElement("option");
			    option.value = datamrb[j].idmrb;
			    option.text = datamrb[j].tenmuc;
			    selectList.appendChild(option);
			}
			var selectList1 = document.createElement("select");
			selectList1.setAttribute("id",'idthu'+(i+1)+'');
			selectList1.setAttribute("class", "form-control input-sm");
			selectList1.setAttribute("type", "text");
			selectList1.setAttribute("multiple", "multiple");

			for(var k= 0; k< databh.length;k++){
				var option = document.createElement("option");
			    option.value = databh[k].idthu;
			    option.text = databh[k].tenthu;
			    selectList1.appendChild(option);
			}

        	tr.cells[0].appendChild(document.createTextNode(' ' + data1[i].tentiet+"-"+data1[i].tenbuoi));
	        tr.cells[1].appendChild(selectList);
	       	tr.cells[2].appendChild(selectList1); 
	        tr.cells[3].appendChild(checkbox); //Added for checkbox
	        bodyTable1.appendChild(tr); 
        }
        for(var i=0;i<countdata1+1;i++){
        	$('#idthu'+i+'').select2({ width: '100%'});
        }	
		// $('input.chkbxctid').on('change', function() {
		//     $('input.chkbxctid').not(this).prop('checked', false);    
		//     // $('input[type=checkbox]').prop('checked', false);
		//     // $('input.chkbxctclasscb').not(this).prop('checked',false);  
		// });
		if(chontietnghi !=''){
			var table = document.getElementById ('tablechontietdangkynghi');
			var checkboxes = table.querySelectorAll ('input[type=checkbox]');
			var idposition = [];
			var idmrb = [];
			var iddktn = [];
			var idthu1 = [];
			var idthu2 = [];
			var idthu3 = [];
			var idthu4 = [];
			var idthu5 = [];
			var idthu6 = [];
			var idthu7 = [];
			var idthu8 = [];
			var idthu9 = [];
			var idthu10 = [];
			
			chontietnghi.filter(function(items){
				iddktn.push({iddktn:items.id});
				if(items.buoi == 0 && items.tiet == 1){
					idposition.push(1);
					idthu1.push(items.thu); 
					idmrb.push(items.mamucrangbuoc);
				}else if(items.buoi == 1 && items.tiet == 1){
					idposition.push(2);				
					idthu2.push(items.thu); 	
					idmrb.push(items.mamucrangbuoc);
				}else if(items.buoi == 0 && items.tiet == 2){
					idposition.push(3);
					idthu3.push(items.thu); 
					idmrb.push(items.mamucrangbuoc);
				}else if(items.buoi == 1 && items.tiet == 2){
					idposition.push(4);
					idthu4.push(items.thu);
					idmrb.push(items.mamucrangbuoc);
				}else if(items.buoi == 0 && items.tiet == 3){
					idposition.push(5);
					idthu5.push(items.thu); 
					idmrb.push(items.mamucrangbuoc);
				}else if(items.buoi == 1 && items.tiet == 3){
					idposition.push(6);
					idthu6.push(items.thu); 
					idmrb.push(items.mamucrangbuoc);
				}else if(items.buoi == 0 && items.tiet == 4){
					idposition.push(7);
					idthu7.push(items.thu); 
					idmrb.push(items.mamucrangbuoc);
				}else if(items.buoi == 1 && items.tiet == 4){
					idposition.push(8);
					idthu8.push(items.thu);
					idmrb.push(items.mamucrangbuoc);
				}else if(items.buoi == 0 && items.tiet == 5){
					idposition.push(9);
					idthu9.push(items.thu); 
					idmrb.push(items.mamucrangbuoc);
				}else if(items.buoi == 1 && items.tiet == 5){
					idposition.push(10);
					idthu10.push(items.thu); 
					idmrb.push(items.mamucrangbuoc);

				}
			});



			if(idposition !=''){
				var idpositionnew = [...new Set(idposition)];
			}

			for (var i = 0; i < checkboxes.length; i++) {
				var id = checkboxes[i].id;
				for(var j=0; j<idpositionnew.length; j++){
					if (id == idpositionnew[j]) {
						checkboxes[i].checked=true;
					}				
				}	
			}

			if(idmrb !=''){
				var idmrbnew = [...new Set(idmrb)];
			}
			
			var m=0;
			for(k=0;k<idpositionnew.length;k++){
				$('#idmrb'+idpositionnew[k]+'').val(idmrbnew[m]);
				m++;						

			}

			if(idthu1 !=''){
				var idthu1new = [...new Set(idthu1)];
			}
			if(idthu2 !=''){
				var idthu2new = [...new Set(idthu2)];
			}
			if(idthu3 !=''){
				var idthu3new = [...new Set(idthu3)];
			}
			if(idthu4 !=''){
				var idthu4new = [...new Set(idthu4)];
			}
			if(idthu5 !=''){
				var idthu5new = [...new Set(idthu5)];
			}
			if(idthu6 !=''){
				var idthu6new = [...new Set(idthu6)];
			}
			if(idthu7 !=''){
				var idthu7new = [...new Set(idthu7)];
			}
			if(idthu8 !=''){
				var idthu8new = [...new Set(idthu8)];
			}
			if(idthu9 !=''){
				var idthu9new = [...new Set(idthu9)];
			}
			if(idthu10 !=''){
				var idthu10new = [...new Set(idthu10)];
			}
			var idthunew = [{
				"idposition":1,
				"dataposition":idthu1new
			},{
				"idposition":2,
				"dataposition":idthu2new
			},{
				"idposition":3,
				"dataposition":idthu3new
			},{
				"idposition":4,
				"dataposition":idthu4new
			},{
				"idposition":5,
				"dataposition":idthu5new
			},{
				"idposition":6,
				"dataposition":idthu6new
			},{
				"idposition":7,
				"dataposition":idthu7new
			},{
				"idposition":8,
				"dataposition":idthu8new
			},{
				"idposition":9,
				"dataposition":idthu9new
			},{
				"idposition":10,
				"dataposition":idthu10new
			},]
			
			for(var x=0;x<idpositionnew.length;x++){
				var idpst = idpositionnew[x];
				for(var z=0;z<idthunew.length;z++){
					if(idpst == idthunew[z].idposition){
						$('#idthu'+idpst+'').select2({ width: '100%'}).val(idthunew[z].dataposition).trigger("change");						
					}
				}
			}
		
			$('#iddktn').val(JSON.stringify(iddktn)); 
		}
	
}
$('#btnluudangkytietnghicuagv').click(function (){

	var idgv = $('#idgv1').val();
	var iddktn = $('#iddktn').val();
	var datatietnghi = [];
	var table = document.getElementById ('tablechontietdangkynghi');
	var checkboxes = table.querySelectorAll ('input[type=checkbox]');
	for (var i = 0; i < checkboxes.length; i++) {
		if(checkboxes[i].checked == true){
			if(checkboxes[i].id == 1){
				var idthu = [];
				var datathu = $('#idthu1').val();
				datathu.filter(function(items){
					idthu.push({id:items});
				});
				var idmrb = $('#idmrb1').val();
				datatietnghi.push({idgv: idgv,idtiet: 1, idbuoi: 0, idmrb: idmrb, idthu: idthu});
			}else if(checkboxes[i].id == 2){
				var idthu = [];
				var datathu = $('#idthu2').val();
				datathu.filter(function(items){
					idthu.push({id:items});
				});
				var idmrb = $('#idmrb2').val();
				datatietnghi.push({idgv: idgv,idtiet: 1, idbuoi: 1, idmrb: idmrb, idthu: idthu});
			}else if(checkboxes[i].id == 3){
				var idthu = [];
				var datathu = $('#idthu3').val();
				datathu.filter(function(items){
					idthu.push({id:items});
				});
				var idmrb = $('#idmrb3').val();
				datatietnghi.push({idgv: idgv,idtiet: 2, idbuoi: 0, idmrb: idmrb, idthu: idthu});
			}else if(checkboxes[i].id == 4){
				var idthu = [];
				var datathu = $('#idthu4').val();
				datathu.filter(function(items){
					idthu.push({id:items});
				});
				var idmrb = $('#idmrb4').val();
				datatietnghi.push({idgv: idgv,idtiet: 2, idbuoi: 1, idmrb: idmrb, idthu: idthu});
			}else if(checkboxes[i].id == 5){
				var idthu = [];
				var datathu = $('#idthu5').val();
				datathu.filter(function(items){
					idthu.push({id:items});
				});
				var idmrb = $('#idmrb5').val();
				datatietnghi.push({idgv: idgv,idtiet: 3, idbuoi: 0, idmrb: idmrb, idthu: idthu});
			}else if(checkboxes[i].id == 6){
				var idthu = [];
				var datathu = $('#idthu6').val();
				datathu.filter(function(items){
					idthu.push({id:items});
				});
				var idmrb = $('#idmrb6').val();
				datatietnghi.push({idgv: idgv,idtiet: 3, idbuoi: 1, idmrb: idmrb, idthu: idthu});
			}else if(checkboxes[i].id == 7){
				var idthu = [];
				var datathu = $('#idthu7').val();
				datathu.filter(function(items){
					idthu.push({id:items});
				});
				var idmrb = $('#idmrb7').val();
				datatietnghi.push({idgv: idgv,idtiet: 4, idbuoi: 0, idmrb: idmrb, idthu: idthu});
			}else if(checkboxes[i].id == 8){
				var idthu = [];
				var datathu = $('#idthu8').val();
				datathu.filter(function(items){
					idthu.push({id:items});
				});
				var idmrb = $('#idmrb8').val();
				datatietnghi.push({idgv: idgv,idtiet: 4, idbuoi: 1, idmrb: idmrb, idthu: idthu});
			}else if(checkboxes[i].id == 9){
				var idthu = [];
				var datathu = $('#idthu9').val();
				datathu.filter(function(items){
					idthu.push({id:items});
				});
				var idmrb = $('#idmrb9').val();
				datatietnghi.push({idgv: idgv,idtiet: 5, idbuoi: 0, idmrb: idmrb, idthu: idthu});
			}else if(checkboxes[i].id == 10){
				var idthu = [];
				var datathu = $('#idthu10').val();
				datathu.filter(function(items){
					idthu.push({id:items});
				});
				var idmrb = $('#idmrb10').val();
				datatietnghi.push({idgv: idgv,idtiet: 5, idbuoi: 1, idmrb: idmrb, idthu: idthu});
			}
		}
	}


	axios.post('addrangbuocdangkytietnghigv', {
		iddktn: iddktn,
		// idthu: idthu,	
        datatietnghi: JSON.stringify(datatietnghi)
    }).then(function(response) {
        var data = response.data;
        Swal.fire({
            title: 'Lưu',
            text: 'Đã lưu thành công',
            icon: 'success',
            confirmButtonText: 'OK'
        })
        $('#modaldangkytietnghicuagv').modal("hide");
        $('#modaldangkytietnghicuagv').on('hidden.bs.modal', function() {
            $(this).find('#formthemmoitietnghicuagv')[0].reset();
            $('#tablechontietdangkynghi>tbody').empty();
            // $(this).find('#formthemmoirangbuoctietcodinhtiethoc').trigger("reset");
        })
        reloadgvthamgiagiangday1();
    });
});

function dangkybuoinghi(){
	var iddatarbdkbngv = $('#iddatarbdkbngv').val();
	var datarbdkbngv = JSON.parse(iddatarbdkbngv);
	var chonbuoinghi;
	if(datarbdkbngv != ''){
		chonbuoinghi = datarbdkbngv;
	}else{
		chonbuoinghi = [];
	}
	
	var data1 = [{
	    "thu": 2,
	    "buoi": 0
	},{
	    "thu": 2,
	    "buoi": 1
	},{
	    "thu": 3,
	    "buoi": 0
	},{
	    "thu": 3,
	    "buoi": 1
	},{
	    "thu": 4,
	    "buoi": 0
	},{
	    "thu": 4,
	    "buoi": 1
	},{
	    "thu": 5,
	    "buoi": 0
	},{
	    "thu": 5,
	    "buoi": 1
	},{
	    "thu": 6,
	    "buoi": 0
	},{
	    "thu": 6,
	    "buoi": 1
	},{
	    "thu": 7,
	    "buoi": 0
	},{
	    "thu": 7,
	    "buoi": 1
	}]
	$("#girddangkybuoinghicuagv").dxDataGrid({
		dataSource: data1,
		showBorders: true,
		paging: {
			enabled: false
		},
		// selection: {
		// 	mode: "multiple",
		// },
		allowColumnResizing: true,
		columnResizingMode: "widget",
		columns: [{
			caption: "Chọn buổi cho nghỉ",
			cellTemplate: function (container, options) {
				$("<div>").html('<input type="checkbox" id='+options.rowIndex+' value="">').appendTo(container);	
				if(chonbuoinghi !=''){
					var iddkbn = [];
					chonbuoinghi.filter(function(items){
					iddkbn.push({iddkbn:items.id}); 
						if(options.data.buoi == items.buoi && options.data.thu == items.thu){
							document.getElementById(options.rowIndex).checked = true;
						}	
					});
					$('#iddkbn').val(JSON.stringify(iddkbn)); 	
				}
				
				
			},
			width:150,
		},{
			caption: "Buổi",
			calculateCellValue: function(rowData) {
                // console.log(rowData);
         		var buoi = rowData.buoi;
         		var thu = rowData.thu;
         		var tenbuoi;
         		if(buoi == 0){
         			tenbuoi = "Sáng";
         		}else{
         			tenbuoi = "Chiều";
         		}
         		return "Thứ "+thu+" - "+tenbuoi;
            }
		},{
			caption: "Mức ràng buộc",
			cellTemplate: function (container, options) {
				$("<div>").html('<select class="form-control input-xs" id="mucrangbuoc'+options.rowIndex+'"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select>').appendTo(container);
				chonbuoinghi.filter(function(items){ 
					if(options.data.buoi == items.buoi && options.data.thu == items.thu){
						$('#mucrangbuoc'+options.rowIndex+'').val(items.mamucrangbuoc);
					}
				});					
			},
		}],
    });
	
}
$('#btnluudangkybuoinghicuagv').click(function (){

	var idgv = $('#idgv2').val();
	var iddkbn = $('#iddkbn').val();
	var data_buoi_mrb = [];
	var table = document.getElementById ('girddangkybuoinghicuagv');
	var checkboxes = table.querySelectorAll ('input[type=checkbox]');
	var select = table.querySelectorAll ('select');
	for (var i = 0; i < checkboxes.length; i++) {
		if(checkboxes[i].checked == true){
			if(checkboxes[i].id == 0){
				// tiet.push({idt: 1});
				data_buoi_mrb.push({idbuoi: 0,idthu: 2,idmrb: select[i].value});
			}else if(checkboxes[i].id == 1){
				// tiet.push({idt: 2});
				data_buoi_mrb.push({idbuoi: 1,idthu: 2,idmrb: select[i].value});
			}else if(checkboxes[i].id == 2){
				// tiet.push({idt: 3});
				data_buoi_mrb.push({idbuoi: 0,idthu: 3,idmrb: select[i].value});
			}else if(checkboxes[i].id == 3){
				// tiet.push({idt: 4});
				data_buoi_mrb.push({idbuoi: 1,idthu: 3,idmrb: select[i].value});
			}else if(checkboxes[i].id == 4){
				// tiet.push({idt: 5});
				data_buoi_mrb.push({idbuoi: 0,idthu: 4,idmrb: select[i].value});
			}else if(checkboxes[i].id == 5){
				// tiet.push({idt: 5});
				data_buoi_mrb.push({idbuoi: 1,idthu: 4,idmrb: select[i].value});
			}else if(checkboxes[i].id == 6){
				// tiet.push({idt: 5});
				data_buoi_mrb.push({idbuoi: 0,idthu: 5,idmrb: select[i].value});
			}else if(checkboxes[i].id == 7){
				// tiet.push({idt: 5});
				data_buoi_mrb.push({idbuoi: 1,idthu: 5,idmrb: select[i].value});
			}else if(checkboxes[i].id == 8){
				// tiet.push({idt: 5});
				data_buoi_mrb.push({idbuoi: 0,idthu: 6,idmrb: select[i].value});
			}else if(checkboxes[i].id == 9){
				// tiet.push({idt: 5});
				data_buoi_mrb.push({idbuoi: 1,idthu: 6,idmrb: select[i].value});
			}else if(checkboxes[i].id == 4){
				// tiet.push({idt: 5});
				data_buoi_mrb.push({idbuoi: 0,idthu: 7,idmrb: select[i].value});
			}else if(checkboxes[i].id == 4){
				// tiet.push({idt: 5});
				data_buoi_mrb.push({idbuoi: 1,idthu: 7,idmrb: select[i].value});
			}
			
			// var sl = select[i].value;
			// mucrangbuoc.push({idmrb: sl});
		}
	}


	axios.post('addrangbuocdangkybuoinghigv', {
        idgv: idgv,
        iddkbn: iddkbn,
        data_buoi_mrb: JSON.stringify(data_buoi_mrb)
    }).then(function(response) {
        var data = response.data;
        Swal.fire({
            title: 'Lưu',
            text: 'Đã lưu thành công',
            icon: 'success',
            confirmButtonText: 'OK'
        })
        $('#modaldangkybuoinghicuagv').modal("hide");
        $('#modaldangkybuoinghicuagv').on('hidden.bs.modal', function() {
            $(this).find('#formthemmoibuoinghicuagv')[0].reset();
        })
        reloadgvthamgiagiangday1();
    });
});

$('#btndongdangkytietnghicuagv').on('click', function() {
    $('#modaldangkytietnghicuagv').on('hidden.bs.modal', function(e) {
		$(this).find('#formthemmoitietnghicuagv')[0].reset();
		$('#tablechontietdangkynghi>tbody').empty();
    });

});
$('#btndongdangkybuoinghicuagv').on('click', function() {
    $('#modaldangkybuoinghicuagv').on('hidden.bs.modal', function(e) { 
		$(this).find('#formthemmoibuoinghicuagv')[0].reset();
    });

});



jQuery(document).ready(function () {
    jQuery('#modaldangkytietnghicuagv').on('hidden.bs.modal', function (e) {
        $(this).find('#formthemmoitietnghicuagv')[0].reset();
		$('#tablechontietdangkynghi>tbody').empty();
    });
});
